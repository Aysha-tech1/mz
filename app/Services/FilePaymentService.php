<?php

namespace App\Services;

use App\Mail\FileDeliveryMail;
use App\Models\DigitalProduct;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class FilePaymentService
{
    public function __construct(private OmpayGateway $ompay) {}

    public function startCheckout(DigitalProduct $product, string $email): array
    {
        abort_unless($product->is_active && ! $product->is_coming_soon && $product->requiresPayment(), 404);
        abort_unless(filled($product->file_path) && Storage::disk('public')->exists($product->file_path), 404);

        $amount = round((float) $product->price, 3);

        if ($amount <= 0) {
            throw new RuntimeException('سعر الملف غير صالح للدفع.');
        }

        $payment = Payment::query()->create([
            'digital_product_id' => $product->id,
            'email' => $email,
            'amount' => $amount,
            'currency' => config('ompay.currency', 'OMR'),
            'status' => Payment::STATUS_PENDING,
            'reference' => $this->referenceFor($product),
            'gateway' => config('ompay.test_mode') ? 'ompay-test' : 'ompay',
        ]);

        if (config('ompay.test_mode')) {
            $payment->forceFill([
                'status' => Payment::STATUS_PROCESSING,
                'gateway_transaction_id' => 'test-'.$payment->id,
                'gateway_payload' => ['mode' => 'local-test'],
            ])->save();

            return [
                'payment' => $payment,
                'checkout_url' => route('payments.test.show', $payment->reference),
            ];
        }

        $checkout = $this->ompay->createBankHostedCheckout(
            $amount,
            $payment->currency,
            route('payments.return'),
            $payment->reference,
        );

        $payment->forceFill([
            'status' => Payment::STATUS_PROCESSING,
            'gateway_transaction_id' => $checkout['transaction_id'],
            'gateway_payload' => $checkout['raw'],
        ])->save();

        return [
            'payment' => $payment,
            'checkout_url' => $checkout['redirect_url'],
        ];
    }

    public function completeLocalTest(string $reference): Payment
    {
        abort_unless((bool) config('ompay.test_mode'), 404);

        $payment = $this->findPayment(null, $reference);

        abort_unless($payment->gateway === 'ompay-test', 404);

        return $this->markPaid($payment);
    }

    public function settleFromReturn(?string $transactionId, ?string $reference): Payment
    {
        $payment = $this->findPayment($transactionId, $reference);

        $inquiry = $this->ompay->inquire(
            $payment->gateway_transaction_id ?: $transactionId,
            $payment->reference,
        );

        return $this->applyInquiry($payment, $inquiry);
    }

    public function settleFromWebhook(array $payload): ?Payment
    {
        $transactionId = (string) (data_get($payload, 'transaction_id') ?: data_get($payload, 'data.transaction_id') ?: '');
        $reference = (string) (data_get($payload, 'reference_number') ?: data_get($payload, 'data.reference_number') ?: '');

        if (blank($transactionId) && blank($reference)) {
            return null;
        }

        $payment = $this->findPayment($transactionId ?: null, $reference ?: null);
        $inquiry = $this->ompay->inquire(
            $payment->gateway_transaction_id ?: $transactionId ?: null,
            $payment->reference,
        );

        return $this->applyInquiry($payment, $inquiry);
    }

    private function applyInquiry(Payment $payment, array $inquiry): Payment
    {
        if (filled($inquiry['transaction_id']) && filled($payment->gateway_transaction_id)
            && ! hash_equals((string) $payment->gateway_transaction_id, (string) $inquiry['transaction_id'])) {
            throw new RuntimeException('رقم معاملة الدفع غير متطابق.');
        }

        if (filled($inquiry['reference_number'])
            && ! hash_equals((string) $payment->reference, (string) $inquiry['reference_number'])) {
            throw new RuntimeException('مرجع الدفع غير متطابق.');
        }

        if (abs((float) $inquiry['amount'] - (float) $payment->amount) > 0.001) {
            throw new RuntimeException('مبلغ الدفع غير متطابق.');
        }

        if (filled($inquiry['currency']) && strtoupper($inquiry['currency']) !== strtoupper((string) $payment->currency)) {
            throw new RuntimeException('عملة الدفع غير متطابقة.');
        }

        $payment->forceFill([
            'gateway_transaction_id' => $inquiry['transaction_id'] ?: $payment->gateway_transaction_id,
            'gateway_payload' => $inquiry['raw'],
        ]);

        if ($this->ompay->isSuccessfulStatus($inquiry['status'])) {
            return $this->markPaid($payment);
        }

        if ($this->ompay->isFailedStatus($inquiry['status'])) {
            $payment->forceFill(['status' => Payment::STATUS_FAILED])->save();

            return $payment->refresh();
        }

        $payment->forceFill(['status' => Payment::STATUS_PROCESSING])->save();

        return $payment->refresh();
    }

    private function markPaid(Payment $payment): Payment
    {
        $alreadyPaid = false;

        $settled = DB::transaction(function () use ($payment, &$alreadyPaid): Payment {
            /** @var Payment $locked */
            $locked = Payment::query()->whereKey($payment->id)->lockForUpdate()->firstOrFail();

            if ($locked->isPaid()) {
                $alreadyPaid = true;

                return $locked;
            }

            $locked->forceFill([
                'status' => Payment::STATUS_PAID,
                'paid_at' => now(),
            ])->save();

            $product = $locked->digitalProduct()->firstOrFail();
            $product->recordDownload(
                request()->ip(),
                request()->userAgent(),
                $locked->email,
                'sale',
            );

            return $locked;
        });

        if (! $alreadyPaid) {
            $this->sendFileMail($settled);
        }

        return $settled;
    }

    private function sendFileMail(Payment $payment): void
    {
        $product = $payment->digitalProduct;

        if (! $product) {
            return;
        }

        try {
            Mail::to($payment->email)->send(new FileDeliveryMail($product, true, $payment->email));
        } catch (\Throwable $e) {
            report($e);
        }
    }

    private function findPayment(?string $transactionId, ?string $reference): Payment
    {
        $payment = null;

        if (filled($reference)) {
            $payment = Payment::query()->where('reference', $reference)->first();
        }

        if (! $payment && filled($transactionId)) {
            $payment = Payment::query()->where('gateway_transaction_id', $transactionId)->first();
        }

        if (! $payment) {
            throw new RuntimeException('لم يتم العثور على عملية الدفع.');
        }

        return $payment;
    }

    private function referenceFor(DigitalProduct $product): string
    {
        return 'F'.$product->getKey().Str::upper((string) Str::ulid());
    }
}

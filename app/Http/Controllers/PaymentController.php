<?php

namespace App\Http\Controllers;

use App\Models\DigitalProduct;
use App\Models\Payment;
use App\Services\FilePaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class PaymentController extends Controller
{
    public function __construct(private FilePaymentService $payments) {}

    public function checkout(Request $request, DigitalProduct $digitalProduct): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ], [
            'email.required' => 'أدخل بريدك الإلكتروني.',
            'email.email' => 'البريد الإلكتروني غير صحيح.',
        ]);

        try {
            $checkout = $this->payments->startCheckout($digitalProduct, $validated['email']);
        } catch (RuntimeException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'message' => 'تعذر الاتصال ببوابة الدفع. حاول مرة أخرى.',
            ], Response::HTTP_BAD_GATEWAY);
        }

        $request->session()->put('file_email.'.$digitalProduct->id, $validated['email']);
        $request->session()->put('payment_reference', $checkout['payment']->reference);

        return response()->json([
            'checkout_url' => $checkout['checkout_url'],
        ]);
    }

    public function return(Request $request): RedirectResponse|View
    {
        $transactionId = $request->query('transaction_id');
        $reference = $request->query('reference_number', $request->session()->get('payment_reference'));

        try {
            $payment = $this->payments->settleFromReturn(
                is_string($transactionId) ? $transactionId : null,
                is_string($reference) ? $reference : null,
            );
        } catch (RuntimeException $e) {
            return redirect()->route('payments.failed')->with('payment_error', $e->getMessage());
        } catch (Throwable $e) {
            report($e);

            return redirect()->route('payments.failed')->with('payment_error', 'تعذر التحقق من الدفع. إذا تم الخصم، تواصل معنا.');
        }

        if ($payment->isPaid()) {
            return $this->completeDownload($request, $payment);
        }

        if ($payment->isFailed()) {
            return redirect()->route('payments.failed')->with('payment_error', 'لم يتم إكمال الدفع.');
        }

        return view('pay.pending', [
            'payment' => $payment,
        ]);
    }

    public function webhook(Request $request): Response
    {
        try {
            $this->payments->settleFromWebhook($request->all());
        } catch (Throwable $e) {
            report($e);

            return response()->json(['ok' => false], Response::HTTP_BAD_REQUEST);
        }

        return response()->noContent();
    }

    public function failed(): View
    {
        return view('pay.failed');
    }

    public function showTest(string $reference): View
    {
        abort_unless((bool) config('ompay.test_mode'), 404);

        $payment = Payment::query()
            ->where('reference', $reference)
            ->where('gateway', 'ompay-test')
            ->firstOrFail();

        return view('pay.test', compact('payment'));
    }

    public function confirmTest(Request $request, string $reference): RedirectResponse
    {
        abort_unless((bool) config('ompay.test_mode'), 404);

        $payment = $this->payments->completeLocalTest($reference);

        return $this->completeDownload($request, $payment);
    }

    private function completeDownload(Request $request, Payment $payment): RedirectResponse
    {
        $product = $payment->digitalProduct;

        abort_unless($product, 404);

        $request->session()->put('file_unlock.'.$product->id, true);
        $request->session()->put('file_email.'.$product->id, $payment->email);
        $request->session()->forget('payment_reference');

        return redirect()->away($product->signedDownloadUrl($payment->email));
    }
}

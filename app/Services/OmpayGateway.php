<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class OmpayGateway
{
    public function isConfigured(): bool
    {
        return filled(config('ompay.key')) && filled(config('ompay.secret'));
    }

    public function createBankHostedCheckout(float $amount, string $currency, string $returnUrl, string $reference): array
    {
        $this->assertConfigured();

        $response = $this->client()->post($this->url('/api/v1/transactions/bank-hosted'), [
            'amount' => round($amount, 3),
            'currency' => strtoupper($currency),
            'return_url' => $returnUrl,
            'reference_number' => $reference,
        ]);

        $data = $this->payload($response);

        $redirectUrl = data_get($data, 'data.redirect_url');
        $transactionId = data_get($data, 'data.transaction_id');

        if (! $response->successful() || blank($redirectUrl) || blank($transactionId)) {
            throw new RuntimeException($this->errorMessage($data, 'تعذر بدء عملية الدفع. حاول مرة أخرى.'));
        }

        return [
            'transaction_id' => (string) $transactionId,
            'redirect_url' => (string) $redirectUrl,
            'status' => (string) data_get($data, 'data.status', 'PROCESSING'),
            'raw' => $data,
        ];
    }

    public function inquire(?string $transactionId = null, ?string $reference = null): array
    {
        $this->assertConfigured();

        if (blank($transactionId) && blank($reference)) {
            throw new RuntimeException('لا يمكن التحقق من الدفع بدون رقم المعاملة.');
        }

        $body = filled($transactionId)
            ? ['transaction_id' => $transactionId]
            : ['reference_number' => $reference];

        $response = $this->client()->post($this->url('/api/v1/transactions/inquiry'), $body);
        $data = $this->payload($response);

        if (! $response->successful() || data_get($data, 'success') === false) {
            throw new RuntimeException($this->errorMessage($data, 'تعذر التحقق من حالة الدفع.'));
        }

        $payload = data_get($data, 'data', []);

        return [
            'transaction_id' => (string) data_get($payload, 'transaction_id', ''),
            'reference_number' => (string) data_get($payload, 'reference_number', ''),
            'status' => strtoupper((string) data_get($payload, 'status', '')),
            'amount' => (float) data_get($payload, 'amount', 0),
            'currency' => strtoupper((string) data_get($payload, 'currency', '')),
            'raw' => $data,
        ];
    }

    public function isSuccessfulStatus(string $status): bool
    {
        return in_array(strtoupper($status), ['SUCCESSFUL', 'SUCCESS', 'PAID', 'CAPTURED'], true);
    }

    public function isFailedStatus(string $status): bool
    {
        return in_array(strtoupper($status), ['FAILED', 'FAILURE', 'DECLINED', 'CANCELLED', 'CANCELED', 'EXPIRED'], true);
    }

    private function client()
    {
        return Http::withHeaders([
            'OMPAY-API-Key' => (string) config('ompay.key'),
            'OMPAY-API-Secret' => (string) config('ompay.secret'),
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->timeout((int) config('ompay.timeout', 30))->acceptJson();
    }

    private function url(string $path): string
    {
        return rtrim((string) config('ompay.base_url'), '/').$path;
    }

    private function payload(Response $response): array
    {
        $json = $response->json();

        return is_array($json) ? $json : [];
    }

    private function errorMessage(array $data, string $fallback): string
    {
        $message = data_get($data, 'error_message')
            ?: data_get($data, 'message')
            ?: data_get($data, 'error')
            ?: data_get($data, 'data.error_message');

        $message = filled($message) ? (string) $message : $fallback;

        return match (true) {
            str_contains($message, 'not valid'),
            str_contains($message, 'INVALID_CREDENTIALS') => 'مفاتيح بوابة الدفع غير صحيحة أو لا تطابق بيئة التشغيل.',
            default => $message,
        };
    }

    private function assertConfigured(): void
    {
        if ($this->isConfigured()) {
            return;
        }

        throw new RuntimeException('بوابة الدفع غير مهيأة. أضف مفتاح OMpay الأول والثاني في ملف البيئة.');
    }
}

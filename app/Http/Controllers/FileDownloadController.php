<?php

namespace App\Http\Controllers;

use App\Mail\FileDeliveryMail;
use App\Models\DigitalProduct;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FileDownloadController extends Controller
{
    public function claim(Request $request, DigitalProduct $digitalProduct): JsonResponse
    {
        abort_unless($digitalProduct->is_active && ! $digitalProduct->is_coming_soon, 404);

        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ], [
            'email.required' => 'أدخل بريدك الإلكتروني.',
            'email.email' => 'البريد الإلكتروني غير صحيح.',
        ]);

        $canDownload = $digitalProduct->is_free
            && filled($digitalProduct->file_path)
            && Storage::disk('public')->exists($digitalProduct->file_path);

        $digitalProduct->recordDownload(
            $request->ip(),
            $request->userAgent(),
            $validated['email'],
            $canDownload ? 'download' : 'lead',
        );

        try {
            Mail::to($validated['email'])->send(new FileDeliveryMail($digitalProduct, $canDownload));
        } catch (\Throwable $e) {
            report($e);
        }

        if ($canDownload) {
            $request->session()->put('file_unlock.'.$digitalProduct->id, true);

            return response()->json([
                'download_url' => $digitalProduct->downloadUrl(),
            ]);
        }

        return response()->json([
            'download_url' => route('digital-products.show', $digitalProduct),
        ]);
    }

    public function download(Request $request, string $file): BinaryFileResponse|RedirectResponse
    {
        $product = DigitalProduct::query()
            ->where('is_active', true)
            ->where('is_free', true)
            ->where('is_coming_soon', false)
            ->get()
            ->first(fn (DigitalProduct $product): bool => $product->asciiDownloadFilename() === $file);

        abort_unless($product && filled($product->file_path) && Storage::disk('public')->exists($product->file_path), 404);

        if (! $request->session()->get('file_unlock.'.$product->id) && ! $request->hasValidSignature()) {
            return redirect('/#start');
        }

        return $product->downloadResponse();
    }
}

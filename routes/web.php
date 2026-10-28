<?php

use Illuminate\Support\Facades\Route;
use App\Models\ConsultationType;
use App\Models\Availability;
use App\Models\Booking;
use App\Models\DigitalProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    $consultationTypes = ConsultationType::where('is_active', true)->get();
    $availabilities = Availability::where('is_booked', false)
        ->where('date', '>=', now()->toDateString())
        ->get()
        ->groupBy('date');
    $digitalProducts = DigitalProduct::active()->get();

    return view('welcome', compact('consultationTypes', 'availabilities', 'digitalProducts'));
});

Route::get('/files/{digitalProduct}', function (DigitalProduct $digitalProduct) {
    abort_unless($digitalProduct->is_active, 404);

    if (filled($digitalProduct->slug) && request()->segment(2) !== $digitalProduct->slug) {
        return redirect()->route('digital-products.show', $digitalProduct, 301);
    }

    return view('pages.digital-product', compact('digitalProduct'));
})->name('digital-products.show');

Route::get('/dl/{file}', function (string $file) {
    $product = DigitalProduct::query()
        ->where('is_active', true)
        ->where('is_free', true)
        ->where('is_coming_soon', false)
        ->get()
        ->first(fn (DigitalProduct $product): bool => $product->asciiDownloadFilename() === $file);

    abort_unless($product && filled($product->file_path) && Storage::disk('public')->exists($product->file_path), 404);

    $product->recordDownload();

    return $product->downloadResponse();
})->where('file', '[A-Za-z0-9][A-Za-z0-9._-]*\.[A-Za-z0-9]+')->name('digital-products.download');

Route::get('/files/{digitalProduct}/download/{file}', function (DigitalProduct $digitalProduct, string $file) {
    abort_unless($digitalProduct->asciiDownloadFilename() === $file, 404);

    return redirect()->to($digitalProduct->downloadUrl(), 301);
})->where('file', '[A-Za-z0-9][A-Za-z0-9._-]*\.[A-Za-z0-9]+');

Route::get('/files/{digitalProduct}/download', function (DigitalProduct $digitalProduct) {
    abort_unless($digitalProduct->is_active && $digitalProduct->is_free && ! $digitalProduct->is_coming_soon, 404);
    abort_unless(filled($digitalProduct->file_path) && Storage::disk('public')->exists($digitalProduct->file_path), 404);

    return redirect()->to($digitalProduct->downloadUrl(), 301);
});

Route::post('/bookings', function (Request $request) {
    $validated = $request->validate([
        'consultation_type_id' => 'required|exists:consultation_types,id',
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:255',
        'topic' => 'required|string',
        'date' => 'required|date',
        'time' => 'required',
    ]);

    Booking::create($validated);

    // Mark availability as booked
    Availability::where('date', $validated['date'])
        ->where('start_time', $validated['time'])
        ->update(['is_booked' => true]);

    return back()->with('success', 'تم استلام طلبك بنجاح! سنتواصل معك قريباً.');
})->name('bookings.store');

Route::get('/privacy', function () {
    return view('pages.privacy');
})->name('privacy');

Route::get('/refund', function () {
    return view('pages.refund');
})->name('refund');

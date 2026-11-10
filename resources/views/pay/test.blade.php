@extends('layouts.app')

@section('content')
    <section class="py-16 sm:py-24">
        <div class="wrap max-w-md">
            <div class="bg-white border border-line rounded-3xl p-6 sm:p-8 text-center shadow-soft">
                <p class="pill mb-4">تجربة محلية · بلا خصم</p>
                <h1 class="text-2xl font-bold mb-2">محاكاة الدفع</h1>
                <p class="text-muted mb-6 leading-relaxed">هذه الصفحة بدل OMpay على جهازك فقط. لن تُخصم فلوس.</p>
                <p class="font-bold text-lg mb-1">{{ $payment->digitalProduct?->title }}</p>
                <p class="text-accent font-bold text-xl mb-8">{{ number_format((float) $payment->amount, 3) }} ر.ع.</p>
                <form method="POST" action="{{ route('payments.test.confirm', $payment->reference) }}">
                    @csrf
                    <button type="submit" class="btn btn-acc w-full">تأكيد التجربة وتنزيل الملف</button>
                </form>
            </div>
        </div>
    </section>
@endsection

@extends('layouts.app')

@section('content')
    <section class="py-16 sm:py-24">
        <div class="wrap max-w-lg text-center">
            <h1 class="text-2xl sm:text-3xl font-bold mb-4">لم يكتمل الدفع</h1>
            <p class="text-muted mb-8 leading-relaxed">{{ session('payment_error') ?: 'يمكنك المحاولة مرة أخرى من صفحة الملف.' }}</p>
            <a href="{{ url('/#start') }}" class="btn btn-acc">العودة للملفات</a>
        </div>
    </section>
@endsection

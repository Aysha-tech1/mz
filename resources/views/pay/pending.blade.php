@extends('layouts.app')

@section('content')
    <section class="py-16 sm:py-24">
        <div class="wrap max-w-lg text-center">
            <h1 class="text-2xl sm:text-3xl font-bold mb-4">جارٍ تأكيد الدفع</h1>
            <p class="text-muted mb-8 leading-relaxed">لا تغلق هذه الصفحة. نتحقق من بوابة الدفع ثم يبدأ تنزيل الملف تلقائيًا.</p>
            <p class="text-sm text-muted">المرجع: <span dir="ltr">{{ $payment->reference }}</span></p>
        </div>
    </section>
    <script>
        setTimeout(function () {
            window.location.replace(@json(route('payments.return', ['reference_number' => $payment->reference])));
        }, 3000);
    </script>
@endsection

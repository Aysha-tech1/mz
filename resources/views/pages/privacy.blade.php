@extends('layouts.app')

@section('content')
    <section class="py-12 sm:py-16 lg:py-20 bg-surface">
        <div class="wrap max-w-4xl">
            <!-- Header -->
            <div class="text-center mb-16">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-accent/10 mb-6">
                    <svg class="w-10 h-10 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-4 text-primary">سياسة <span class="text-accent">الخصوصية</span></h1>
                <p class="text-muted text-lg max-w-2xl mx-auto">
                    نحن نحترم خصوصيتك ونلتزم بحماية بياناتك الشخصية
                </p>
            </div>

            <!-- Main Content -->
            <div class="space-y-6">
                <!-- Introduction Card -->
                <div class="bg-white border border-line rounded-3xl p-8 lg:p-10">
                    <p class="text-muted leading-relaxed text-lg">
                        نموذج مبدئي قابل للتعديل. نجمع الاسم والبريد ورقم التواصل فقط لإتمام الطلبات والحجوزات، ولا نبيع بياناتك. يجب مراجعة هذا النص قانونيًا قبل الإطلاق.
                    </p>
                </div>

                <!-- Data Collection -->
                <div class="bg-white border border-line rounded-3xl p-8 lg:p-10 hover:border-accent transition-all duration-300">
                    <div class="flex items-start gap-4 mb-6">
                        <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-accent/10 flex items-center justify-center">
                            <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold mb-2">البيانات التي نجمعها</h2>
                            <p class="text-muted">المعلومات الشخصية التي نحتاجها لتقديم خدماتنا</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mr-0">
                        <div class="bg-surface border border-line rounded-2xl p-4 text-center">
                            <div class="text-accent font-bold mb-1">الاسم الكامل</div>
                            <div class="text-xs text-muted">للتعريف بك</div>
                        </div>
                        <div class="bg-surface border border-line rounded-2xl p-4 text-center">
                            <div class="text-accent font-bold mb-1">البريد الإلكتروني</div>
                            <div class="text-xs text-muted">للتواصل معك</div>
                        </div>
                        <div class="bg-surface border border-line rounded-2xl p-4 text-center">
                            <div class="text-accent font-bold mb-1">رقم التواصل</div>
                            <div class="text-xs text-muted">الهاتف/واتساب</div>
                        </div>
                    </div>
                </div>

                <!-- Data Usage -->
                <div class="bg-white border border-line rounded-3xl p-8 lg:p-10 hover:border-accent transition-all duration-300">
                    <div class="flex items-start gap-4 mb-6">
                        <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-accent/10 flex items-center justify-center">
                            <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold mb-2">استخدام البيانات</h2>
                            <p class="text-muted">كيف نستخدم معلوماتك لتحسين تجربتك</p>
                        </div>
                    </div>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-3 text-muted">
                            <span class="w-2 h-2 rounded-full bg-accent"></span>
                            إتمام الطلبات والحجوزات
                        </li>
                        <li class="flex items-center gap-3 text-muted">
                            <span class="w-2 h-2 rounded-full bg-accent"></span>
                            التواصل معك بخصوص طلبك
                        </li>
                        <li class="flex items-center gap-3 text-muted">
                            <span class="w-2 h-2 rounded-full bg-accent"></span>
                            تحسين خدماتنا
                        </li>
                    </ul>
                </div>

                <!-- Security -->
                <div class="bg-white border border-line rounded-3xl p-8 lg:p-10 hover:border-accent transition-all duration-300">
                    <div class="flex items-start gap-4 mb-6">
                        <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-accent/10 flex items-center justify-center">
                            <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold mb-2">الأمان</h2>
                            <p class="text-muted">حماية بياناتك أولويتنا</p>
                        </div>
                    </div>
                    <p class="text-muted leading-relaxed">
                        نحن نحرص على حماية بياناتك ونستخدم إجراءات أمنية مناسبة لمنع الوصول غير المصرح به.
                    </p>
                </div>

                <!-- Data Sharing -->
                <div class="bg-white border border-line rounded-3xl p-8 lg:p-10 hover:border-accent transition-all duration-300">
                    <div class="flex items-start gap-4 mb-6">
                        <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-accent/10 flex items-center justify-center">
                            <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold mb-2">مشاركة البيانات</h2>
                            <p class="text-muted">بياناتك تبقى معك</p>
                        </div>
                    </div>
                    <p class="text-muted leading-relaxed">
                        لا نبيع بياناتك لأي طرف ثالث. نشارك البيانات فقط عند الضرورة لإتمام الخدمة المطلوبة.
                    </p>
                </div>

                <!-- Contact -->
                <div class="bg-white border border-accent rounded-3xl p-8 lg:p-10">
                    <div class="flex items-start gap-4 mb-6">
                        <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-accent/20 flex items-center justify-center">
                            <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold mb-2">التواصل معنا</h2>
                            <p class="text-muted">نحن هنا لمساعدتك</p>
                        </div>
                    </div>
                    <p class="text-muted leading-relaxed">
                        إذا كان لديك أي استفسار بخصوص سياسة الخصوصية، يمكنك التواصل معنا عبر البريد الإلكتروني.
                    </p>
                </div>
            </div>

            <!-- Back Button -->
            <div class="mt-12 text-center">
                <a href="/" class="btn btn-acc inline-flex items-center gap-2">
                    <svg class="w-5 h-5 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                    العودة للرئيسية
                </a>
            </div>
        </div>
    </section>
@endsection

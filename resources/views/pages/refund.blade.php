@extends('layouts.app')

@section('content')
    <section class="py-12 sm:py-16 lg:py-20 bg-surface">
        <div class="wrap max-w-4xl">
            <!-- Header -->
            <div class="text-center mb-16">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-accent/10 mb-6">
                    <svg class="w-10 h-10 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </div>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-4 text-primary">سياسة <span class="text-accent">الاسترجاع</span></h1>
                <p class="text-muted text-lg max-w-2xl mx-auto">
                    شروط واضحة ومباشرة لاسترجاع المنتجات الرقمية
                </p>
            </div>

            <!-- Main Content -->
            <div class="space-y-6">
                <!-- Introduction Card -->
                <div class="bg-white border border-line rounded-3xl p-8 lg:p-10">
                    <p class="text-muted leading-relaxed text-lg">
                        نموذج مبدئي قابل للتعديل. تُسلَّم المنتجات الرقمية فور تأكيد الدفع. تُحدَّد شروط الاسترجاع هنا بما يتوافق مع الأنظمة المعمول بها في سلطنة عُمان، ولا يُفترض أن جميع المشتريات غير قابلة للاسترجاع.
                    </p>
                </div>

                <!-- Digital Products -->
                <div class="bg-white border border-line rounded-3xl p-8 lg:p-10 hover:border-accent transition-all duration-300">
                    <div class="flex items-start gap-4 mb-6">
                        <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-accent/10 flex items-center justify-center">
                            <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold mb-2">المنتجات الرقمية</h2>
                            <p class="text-muted">ما نقدمه من منتجات رقمية</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-surface border border-line rounded-2xl p-4 flex items-center gap-3">
                            <span class="w-2 h-2 rounded-full bg-accent"></span>
                            <span class="text-muted">الأدلة والملفات التعليمية</span>
                        </div>
                        <div class="bg-surface border border-line rounded-2xl p-4 flex items-center gap-3">
                            <span class="w-2 h-2 rounded-full bg-accent"></span>
                            <span class="text-muted">نماذج الأعمال الجاهزة</span>
                        </div>
                        <div class="bg-surface border border-line rounded-2xl p-4 flex items-center gap-3">
                            <span class="w-2 h-2 rounded-full bg-accent"></span>
                            <span class="text-muted">الدورات المسجلة</span>
                        </div>
                        <div class="bg-surface border border-line rounded-2xl p-4 flex items-center gap-3">
                            <span class="w-2 h-2 rounded-full bg-accent"></span>
                            <span class="text-muted">الاستشارات (شروط خاصة)</span>
                        </div>
                    </div>
                </div>

                <!-- Refund Conditions -->
                <div class="bg-white border border-line rounded-3xl p-8 lg:p-10 hover:border-accent transition-all duration-300">
                    <div class="flex items-start gap-4 mb-6">
                        <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-accent/10 flex items-center justify-center">
                            <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold mb-2">شروط الاسترجاع</h2>
                            <p class="text-muted">متى يمكنك طلب استرجاع؟</p>
                        </div>
                    </div>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3 text-muted">
                            <span class="w-2 h-2 rounded-full bg-accent mt-2 flex-shrink-0"></span>
                            <span>المنتجات الرقمية غير قابلة للاسترجاع بعد التحميل</span>
                        </li>
                        <li class="flex items-start gap-3 text-muted">
                            <span class="w-2 h-2 rounded-full bg-accent mt-2 flex-shrink-0"></span>
                            <span>في حالة وجود مشكلة تقنية، يُمكن طلب دعم فني</span>
                        </li>
                        <li class="flex items-start gap-3 text-muted">
                            <span class="w-2 h-2 rounded-full bg-accent mt-2 flex-shrink-0"></span>
                            <span>الاستشارات: يمكن إلغاء الجلسة قبل 24 ساعة من الموعد</span>
                        </li>
                        <li class="flex items-start gap-3 text-muted">
                            <span class="w-2 h-2 rounded-full bg-accent mt-2 flex-shrink-0"></span>
                            <span>في حالة تأكيد الاستشارة، لا يُسمح بالاسترجاع</span>
                        </li>
                    </ul>
                </div>

                <!-- Refund Process -->
                <div class="bg-white border border-line rounded-3xl p-8 lg:p-10 hover:border-accent transition-all duration-300">
                    <div class="flex items-start gap-4 mb-6">
                        <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-accent/10 flex items-center justify-center">
                            <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold mb-2">عملية الاسترجاع</h2>
                            <p class="text-muted">خطوات بسيطة وسريعة</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center gap-4 bg-surface border border-line rounded-2xl p-4">
                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-accent text-primary font-bold flex items-center justify-center">1</div>
                            <span class="text-muted">تواصل معنا عبر البريد الإلكتروني</span>
                        </div>
                        <div class="flex items-center gap-4 bg-surface border border-line rounded-2xl p-4">
                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-accent text-primary font-bold flex items-center justify-center">2</div>
                            <span class="text-muted">اشرح المشكلة بالتفصيل</span>
                        </div>
                        <div class="flex items-center gap-4 bg-surface border border-line rounded-2xl p-4">
                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-accent text-primary font-bold flex items-center justify-center">3</div>
                            <span class="text-muted">سيتم مراجعة طلبك خلال 3-5 أيام عمل</span>
                        </div>
                        <div class="flex items-center gap-4 bg-surface border border-line rounded-2xl p-4">
                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-accent text-primary font-bold flex items-center justify-center">4</div>
                            <span class="text-muted">في حالة الموافقة، سيتم رد المبلغ خلال 7-10 أيام عمل</span>
                        </div>
                    </div>
                </div>

                <!-- Exceptions -->
                <div class="bg-white border border-line rounded-3xl p-8 lg:p-10 hover:border-accent transition-all duration-300">
                    <div class="flex items-start gap-4 mb-6">
                        <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-accent/10 flex items-center justify-center">
                            <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold mb-2">الاستثناءات</h2>
                            <p class="text-muted">الحالات التي لا يُسمح فيها بالاسترجاع</p>
                        </div>
                    </div>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-3 text-muted">
                            <span class="w-2 h-2 rounded-full bg-red-500"></span>
                            الملفات التي تم تحميلها بنجاح
                        </li>
                        <li class="flex items-center gap-3 text-muted">
                            <span class="w-2 h-2 rounded-full bg-red-500"></span>
                            الاستشارات المؤكدة والمكتملة
                        </li>
                        <li class="flex items-center gap-3 text-muted">
                            <span class="w-2 h-2 rounded-full bg-red-500"></span>
                            تغيير الرأي بعد الشراء
                        </li>
                    </ul>
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
                        لأي استفسارات بخصوص الاسترجاع، يرجى التواصل معنا عبر البريد الإلكتروني.
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

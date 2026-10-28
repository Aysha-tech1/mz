@extends('layouts.app')

@section('content')
    <section class="hero relative overflow-hidden bg-primary text-white">
        <div class="hero-orb hero-orb-a" aria-hidden="true"></div>
        <div class="hero-orb hero-orb-b" aria-hidden="true"></div>
        <div class="absolute inset-0 opacity-25 mesh-grid pointer-events-none"></div>

        <div class="wrap relative h-full grid grid-cols-1 lg:grid-cols-[1.15fr_0.85fr] gap-8 lg:gap-12 items-center py-8 lg:py-8">
            <div class="min-w-0">
                <span class="pill hero-rise mb-4" style="--d: 0s">متاح الآن · 3 ملفات مجانية</span>
                <h1 class="hero-rise text-[1.75rem] sm:text-4xl lg:text-[3.15rem] font-bold leading-[1.28] mb-4" style="--d: .08s">
                    ابدأ تجارتك الإلكترونية
                    <span class="hero-accent">على أساس صحيح</span>
                </h1>
                <p class="hero-rise text-sm sm:text-lg text-white/70 leading-relaxed mb-6 max-w-lg" style="--d: .16s">
                    أدلة عملية وأدوات جاهزة تساعدك على اختيار فكرتك، تأسيس متجرك، وتطوير مشروعك بثقة.
                </p>

                <div class="hero-rise flex flex-col sm:flex-row items-stretch sm:items-center gap-3 mb-6" style="--d: .24s">
                    <a href="#start" class="btn btn-acc w-full sm:w-auto">ابدأ من هنا</a>
                    <a href="#consult" class="btn btn-line-light w-full sm:w-auto">احجز استشارة</a>
                </div>

                <div class="hero-rise flex flex-wrap items-center gap-2 sm:gap-3" style="--d: .32s">
                    <span class="hero-chip"><b>8</b> خطوات عملية</span>
                    <span class="hero-chip"><b class="text-accent">3</b> مجانية</span>
                    <span class="hero-chip"><b>15</b> ر.ع. للاستشارة</span>
                </div>
                <p class="hero-rise text-[11px] text-white/40 mt-4" style="--d: .4s">الأسعار بالريال العُماني · تنزيل فوري بعد تأكيد الدفع</p>
            </div>

            <div id="about" class="hero-rise relative mx-auto w-full max-w-md lg:max-w-none lg:h-full" style="--d: .18s">
                <div class="hero-portrait">
                    <img src="{{ asset('images/hero.png') }}" alt="محمود الدرعي" class="hero-portrait-img">
                    <div class="hero-portrait-fade"></div>
                    <div class="hero-id">
                        <p class="font-bold text-sm sm:text-base">محمود الدرعي</p>
                        <p class="text-accent text-[11px] sm:text-xs mt-0.5">مختص في التجارة الإلكترونية والمتاجر الرقمية</p>
                    </div>
                </div>
                <div class="hero-float-card">
                    <span class="hero-dot"></span>
                    ملف مجاني للبداية
                </div>
            </div>
        </div>

        <a href="#start" class="hero-scroll hidden lg:flex" aria-label="انتقل إلى الملفات">
            <span></span>
        </a>
    </section>

    <section id="start" class="py-12 sm:py-16 lg:py-20 bg-surface relative overflow-hidden">
        <div class="orb -left-16 top-10 w-72 h-72 bg-accent/15"></div>
        <div class="orb -right-10 bottom-10 w-80 h-80 bg-accent/10"></div>
        <div class="wrap relative">
            <div class="text-center max-w-2xl mx-auto mb-8 sm:mb-14">
                <span class="pill mb-4">الملفات والأدوات</span>
                <h2 class="text-2xl sm:text-3xl lg:text-5xl font-bold mb-3 sm:mb-4">ابدأ من هنا</h2>
                <p class="text-muted text-base sm:text-lg">ثماني خطوات من الفكرة إلى متجر يعمل. اختر الخطوة التي تناسبك الآن.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($digitalProducts as $product)
                    <article @class([
                        'file-card',
                        'file-card-featured' => $product->is_featured,
                    ])>
                        <div class="flex items-start justify-between gap-4 mb-4">
                            <span class="file-number shrink-0">{{ $product->step_number }}</span>
                            <div class="min-w-0 flex-1 text-right">
                                <h3 class="text-lg sm:text-xl font-bold mb-2 leading-snug">{{ $product->title }}</h3>
                                <p @class(['text-sm leading-relaxed', 'text-primary/70' => $product->is_featured, 'text-muted' => ! $product->is_featured])>
                                    {{ $product->description }}
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-3 mb-6 text-sm">
                            <span @class(['font-medium', 'text-primary/80' => $product->is_featured, 'text-secondary' => ! $product->is_featured])>
                                {{ $product->label }}
                            </span>
                            <a href="{{ route('digital-products.show', $product) }}" class="inline-flex items-center gap-1.5 text-accent font-bold">
                                <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                                التفاصيل
                            </a>
                            @if($product->savingsAmount())
                                <span class="text-xs font-bold {{ $product->is_featured ? 'text-primary' : 'text-accent' }}">
                                    عرض خاص · وفر {{ $product->savingsAmount() }}
                                </span>
                            @endif
                        </div>

                        <div class="flex flex-wrap items-center justify-between gap-3 mt-auto pt-2">
                            <div class="flex items-baseline gap-2">
                                @if($product->displayOldPrice())
                                    <span class="text-sm line-through opacity-50">{{ $product->displayOldPrice() }}</span>
                                @endif
                                <span class="font-bold text-lg">{{ $product->displayPrice() }}</span>
                            </div>

                            @if($product->is_coming_soon)
                                <span class="file-cta file-cta-soon">قريبًا</span>
                            @elseif($product->is_free && $product->fileUrl())
                                <a href="{{ route('digital-products.download', $product) }}" class="file-cta">تحميل مجاني</a>
                            @else
                                <a href="{{ route('digital-products.show', $product) }}" class="file-cta">{{ $product->ctaLabel() }}</a>
                            @endif
                        </div>
                    </article>
                @empty
                    <p class="text-muted col-span-full text-center">سيتم إضافة الملفات قريبًا.</p>
                @endforelse
            </div>
        </div>
    </section>

    <section id="consult" class="py-12 sm:py-16 lg:py-20 bg-primary text-white relative overflow-hidden">
        <div class="orb right-0 top-0 w-[420px] h-[420px] bg-accent/15"></div>
        <div class="orb -left-20 bottom-0 w-80 h-80 bg-accent/20"></div>
        <div class="wrap relative">
            @if(session('success'))
                <div class="bg-accent/15 border border-accent text-primary p-6 rounded-2xl mb-8 text-center font-bold">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white text-primary border border-white/10 rounded-3xl sm:rounded-[40px] p-5 sm:p-8 lg:p-14 shadow-soft relative overflow-hidden">
                <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-l from-accent via-accent-hover to-primary"></div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16">
                    <div>
                        <span class="pill mb-4 sm:mb-5">جلسة مباشرة</span>
                        <h2 class="text-2xl sm:text-3xl lg:text-5xl font-bold mb-4 sm:mb-6 leading-tight">تحتاج استشارة خاصة لمشروعك؟</h2>
                        <p class="text-muted text-base sm:text-lg mb-8 sm:mb-10 leading-relaxed">
                            جلسة مباشرة نركّز فيها على سؤالك. اختر المدة واليوم والوقت المناسب لك. المواعيد بتوقيت سلطنة عُمان.
                        </p>

                        <div class="space-y-5">
                            <div class="flex items-start gap-4 bg-surface rounded-2xl p-4 border border-line">
                                <div class="w-10 h-10 rounded-xl bg-accent flex items-center justify-center text-primary shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-lg">مدة الجلسة</h4>
                                    <p class="text-muted">30 أو 60 دقيقة حسب احتياجك</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4 bg-surface rounded-2xl p-4 border border-line">
                                <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center text-accent shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-lg">جدول مرن</h4>
                                    <p class="text-muted">اختر الموعد الذي يناسبك من التقويم</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-surface rounded-2xl sm:rounded-3xl p-4 sm:p-8 border border-line" x-data="{
                        step: 1,
                        selectedType: null,
                        selectedDate: null,
                        selectedTime: null,
                        currentMonth: new Date(),
                        availabilities: {{ json_encode($availabilities) }},
                        types: {{ json_encode($consultationTypes) }},
                        get availableDates() {
                            return Object.keys(this.availabilities);
                        },
                        get calendarDays() {
                            const year = this.currentMonth.getFullYear();
                            const month = this.currentMonth.getMonth();
                            const firstDay = new Date(year, month, 1);
                            const lastDay = new Date(year, month + 1, 0);
                            const startDay = firstDay.getDay();
                            const totalDays = lastDay.getDate();
                            const days = [];
                            for (let i = 0; i < startDay; i++) {
                                days.push({ day: null, date: null, available: false });
                            }
                            for (let day = 1; day <= totalDays; day++) {
                                const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                                const available = this.availableDates.includes(dateStr);
                                days.push({ day, date: dateStr, available });
                            }
                            return days;
                        },
                        prevMonth() {
                            this.currentMonth = new Date(this.currentMonth.getFullYear(), this.currentMonth.getMonth() - 1);
                        },
                        nextMonth() {
                            this.currentMonth = new Date(this.currentMonth.getFullYear(), this.currentMonth.getMonth() + 1);
                        },
                        formatDate(dateStr) {
                            const date = new Date(dateStr);
                            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                            return date.toLocaleDateString('ar-OM', options);
                        }
                    }">
                        <h3 class="text-lg sm:text-xl font-bold mb-4 sm:mb-6 text-center" x-text="step === 1 ? 'اختر التاريخ' : (step === 2 ? 'اختر نوع الاستشارة' : (step === 3 ? 'اختر الوقت' : 'أدخل بياناتك'))"></h3>

                        <form action="{{ route('bookings.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="consultation_type_id" :value="selectedType">
                            <input type="hidden" name="date" :value="selectedDate">
                            <input type="hidden" name="time" :value="selectedTime">

                            <div x-show="step === 1" class="space-y-6">
                                <div class="bg-white rounded-2xl sm:rounded-3xl p-3 sm:p-6 border border-line">
                                    <div class="flex items-center justify-between mb-4 sm:mb-6 gap-2">
                                        <button type="button" @click="prevMonth()" class="p-2 rounded-lg hover:bg-surface transition-colors" aria-label="الشهر السابق">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </button>
                                        <b class="text-sm sm:text-lg text-center" x-text="currentMonth.toLocaleDateString('ar-OM', { month: 'long', year: 'numeric' })"></b>
                                        <button type="button" @click="nextMonth()" class="p-2 rounded-lg hover:bg-surface transition-colors" aria-label="الشهر التالي">
                                            <svg class="w-5 h-5 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </button>
                                    </div>
                                    <div class="grid grid-cols-7 gap-0.5 sm:gap-2 text-center text-[10px] sm:text-xs text-muted mb-2 sm:mb-4">
                                        <div>أحد</div><div>اثن</div><div>ثلا</div><div>أرب</div><div>خمي</div><div>جمع</div><div>سبت</div>
                                    </div>
                                    <div class="grid grid-cols-7 gap-0.5 sm:gap-2 text-center">
                                        <template x-for="(day, index) in calendarDays" :key="day.date || ('empty-' + index)">
                                            <div class="aspect-square">
                                                <button type="button"
                                                    x-show="day.day !== null"
                                                    x-cloak
                                                    @click="day.available && (selectedDate = day.date); day.available && (step = 2)"
                                                    class="w-full h-full flex items-center justify-center rounded-lg sm:rounded-xl text-xs sm:text-sm transition-all border"
                                                    :class="!day.available ? 'opacity-30 cursor-not-allowed border-transparent' : (selectedDate === day.date ? 'bg-accent text-primary font-bold border-accent' : 'bg-surface hover:bg-accent/20 hover:text-primary hover:border-accent/50 border-transparent')"
                                                    :disabled="!day.available">
                                                    <span x-text="day.day"></span>
                                                </button>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            <div x-show="step === 2" class="space-y-6">
                                <div class="bg-accent/10 border border-accent/20 rounded-2xl p-4 mb-4">
                                    <div class="text-xs text-accent uppercase font-bold tracking-wider mb-2">التاريخ المختار</div>
                                    <div class="font-bold" x-text="formatDate(selectedDate)"></div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <template x-for="type in types" :key="type.id">
                                        <button type="button"
                                            @click="selectedType = type.id; step = 3"
                                            class="w-full p-4 sm:p-6 rounded-2xl border-2 transition-all text-center flex flex-col items-center justify-center bg-white"
                                            :class="selectedType === type.id ? 'border-accent bg-accent/5' : 'border-line hover:border-accent/50'">
                                            <div class="font-bold text-lg mb-1" x-text="type.title"></div>
                                            <div class="text-sm text-muted mb-3" x-text="type.duration + ' دقيقة'"></div>
                                            <div class="text-accent font-bold text-xl" x-text="parseFloat(type.price).toFixed(3) + ' ر.ع.'"></div>
                                        </button>
                                    </template>
                                </div>
                                <button type="button" @click="step = 1" class="btn btn-line w-full">
                                    العودة لاختيار التاريخ
                                </button>
                            </div>

                            <div x-show="step === 3" class="space-y-6">
                                <div class="bg-accent/10 border border-accent/20 rounded-2xl p-4 mb-4">
                                    <div class="text-xs text-accent uppercase font-bold tracking-wider mb-2">ملخص الحجز</div>
                                    <div class="flex flex-wrap gap-x-6 gap-y-2 text-sm">
                                        <div class="flex items-center gap-2">
                                            <span class="text-muted">التاريخ:</span>
                                            <span class="font-bold" x-text="formatDate(selectedDate)"></span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="text-muted">النوع:</span>
                                            <span class="font-bold" x-text="types.find(t => t.id === selectedType)?.title"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                    <template x-if="selectedDate && availabilities[selectedDate]">
                                        <template x-for="slot in availabilities[selectedDate]" :key="slot.id">
                                            <button type="button"
                                                @click="selectedTime = slot.start_time; step = 4"
                                                class="p-4 rounded-xl border-2 text-center transition-all font-bold bg-white"
                                                :class="selectedTime === slot.start_time ? 'border-accent bg-accent/10 text-primary' : 'border-line hover:border-accent/50'">
                                                <span x-text="slot.start_time.substring(0, 5)"></span>
                                            </button>
                                        </template>
                                    </template>
                                </div>
                                <button type="button" @click="step = 2" class="btn btn-line w-full">
                                    العودة لاختيار النوع
                                </button>
                            </div>

                            <div x-show="step === 4" class="space-y-6">
                                <div class="bg-accent/10 border border-accent/20 rounded-2xl p-4 mb-6">
                                    <div class="text-xs text-accent uppercase font-bold tracking-wider mb-2">ملخص الحجز</div>
                                    <div class="flex flex-wrap gap-x-6 gap-y-2 text-sm">
                                        <div class="flex items-center gap-2">
                                            <span class="text-muted">التاريخ:</span>
                                            <span class="font-bold" x-text="formatDate(selectedDate)"></span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="text-muted">الوقت:</span>
                                            <span class="font-bold" x-text="selectedTime ? selectedTime.substring(0, 5) : ''"></span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="text-muted">النوع:</span>
                                            <span class="font-bold" x-text="types.find(t => t.id === selectedType)?.title"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-5">
                                    <div>
                                        <label class="block text-sm font-bold mb-2 text-muted">الاسم الكامل</label>
                                        <input type="text" name="name" required placeholder="مثال: أحمد المعمري" class="field">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold mb-2 text-muted">البريد الإلكتروني</label>
                                        <input type="email" name="email" required placeholder="name@example.com" class="field text-left" dir="ltr">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold mb-2 text-muted">رقم التواصل (واتساب)</label>
                                        <input type="tel" name="phone" required placeholder="968 XXXXXXXX" class="field text-left" dir="ltr">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold mb-2 text-muted">موضوع الاستشارة</label>
                                        <textarea name="topic" required rows="3" placeholder="اكتب نبذة مختصرة عما تريد مناقشته..." class="field"></textarea>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-acc w-full">تأكيد الحجز والدفع</button>
                                <button type="button" @click="step = 3" class="btn btn-line w-full">
                                    العودة لاختيار الوقت
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="faq" class="py-12 sm:py-16 lg:py-20 bg-surface">
        <div class="wrap max-w-3xl">
            <h2 class="text-2xl sm:text-3xl lg:text-5xl font-bold mb-8 sm:mb-12 text-center">أسئلة شائعة</h2>

            <div class="space-y-4">
                @php
                    $faqs = [
                        [
                            'q' => 'كيف أحصل على الملفات؟',
                            'a' => 'من قسم «ابدأ من هنا» اختر الملف المناسب. الملفات المجانية تُحمَّل مباشرة، والمدفوعة تصبح متاحة للتحميل فور تأكيد الدفع.',
                        ],
                        [
                            'q' => 'هل أحتاج خبرة سابقة؟',
                            'a' => 'لا. الخطوات مرتبة من الفكرة حتى إطلاق المتجر، وتناسب المبتدئ وصاحب المشروع الذي يريد تطوير عمله الحالي.',
                        ],
                        [
                            'q' => 'كيف أستلم الملف بعد الشراء؟',
                            'a' => 'بعد تأكيد الدفع يظهر رابط التنزيل مباشرة في الصفحة، وتصل نسخة إضافية إلى بريدك الإلكتروني.',
                        ],
                        [
                            'q' => 'كيف أحجز استشارة؟',
                            'a' => 'من قسم الاستشارة اختر التاريخ ثم مدة الجلسة ثم الوقت المتاح، ثم أدخل بياناتك واضغط «تأكيد الحجز والدفع».',
                        ],
                        [
                            'q' => 'هل أستطيع تعديل موعد الاستشارة أو إلغاءه؟',
                            'a' => 'نعم. يمكنك طلب التعديل أو الإلغاء قبل الموعد بـ 24 ساعة عبر واتساب. بعد تأكيد الجلسة أو بعد انقضائها لا يُسترجع المبلغ.',
                        ],
                        [
                            'q' => 'ما سياسة الاسترجاع؟',
                            'a' => 'الملفات الرقمية غير قابلة للاسترجاع بعد التحميل. إذا واجهت مشكلة تقنية نقدم دعماً فنياً.',
                        ],
                    ];
                @endphp

                @foreach($faqs as $faq)
                    <details class="group bg-white border border-line rounded-2xl overflow-hidden shadow-soft">
                        <summary class="flex items-start gap-3 p-4 sm:p-6 cursor-pointer font-bold text-base sm:text-lg select-none">
                            <span class="flex-1 leading-snug">{{ $faq['q'] }}</span>
                            <span class="text-accent shrink-0 mt-0.5 group-open:rotate-180 transition-transform">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </span>
                        </summary>
                        <div class="px-4 sm:px-6 pb-4 sm:pb-6 text-muted leading-relaxed text-sm sm:text-base">
                            {{ $faq['a'] }}
                            @if($faq['q'] === 'ما سياسة الاسترجاع؟')
                                <a href="{{ route('refund') }}" class="text-accent font-bold hover:underline">اقرأ السياسة كاملة</a>
                            @endif
                        </div>
                    </details>
                @endforeach
            </div>
        </div>
    </section>
@endsection

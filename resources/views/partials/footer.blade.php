<footer class="site-footer">
    <div class="h-1 bg-gradient-to-l from-accent via-accent-hover to-primary"></div>

    <div class="site-footer-inner">
        <a href="{{ url('/') }}" class="site-footer-brand">
            <img src="{{ asset('images/logo.png') }}" alt="محمود الدرعي" class="h-8 w-auto object-contain">
            <span class="font-bold text-sm">محمود الدرعي</span>
        </a>

        <nav class="site-footer-nav" aria-label="روابط الفوتر">
            <a href="{{ url('/#about') }}">من أنا</a>
            <a href="{{ url('/#start') }}">ابدأ من هنا</a>
            <a href="{{ url('/#consult') }}">الاستشارة</a>
            <a href="{{ route('privacy') }}">الخصوصية</a>
            <a href="{{ route('refund') }}">الاسترجاع</a>
        </nav>

        <div class="site-footer-social">
            <a href="mailto:{{ config('services.email') }}"
               class="text-sm text-white/70 hover:text-accent transition-colors"
               dir="ltr">
                {{ config('services.email') }}
            </a>
            <a href="{{ config('services.instagram') }}"
               target="_blank"
               rel="noopener noreferrer"
               class="w-9 h-9 rounded-full border border-white/15 flex items-center justify-center text-white hover:border-accent hover:text-accent transition-colors"
               aria-label="انستغرام">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M12 2.16c3.2 0 3.58.01 4.85.07 3.25.15 4.77 1.69 4.92 4.92.06 1.27.07 1.65.07 4.85s-.01 3.58-.07 4.85c-.15 3.23-1.66 4.77-4.92 4.92-1.27.06-1.64.07-4.85.07s-3.58-.01-4.85-.07c-3.26-.15-4.77-1.7-4.92-4.92C2.17 15.58 2.16 15.2 2.16 12s.01-3.58.07-4.85C2.38 3.92 3.89 2.38 7.15 2.23 8.42 2.17 8.8 2.16 12 2.16ZM12 0C8.74 0 8.33.01 7.05.07 2.7.27.27 2.7.07 7.05.01 8.33 0 8.74 0 12s.01 3.67.07 4.95c.2 4.36 2.62 6.78 6.98 6.98C8.33 23.99 8.74 24 12 24s3.67-.01 4.95-.07c4.35-.2 6.78-2.62 6.98-6.98C23.99 15.67 24 15.26 24 12s-.01-3.67-.07-4.95C23.73 2.7 21.31.27 16.95.07 15.67.01 15.26 0 12 0Zm0 5.84A6.16 6.16 0 1 0 18.16 12 6.16 6.16 0 0 0 12 5.84ZM12 16a4 4 0 1 1 4-4 4 4 0 0 1-4 4Zm6.41-11.85a1.44 1.44 0 1 0 1.44 1.44 1.44 1.44 0 0 0-1.44-1.44Z"/>
                </svg>
            </a>
        </div>
    </div>

    <p class="text-center text-[11px] text-white/40 pb-4 px-4">
        © {{ date('Y') }} محمود الدرعي · جميع الحقوق محفوظة
    </p>
</footer>

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
            <a href="{{ config('services.whatsapp') }}"
               target="_blank"
               rel="noopener noreferrer"
               class="w-9 h-9 rounded-full border border-white/15 flex items-center justify-center text-white hover:border-accent hover:text-accent transition-colors"
               aria-label="واتساب">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M20.52 3.48A11.78 11.78 0 0 0 12.06 0C5.46 0 .1 5.35.1 11.94c0 2.1.55 4.15 1.6 5.96L0 24l6.26-1.64a11.9 11.9 0 0 0 5.8 1.48h.01c6.6 0 11.95-5.36 11.95-11.95 0-3.19-1.24-6.19-3.5-8.41ZM12.07 21.15h-.01a9.9 9.9 0 0 1-5.04-1.38l-.36-.21-3.71.97.99-3.62-.24-.37a9.86 9.86 0 0 1-1.51-5.26c0-5.45 4.44-9.88 9.9-9.88 2.64 0 5.12 1.03 6.98 2.9a9.82 9.82 0 0 1 2.9 6.98c0 5.45-4.44 9.87-9.9 9.87Zm5.42-7.4c-.3-.15-1.76-.87-2.03-.96-.27-.1-.47-.15-.67.15-.2.3-.77.96-.95 1.16-.17.2-.35.22-.65.07-.3-.15-1.26-.46-2.4-1.48a8.98 8.98 0 0 1-1.66-2.06c-.17-.3 0-.46.13-.6.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.07-.15-.67-1.62-.92-2.22-.24-.58-.49-.5-.67-.5h-.57c-.2 0-.52.07-.8.37-.27.3-1.05 1.02-1.05 2.5s1.07 2.9 1.22 3.1c.15.2 2.1 3.2 5.1 4.48.71.3 1.27.49 1.7.62.72.23 1.37.2 1.88.12.57-.09 1.76-.72 2.01-1.41.25-.7.25-1.29.17-1.41-.07-.13-.27-.2-.57-.35Z"/>
                </svg>
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

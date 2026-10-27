<header class="fixed inset-x-0 top-0 z-50 h-[var(--header-h)] border-b border-white/10 bg-primary/95 backdrop-blur-xl text-white" x-data="{ open: false }">
    <div class="wrap h-full flex items-center justify-between gap-2 sm:gap-4">
        <a href="{{ url('/') }}" class="flex items-center gap-2 sm:gap-3 min-w-0 group">
            <img src="{{ asset('images/logo.png') }}" alt="محمود الدرعي" class="h-8 sm:h-10 w-auto object-contain transition-transform group-hover:scale-105">
            <span class="font-bold text-sm sm:text-base tracking-tight hidden sm:block truncate">محمود الدرعي</span>
        </a>

        <nav class="hidden md:flex items-center gap-6 lg:gap-8 text-sm font-medium text-white/70">
            <a href="{{ url('/#about') }}" class="hover:text-accent transition-colors">من أنا</a>
            <a href="{{ url('/#start') }}" class="hover:text-accent transition-colors">ابدأ من هنا</a>
            <a href="{{ url('/#consult') }}" class="hover:text-accent transition-colors">الاستشارة</a>
        </nav>

        <div class="flex items-center gap-1.5 sm:gap-3 shrink-0">
            <a href="{{ url('/#consult') }}" class="btn btn-acc btn-sm">احجز الآن</a>
            <button type="button" class="md:hidden inline-flex items-center justify-center w-10 h-10 rounded-xl text-white hover:bg-white/10" aria-label="القائمة" :aria-expanded="open" @click="open = !open">
                <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
                <svg x-show="open" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <div class="md:hidden absolute inset-x-0 top-full border-b border-white/10 bg-primary shadow-soft" x-show="open" x-cloak x-transition>
        <nav class="wrap py-4 flex flex-col gap-1 text-sm font-medium">
            <a href="{{ url('/#about') }}" class="py-3 px-2 rounded-xl hover:bg-white/5" @click="open = false">من أنا</a>
            <a href="{{ url('/#start') }}" class="py-3 px-2 rounded-xl hover:bg-white/5" @click="open = false">ابدأ من هنا</a>
            <a href="{{ url('/#consult') }}" class="py-3 px-2 rounded-xl hover:bg-white/5" @click="open = false">الاستشارة</a>
            <a href="{{ url('/#consult') }}" class="btn btn-acc mt-2 w-full" @click="open = false">احجز الآن</a>
        </nav>
    </div>
</header>

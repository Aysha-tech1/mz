<div
    x-data="{
        open: false,
        title: '',
        claimUrl: '',
        email: '',
        error: '',
        loading: false,
        openFor(detail) {
            this.title = detail.title
            this.claimUrl = detail.url
            this.error = ''
            this.loading = false
            this.open = true
            this.$nextTick(() => this.$refs.emailInput?.focus())
        },
        async submit() {
            this.error = ''
            this.loading = true
            try {
                const response = await fetch(this.claimUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    },
                    body: JSON.stringify({ email: this.email }),
                })
                const data = await response.json()
                if (! response.ok) {
                    this.error = data.message || data.errors?.email?.[0] || 'تعذر الإرسال، حاول مرة أخرى.'
                    this.loading = false
                    return
                }
                this.open = false
                window.location.href = data.download_url
            } catch (e) {
                this.error = 'تعذر الاتصال، حاول مرة أخرى.'
                this.loading = false
            }
        }
    }"
    @open-file-email.window="openFor($event.detail)"
>
    <div
        x-show="open"
        x-cloak
        class="file-email-overlay"
        @keydown.escape.window="open = false"
    >
        <div class="file-email-backdrop" @click="open = false"></div>
        <div class="file-email-card" role="dialog" aria-modal="true" @click.stop>
            <button type="button" class="file-email-close" @click="open = false" aria-label="إغلاق">×</button>
            <p class="pill mb-4">يصلك الملف على بريدك</p>
            <h3 class="text-xl font-bold mb-2 leading-snug">أدخل بريدك الإلكتروني</h3>
            <p class="text-sm text-muted mb-6 leading-relaxed">نرسل لك الملف مع رسالة شكر، ويبدأ التحميل مباشرة بعد التأكيد.</p>
            <p class="text-sm font-bold mb-4 text-primary" x-text="title"></p>
            <form @submit.prevent="submit" class="space-y-4">
                <label class="block text-sm font-bold mb-1">البريد الإلكتروني</label>
                <input
                    x-ref="emailInput"
                    type="email"
                    x-model="email"
                    class="field"
                    placeholder="name@example.com"
                    required
                    dir="ltr"
                    autocomplete="email"
                >
                <p x-show="error" x-text="error" class="text-sm text-red-600"></p>
                <button type="submit" class="btn btn-acc w-full" :disabled="loading">
                    <span x-show="!loading">إرسال الملف</span>
                    <span x-show="loading">جارٍ الإرسال...</span>
                </button>
            </form>
        </div>
    </div>
</div>

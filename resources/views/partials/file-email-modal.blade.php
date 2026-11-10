<div id="file-email-modal" class="file-email-overlay" aria-hidden="true">
    <div class="file-email-backdrop" data-file-email-close></div>
    <div class="file-email-card" role="dialog" aria-modal="true">
        <button type="button" class="file-email-close" data-file-email-close aria-label="إغلاق">×</button>
        <h3 id="file-email-title" class="text-xl font-bold mb-2 leading-snug">ضع إيميلك ليصلك الملف</h3>
        <p id="file-email-price" class="text-sm text-muted mb-6" hidden></p>
        <form id="file-email-form" class="space-y-4">
            <input
                id="file-email-input"
                type="email"
                class="field"
                placeholder="name@example.com"
                required
                dir="ltr"
                autocomplete="email"
                inputmode="email"
            >
            <p id="file-email-error" class="text-sm text-red-600" hidden></p>
            <button type="submit" id="file-email-submit" class="btn btn-acc w-full">إرسال الملف</button>
        </form>
    </div>
</div>
<script>
    (function () {
        const modal = document.getElementById('file-email-modal');
        const form = document.getElementById('file-email-form');
        const input = document.getElementById('file-email-input');
        const errorEl = document.getElementById('file-email-error');
        const submitBtn = document.getElementById('file-email-submit');
        const titleEl = document.getElementById('file-email-title');
        const priceEl = document.getElementById('file-email-price');
        let claimUrl = '';
        let paid = false;
        const defaultSubmit = 'إرسال الملف';
        const paySubmit = 'ادفع الآن';

        function eventEl(event) {
            const target = event.target;
            if (! target) {
                return null;
            }
            return target.nodeType === 1 ? target : target.parentElement;
        }

        function setError(message) {
            errorEl.textContent = message || '';
            errorEl.hidden = ! message;
        }

        function openModal(button) {
            claimUrl = button.getAttribute('data-file-claim') || '';
            paid = button.getAttribute('data-file-paid') === '1';
            const price = button.getAttribute('data-file-price') || '';

            input.value = '';
            setError('');
            submitBtn.disabled = false;
            submitBtn.textContent = paid ? paySubmit : defaultSubmit;
            titleEl.textContent = paid ? 'أدخل إيميلك ثم ادفع الآن' : 'ضع إيميلك ليصلك الملف';
            priceEl.textContent = price ? 'المبلغ: ' + price : '';
            priceEl.hidden = ! price;
            modal.classList.add('is-open');
            modal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
            document.body.style.touchAction = 'none';
        }

        function closeModal() {
            modal.classList.remove('is-open');
            modal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
            document.body.style.touchAction = '';
        }

        window.openFileEmailModal = function (button) {
            if (! button) {
                return false;
            }
            openModal(button);
            return false;
        };

        document.addEventListener('click', function (event) {
            const el = eventEl(event);
            if (! el || ! el.closest) {
                return;
            }

            if (el.closest('[data-file-email-close]')) {
                event.preventDefault();
                closeModal();
                return;
            }

            const button = el.closest('[data-file-claim]');
            if (! button) {
                return;
            }

            event.preventDefault();
            openModal(button);
        }, true);

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && modal.classList.contains('is-open')) {
                closeModal();
            }
        });

        form.addEventListener('submit', async function (event) {
            event.preventDefault();
            setError('');
            submitBtn.disabled = true;
            submitBtn.textContent = paid ? 'جارٍ التحويل للدفع...' : 'جارٍ الإرسال...';

            try {
                const csrf = document.querySelector('meta[name="csrf-token"]');
                const response = await fetch(claimUrl, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrf ? csrf.content : '',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({ email: input.value }),
                });

                const data = await response.json().catch(function () { return {}; });

                if (! response.ok) {
                    setError(data.message || (data.errors && data.errors.email && data.errors.email[0]) || 'تعذر الإرسال، حاول مرة أخرى.');
                    submitBtn.disabled = false;
                    submitBtn.textContent = paid ? paySubmit : defaultSubmit;
                    return;
                }

                closeModal();
                window.location.href = data.checkout_url || data.download_url;
            } catch (e) {
                setError('تعذر الاتصال، حاول مرة أخرى.');
                submitBtn.disabled = false;
                submitBtn.textContent = paid ? paySubmit : defaultSubmit;
            }
        });
    })();
</script>

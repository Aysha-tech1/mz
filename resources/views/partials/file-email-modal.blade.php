<div id="file-email-modal" class="file-email-overlay" aria-hidden="true">
    <div class="file-email-backdrop" data-file-email-close></div>
    <div class="file-email-card" role="dialog" aria-modal="true">
        <button type="button" class="file-email-close" data-file-email-close aria-label="إغلاق">×</button>
        <h3 class="text-xl font-bold mb-6 leading-snug">ضع إيميلك ليصلك الملف</h3>
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
        let claimUrl = '';

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

        function openModal(url) {
            claimUrl = url || '';
            input.value = '';
            setError('');
            submitBtn.disabled = false;
            submitBtn.textContent = 'إرسال الملف';
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
            openModal(button.getAttribute('data-file-claim'));
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
            openModal(button.getAttribute('data-file-claim'));
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
            submitBtn.textContent = 'جارٍ الإرسال...';

            try {
                const csrf = document.querySelector('meta[name="csrf-token"]');
                const response = await fetch(claimUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrf ? csrf.content : '',
                    },
                    body: JSON.stringify({ email: input.value }),
                });

                const data = await response.json().catch(function () { return {}; });

                if (! response.ok) {
                    setError(data.message || (data.errors && data.errors.email && data.errors.email[0]) || 'تعذر الإرسال، حاول مرة أخرى.');
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'إرسال الملف';
                    return;
                }

                closeModal();
                window.location.href = data.download_url;
            } catch (e) {
                setError('تعذر الاتصال، حاول مرة أخرى.');
                submitBtn.disabled = false;
                submitBtn.textContent = 'إرسال الملف';
            }
        });
    })();
</script>

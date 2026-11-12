/**
 * Cookie Consent and Interactive Helper Scripts
 */
export function initCookieConsent() {
    const banner = document.getElementById('cookie-consent-banner');
    const acceptBtn = document.getElementById('cookie-accept-btn');
    const dismissBtn = document.getElementById('cookie-dismiss-btn');

    if (!banner) return;

    const consent = localStorage.getItem('fs_cookie_consent');

    if (!consent) {
        banner.classList.remove('d-none');
    }

    if (acceptBtn) {
        acceptBtn.addEventListener('click', () => {
            localStorage.setItem('fs_cookie_consent', 'accepted');
            banner.classList.add('d-none');
            // Trigger custom event so any conditional marketing tags can initialize
            window.dispatchEvent(new CustomEvent('cookieConsentAccepted'));
        });
    }

    if (dismissBtn) {
        dismissBtn.addEventListener('click', () => {
            localStorage.setItem('fs_cookie_consent', 'dismissed');
            banner.classList.add('d-none');
        });
    }
}

/**
 * Copy to clipboard handler for share buttons
 */
export function initCopyButtons() {
    document.querySelectorAll('.btn-copy-link').forEach((button) => {
        button.addEventListener('click', async () => {
            const url = button.dataset.url || window.location.href;
            try {
                await navigator.clipboard.writeText(url);
                const originalHtml = button.innerHTML;
                button.innerHTML = '<i class="bi bi-check2 text-success"></i>';
                button.classList.add('btn-success');
                button.classList.remove('btn-outline-secondary');

                setTimeout(() => {
                    button.innerHTML = originalHtml;
                    button.classList.remove('btn-success');
                    button.classList.add('btn-outline-secondary');
                }, 2000);
            } catch (err) {
                console.error('Failed to copy link: ', err);
            }
        });
    });
}


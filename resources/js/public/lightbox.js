/**
 * Vanilla JS Image Lightbox Modal
 */
export function initLightbox() {
    const lightboxTriggers = document.querySelectorAll('[data-lightbox="campus-gallery"]');
    if (!lightboxTriggers.length) return;

    // Create modal elements if not already in DOM
    let modal = document.getElementById('lightbox-modal');
    if (!modal) {
        modal = document.createElement('div');
        modal.id = 'lightbox-modal';
        modal.className = 'modal fade';
        modal.tabIndex = -1;
        modal.setAttribute('aria-hidden', 'true');
        modal.innerHTML = `
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content bg-transparent border-0">
                    <div class="modal-header border-0 pb-0 justify-content-end">
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center p-2">
                        <img id="lightbox-image" src="" alt="" class="img-fluid rounded shadow-lg max-vh-80 object-fit-contain">
                        <p id="lightbox-caption" class="text-white small mt-2 mb-0 fw-medium"></p>
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
    }

    const modalImage = document.getElementById('lightbox-image');
    const modalCaption = document.getElementById('lightbox-caption');
    const bsModal = window.bootstrap ? new window.bootstrap.Modal(modal) : null;

    lightboxTriggers.forEach((trigger) => {
        trigger.addEventListener('click', (e) => {
            e.preventDefault();
            const src = trigger.getAttribute('href') || trigger.dataset.src;
            const caption = trigger.dataset.caption || trigger.querySelector('img')?.alt || '';

            if (modalImage && src) {
                modalImage.src = src;
                if (modalCaption) modalCaption.textContent = caption;
                if (bsModal) bsModal.show();
            }
        });
    });
}

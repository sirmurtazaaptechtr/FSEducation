import './bootstrap';
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

document.addEventListener('DOMContentLoaded', () => {
    // 1. Tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map((tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl));

    // 2. Image upload instant preview
    document.querySelectorAll('.image-upload-input').forEach((input) => {
        input.addEventListener('change', (e) => {
            const file = e.target.files[0];
            const targetId = input.getAttribute('data-preview-target');
            const previewEl = document.getElementById(targetId);

            if (file && previewEl) {
                const reader = new FileReader();
                reader.onload = (event) => {
                    previewEl.innerHTML = `<img src="${event.target.result}" alt="Preview" class="img-fluid rounded">`;
                };
                reader.readAsDataURL(file);
            }
        });
    });

    // 3. Confirm Delete Dialog
    document.querySelectorAll('.confirm-delete-form').forEach((form) => {
        form.addEventListener('submit', (e) => {
            const message = form.getAttribute('data-confirm-message') || 'Are you sure you want to delete this item? This action cannot be undone.';
            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    });

    // 4. Vanilla JS Drag and Drop Reordering
    const sortableTable = document.querySelector('.sortable-table');
    if (sortableTable) {
        let draggedRow = null;
        const tbody = sortableTable.querySelector('tbody');
        const reorderUrl = sortableTable.getAttribute('data-reorder-url');

        tbody.querySelectorAll('tr').forEach((row) => {
            row.setAttribute('draggable', 'true');

            row.addEventListener('dragstart', (e) => {
                draggedRow = row;
                row.classList.add('dragging');
                e.dataTransfer.effectAllowed = 'move';
            });

            row.addEventListener('dragend', () => {
                row.classList.remove('dragging');
                draggedRow = null;

                // Send new order to server
                const rows = Array.from(tbody.querySelectorAll('tr'));
                const orderData = rows.map((r, index) => ({
                    id: r.getAttribute('data-id'),
                    sort_order: index + 1
                }));

                if (reorderUrl) {
                    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    fetch(reorderUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token || '',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ items: orderData })
                    }).then(res => res.json())
                      .then(data => {
                          if (data.success) {
                              const toast = document.createElement('div');
                              toast.className = 'alert alert-success position-fixed top-0 end-0 m-3 shadow-sm py-2 px-3';
                              toast.style.zIndex = '9999';
                              toast.textContent = data.message || 'Order updated successfully';
                              document.body.appendChild(toast);
                              setTimeout(() => toast.remove(), 2500);
                          }
                      }).catch(err => console.error('Reorder error:', err));
                }
            });

            row.addEventListener('dragover', (e) => {
                e.preventDefault();
                e.dataTransfer.dropEffect = 'move';
                const targetRow = e.target.closest('tr');
                if (targetRow && targetRow !== draggedRow && targetRow.parentNode === tbody) {
                    const rect = targetRow.getBoundingClientRect();
                    const next = (e.clientY - rect.top) / (rect.bottom - rect.top) > 0.5;
                    tbody.insertBefore(draggedRow, next ? targetRow.nextSibling : targetRow);
                }
            });
        });
    }
});

// ============================================
// Sistema de Toast Notifications
// ============================================
function showToast(message, type = 'success') {
    const container = document.getElementById('toast-container');
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;

    const icons = {
        success: '✅',
        error: '❌',
        warning: '⚠️',
        info: 'ℹ️'
    };

    toast.innerHTML = `
        <span class="toast-icon">${icons[type] || icons.info}</span>
        <div class="toast-content">
            <span class="toast-message">${message}</span>
        </div>
        <button class="toast-close" onclick="this.parentElement.remove()">×</button>
    `;

    container.appendChild(toast);
    requestAnimationFrame(() => toast.classList.add('toast-show'));

    setTimeout(() => {
        if (toast && toast.parentElement) {
            toast.classList.remove('toast-show');
            toast.classList.add('toast-hide');
            setTimeout(() => toast.remove(), 300);
        }
    }, 4000);
}

// ============================================
// Toast de Confirmación para Eliminar
// ============================================
function showConfirmToast(message, onConfirm) {
    const container = document.getElementById('toast-container');
    const toast = document.createElement('div');
    toast.className = 'toast toast-warning toast-confirm';

    toast.innerHTML = `
        <span class="toast-icon">⚠️</span>
        <div class="toast-confirm-content">
            <strong class="toast-title">¿Confirmar eliminación?</strong>
            <span class="toast-message">${message}</span>
            <div class="toast-confirm-actions">
                <button class="btn btn-danger btn-sm toast-confirm-yes">Sí, eliminar</button>
                <button class="btn btn-secondary btn-sm toast-confirm-no">Cancelar</button>
            </div>
        </div>
    `;

    container.appendChild(toast);
    requestAnimationFrame(() => toast.classList.add('toast-show'));

    toast.querySelector('.toast-confirm-yes').addEventListener('click', function() {
        toast.remove();
        onConfirm();
    });

    toast.querySelector('.toast-confirm-no').addEventListener('click', function() {
        toast.classList.remove('toast-show');
        toast.classList.add('toast-hide');
        setTimeout(() => {
            if (toast.parentElement) toast.remove();
        }, 300);
    });
}

// ============================================
// Inicializar formularios de eliminación
// ============================================
function initDeleteForms(message = '¿Estás seguro de que deseas eliminar este registro?') {
    $(document).on('submit', '.delete-form', function(e) {
        e.preventDefault();
        const form = this;
        showConfirmToast(message, function() {
            form.submit();
        });
    });
}

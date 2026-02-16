document.addEventListener('DOMContentLoaded', function () {
    const session = window.storeSession;
    const toastElement = document.getElementById('storeToast');
    const toastBody = document.getElementById('storeToastBody');

    if (toastElement && (session.success || session.error)) {
        const toast = new bootstrap.Toast(toastElement);

        if (session.success) {
            toastBody.innerText = session.success;
            toastBody.classList.add('text-success');
        } else {
            toastBody.innerText = session.error;
            toastBody.classList.add('text-danger');
        }

        toast.show();
    }
});

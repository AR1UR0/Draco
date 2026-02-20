/**
 * @fileoverview Sistema de Notificaciones dinámicas para la Tienda.
 * Captura las variables de sesión enviadas desde el controlador de Laravel
 * y las renderiza utilizando componentes Toast de Bootstrap.
 * @author Marta/Draco Team
 */
document.addEventListener("DOMContentLoaded", function () {
    /**
     * @constant {Object} session - Captura los datos pasados desde el backend.
     * Estos datos suelen inyectarse en el Blade mediante window.storeSession.
     */
    const session = window.storeSession;
    const toastElement = document.getElementById("storeToast");
    const toastBody = document.getElementById("storeToastBody");

    /**
     * Lógica de Activación:
     * El script verifica si el elemento existe en el DOM y si hay un mensaje
     * de éxito o error pendiente en la sesión.
     */
    if (toastElement && (session.success || session.error)) {
        const toast = new bootstrap.Toast(toastElement);

        if (session.success) {
            toastBody.innerText = session.success;
            toastBody.classList.add("text-success");
        } else {
            toastBody.innerText = session.error;
            toastBody.classList.add("text-danger");
        }

        toast.show();
    }
});

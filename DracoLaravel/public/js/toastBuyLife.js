/**
* @fileoverview Dynamic Notification System for the Store.
* Captures session variables sent from the Laravel controller
* and renders them using Bootstrap Toast components.
* @author Marta/Draco Team
*/
document.addEventListener("DOMContentLoaded", function () {
    /**
    * @constant {Object} session - Captures data passed from the backend.
    * This data is typically injected into the Blade using window.storeSession.
    */
    const session = window.storeSession;
    const toastElement = document.getElementById("storeToast");
    const toastBody = document.getElementById("storeToastBody");

    /**
    * Activation Logic:
    * The script checks if the element exists in the DOM and if there is a pending success or error message in the session.
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

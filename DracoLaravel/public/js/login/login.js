/**
 * @fileoverview Gestión de vistas y validaciones para los formularios de
 * Login, Registro y Recuperación de contraseña.
 * @author Thais/Draco Team
 * @version 1.0.0
 */

/** @type {HTMLElement} Botón para conmutar a la vista de registro */
const openRegister = document.getElementById("openRegister");
/** @type {HTMLElement} Botón para regresar a la vista de inicio de sesión */
const backToLogin = document.getElementById("backToLogin");
/** @type {HTMLElement} Contenedor principal del formulario de login */
const loginView = document.getElementById("loginView");
/** @type {HTMLElement} Contenedor principal del formulario de registro */
const registerView = document.getElementById("registerView");

/**
 * Control de alternancia entre las vistas de Login y Registro.
 */
if (openRegister) {
    openRegister.addEventListener("click", (e) => {
        e.preventDefault();
        loginView.classList.add("d-none");
        registerView.classList.remove("d-none");
    });
}

if (backToLogin) {
    backToLogin.addEventListener("click", (e) => {
        e.preventDefault();
        registerView.classList.add("d-none");
        loginView.classList.remove("d-none");
    });
}

// ---------------- VALIDACIONES ----------------

/** @type {HTMLFormElement} Formulario de inicio de sesión */
const loginForm = document.getElementById("loginForm");
/** @type {HTMLFormElement} Formulario de creación de cuenta */
const registerForm = document.getElementById("registerForm");

/** @type {RegExp} Expresión regular para validación de formato de email estándar */
const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

/**
 * Lógica de validación para el formulario de Login.
 * Verifica campos obligatorios y formato de correo si aplica.
 */
if (loginForm) {
    loginForm.addEventListener("submit", function (e) {
        e.preventDefault();

        const user = document.getElementById("loginUser").value.trim();
        const pass = document.getElementById("loginPassword").value.trim();

        if (!user || !pass) {
            alert("Todos los campos son obligatorios");
            return;
        }
        // si todo esta bien, enviamos el formulario a Laravel
        this.submit();
    });
}

/**
 * Gestión del formulario de recuperación de contraseña.
 * Simula el envío de correo y cierra el modal de Bootstrap.
 */
document
    .getElementById("forgotPasswordForm")
    .addEventListener("submit", function (e) {
        e.preventDefault();
        const email = document.getElementById("forgotEmail").value;
        console.log("Correo enviado para recuperar contraseña:", email);

        // Lógica para enviar el correo

        const forgotModal = bootstrap.Modal.getInstance(
            document.getElementById("forgotPasswordModal"),
        );
        forgotModal.hide();

        alert(
            "Si el correo existe, recibirás instrucciones para recuperar tu contraseña.",
        );
    });

// --- VALIDACIONES CAMPO A CAMPO CON BOOTSTRAP POPOVERS ---

/**
 * Función para gestionar popovers de error de Bootstrap
 * @param {HTMLElement} element - El input a validar
 * @param {string} message - Mensaje de error
 * @param {boolean} show - Si se debe mostrar o destruir
 * @author Marta
 * @version 1.0.1
 */
function managePopover(element, message, show) {
    let popover = bootstrap.Popover.getInstance(element);

    if (show) {
        if (!popover) {
            popover = new bootstrap.Popover(element, {
                content: message,
                placement: "right",
                trigger: "manual",
                customClass: "popover-error",
            });
        }
        popover.show();
    } else {
        if (popover) {
            popover.dispose();
        }
    }
}

if (registerForm) {
    const regUser = document.getElementById("regUser");
    const regEmail = document.getElementById("regEmail");
    const regPass1 = document.getElementById("regPassword");
    const regPass2 = document.getElementById("regPassword2");

    // 1. Usuario: min 4 caracteres
    regUser.addEventListener("blur", () => {
        const invalid = regUser.value.length > 0 && regUser.value.length < 4;
        managePopover(regUser, "Mínimo 4 caracteres", invalid);
    });

    // 2. Email: debe tener @
    regEmail.addEventListener("blur", () => {
        const invalid =
            regEmail.value.length > 0 && !regEmail.value.includes("@");
        managePopover(regEmail, "Falta el símbolo @", invalid);
    });

    // Password: min 8
    regPass1.addEventListener("blur", () => {
        const invalid = regPass1.value.length > 0 && regPass1.value.length < 8;
        managePopover(regPass1, "Mínimo 8 caracteres", invalid);
    });

    // Confirmación: coincidir
    regPass2.addEventListener("blur", () => {
        const invalid =
            regPass2.value.length > 0 && regPass2.value !== regPass1.value;
        managePopover(regPass2, "Las contraseñas no coinciden", invalid);
    });

    // Validación final antes de enviar
    registerForm.addEventListener("submit", function (e) {
        e.preventDefault();

        const isUserOk = regUser.value.length >= 4;
        const isEmailOk = regEmail.value.includes("@");
        const isPassOk = regPass1.value.length >= 8;
        const isMatchOk = regPass1.value === regPass2.value;

        if (isUserOk && isEmailOk && isPassOk && isMatchOk) {
            this.submit();
        } else {
            alert("Revisa los campos");
        }
    });
}

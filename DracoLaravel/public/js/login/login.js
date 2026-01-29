/**
 * @fileoverview Gestión de vistas y validaciones para los formularios de 
 * Login, Registro y Recuperación de contraseña.
 * @author Thais/Draco Team
 * @version 1.0.0
 */

/** @type {HTMLElement} Botón para conmutar a la vista de registro */
const openRegister = document.getElementById('openRegister');
/** @type {HTMLElement} Botón para regresar a la vista de inicio de sesión */
const backToLogin = document.getElementById('backToLogin');
/** @type {HTMLElement} Contenedor principal del formulario de login */
const loginView = document.getElementById('loginView');
/** @type {HTMLElement} Contenedor principal del formulario de registro */
const registerView = document.getElementById('registerView');

/**
 * Control de alternancia entre las vistas de Login y Registro.
 */
if (openRegister) {
    openRegister.addEventListener('click', (e) => {
        e.preventDefault();
        loginView.classList.add('d-none');
        registerView.classList.remove('d-none');
    });
}

if (backToLogin) {
    backToLogin.addEventListener('click', (e) => {
        e.preventDefault();
        registerView.classList.add('d-none');
        loginView.classList.remove('none');
    });
}

// ---------------- VALIDACIONES ----------------

/** @type {HTMLFormElement} Formulario de inicio de sesión */
const loginForm = document.getElementById('loginForm');
/** @type {HTMLFormElement} Formulario de creación de cuenta */
const registerForm = document.getElementById('registerForm');

/** @type {RegExp} Expresión regular para validación de formato de email estándar */
const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

/**
 * Lógica de validación para el formulario de Login.
 * Verifica campos obligatorios y formato de correo si aplica.
 */
if (loginForm) {
    loginForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const user = document.getElementById('loginUser').value.trim();
        const pass = document.getElementById('loginPassword').value.trim();

        if (!user || !pass) {
            alert('Todos los campos son obligatorios');
            return;
        }

        if (user.includes('@') && !emailRegex.test(user)) {
            alert('Correo electrónico inválido');
            return;
        }

        alert('Login válido ✔');
    });
}

/**
 * Lógica de validación para el formulario de Registro.
 * Comprueba integridad de datos, longitud de contraseña y coincidencia de las mismas.
 */
if (registerForm) {
    registerForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const user = document.getElementById('regUser').value.trim();
        const email = document.getElementById('regEmail').value.trim();
        const pass1 = document.getElementById('regPassword').value.trim();
        const pass2 = document.getElementById('regPassword2').value.trim();

        if (!user || !email || !pass1 || !pass2) {
            alert('No puedes dejar campos vacíos');
            return;
        }

        if (!emailRegex.test(email)) {
            alert('Correo electrónico inválido');
            return;
        }

        if (pass1.length < 6) {
            alert('La contraseña debe tener al menos 6 caracteres');
            return;
        }

        if (pass1 !== pass2) {
            alert('Las contraseñas no coinciden');
            return;
        }

        alert('Registro válido ✔');
    });
}

/**
 * Gestión del formulario de recuperación de contraseña.
 * Simula el envío de correo y cierra el modal de Bootstrap.
 */
document.getElementById('forgotPasswordForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const email = document.getElementById('forgotEmail').value;
    console.log("Correo enviado para recuperar contraseña:", email);
    
    // Lógica para enviar el correo 

    const forgotModal = bootstrap.Modal.getInstance(document.getElementById('forgotPasswordModal'));
    forgotModal.hide();

    alert("Si el correo existe, recibirás instrucciones para recuperar tu contraseña.");
});
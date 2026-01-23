const openRegister = document.getElementById('openRegister');
const backToLogin = document.getElementById('backToLogin');
const loginView = document.getElementById('loginView');
const registerView = document.getElementById('registerView');

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
        loginView.classList.remove('d-none');
    });
}

// ---------------- VALIDACIONES ----------------

const loginForm = document.getElementById('loginForm');
const registerForm = document.getElementById('registerForm');

const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

// LOGIN
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

// REGISTER
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


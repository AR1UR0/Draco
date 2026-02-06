<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Draco - Login</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/login.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/main.css') }}" />
    <script defer src="{{ asset('js/login/login.js') }}"></script>
    <script defer src="{{ asset('js/bootstrap.bundle.js') }}"></script>
    <script defer src="{{ asset('js/themeChange.js') }}"></script>
    <link rel="shortcut icon" href="{{ asset('media/imgs/icoDraco.png') }}" type="image/x-icon" />

    <style>
        .btn-primary {
            background-color: #98b705 !important;
            border-color: #98b705 !important;
        }
    </style>

</head>


<body>
    <div class="login-wrapper d-flex align-items-center justify-content-center">
        <!-- Botón cerrar -->
        <a href="{{ route('index') }}">
            <button class="btn-close login-close"></button>
        </a>

        <div class="login-actions">
            <label class="switch m-0">
                <input type="checkbox" id="toggleTheme" checked />
                <span class="slider"></span>
            </label>
        </div>

        <a href="#" class="btn login-register btn-register" id="openRegister">
            REGÍSTRATE
        </a>

        <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
            @if ($errors->any())
                <div id="errorToast" class="toast show border border-danger" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
                    <div class="toast-header bg-danger text-white">
                        <strong class="me-auto">Ups! Algo salió mal</strong>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>

        <!-- LOGIN -->
        <div class="login-card text-center" id="loginView">
            <h1 class="login-title mb-4">Ingresar</h1>
            <form id="loginForm" action="{{ route('login.post') }}" method="POST">
                @csrf <div class="mb-3">
                    <input type="text" name="email" class="form-control" id="loginUser" placeholder="Correo Electrónico" required />
                </div>

                <div class="mb-2 position-relative">
                    <input type="password" name="password" class="form-control" id="loginPassword" placeholder="Contraseña" required />
                    <a href="#" class="forgot-password" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">¿Se te olvidó?</a>
                </div>

                <button type="submit" class="btn btn-login w-100 mt-3">
                    INGRESAR
                </button>
            </form>
            <p class="login-legal mt-4">
                Al iniciar sesión, aceptas nuestros
                <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Términos y Política de Privacidad</a>.
            </p>
        </div>

        <!-- REGISTER -->
        <div class="login-card text-center d-none" id="registerView">
            <h1 class="login-title mb-4">Regístrate</h1>

            <form id="registerForm" action="{{ route('register.post') }}" method="POST">
                @csrf <div class="mb-3">
                    <input type="text" name="name" class="form-control" id="regUser" placeholder="Usuario" required />
                </div>

                <div class="mb-3">
                    <input type="email" name="email" class="form-control" id="regEmail" placeholder="Correo Electrónico" required />
                </div>

                <div class="mb-3">
                    <input type="password" name="password" class="form-control" id="regPassword" placeholder="Contraseña" required />
                </div>

                <div class="mb-3">
                    <input type="password" name="password_confirmation" class="form-control" id="regPassword2" placeholder="Confirmar Contraseña" required />
                </div>

                <button type="submit" class="btn btn-login w-100 mt-3">
                    REGISTRARSE
                </button>
            </form>
            <p class="login-legal mt-4">
                Al iniciar sesión, aceptas nuestros
                <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Términos y Política de Privacidad</a>.
            </p>
        </div>
    </div>

    <!-- Modal de Términos y Condiciones -->
    <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="termsModalLabel">Términos y Condiciones – Plataforma DRACO</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <p><strong>1. Introducción</strong><br>
                        Bienvenido a <strong>DRACO</strong>, una plataforma web para aprender sobre universos de
                        fantasía y videojuegos como The Lord of the Rings, GloryHammer, World of Warcraft y Minecraft.
                        Al usar nuestra página aceptas estos términos.</p>

                    <p><strong>2. Uso de la Plataforma</strong><br>
                        DRACO está destinada al aprendizaje autodidacta y entretenimiento educativo. Puede usarse desde
                        cualquier dispositivo con navegador, y debe utilizarse de manera respetuosa y ética.</p>

                    <p><strong>3. Contenido</strong><br>
                        Todo el contenido es solo con fines educativos y de entretenimiento. No se permite reproducir,
                        distribuir ni modificar el contenido sin autorización.</p>

                    <p><strong>4. Registro y Seguridad</strong><br>
                        Algunos servicios requieren registro. Eres responsable de mantener tu usuario y contraseña
                        seguros y de notificar cualquier uso no autorizado.</p>

                    <p><strong>5. Privacidad</strong><br>
                        Solo recopilamos los datos necesarios para el funcionamiento del sitio. Consulta nuestra
                        política de privacidad para más detalles.</p>

                    <p><strong>6. Modificaciones</strong><br>
                        DRACO puede actualizar estos términos en cualquier momento. Te recomendamos revisarlos
                        periódicamente.</p>

                    <p><strong>7. Limitación de Responsabilidad</strong><br>
                        DRACO no garantiza disponibilidad continua ni ausencia de errores y no se hace responsable de
                        daños derivados del uso del sitio.</p>

                    <p><strong>8. Ley Aplicable</strong><br>
                        Estos términos se rigen por la legislación española. Cualquier disputa se resolverá ante los
                        tribunales competentes.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Olvidé Contraseña -->
    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="forgotPasswordLabel">Recuperar Contraseña</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form id="forgotPasswordForm">
                        <div class="mb-3">
                            <label for="forgotEmail" class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" id="forgotEmail" placeholder="Ingresa tu correo"
                                required />
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Si hay errores y el usuario estaba intentando registrarse, 
        // mostramos la vista de registro automáticamente al recargar
        @if($errors->has('name') || $errors->has('password_confirmation'))
            document.getElementById('loginView').classList.add('d-none');
            document.getElementById('registerView').classList.remove('d-none');
        @endif
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Inicializar todos los toasts en la página
            var toastElList = [].slice.call(document.querySelectorAll('.toast'));
            var toastList = toastElList.map(function (toastEl) {
                return new bootstrap.Toast(toastEl, {
                    autohide: true,
                    delay: 5000 // Se cerrará solo después de 5 segundos
                });
            });
        });
    </script>

</body>

</html>
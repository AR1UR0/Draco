<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Draco - Aprende sobre tus temas favoritos</title>
        <link
            rel="shortcut icon"
            href="{{ asset('media/imgs/icoDraco.png') }}"
            type="image/x-icon"
        />
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/main.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/perfil/perfil.css') }}" />

        <script defer src="{{ asset('js/bootstrap.bundle.js') }}"></script>
        <script defer src="{{ asset('js/themeChange.js') }}"></script>
    </head>
    <body class="m-0">
        <div class="container-fluid">
            <div class="container-fluid p-0 g-0 ps-4 d-flex">
                <!-- CONTENEDOR PRINCIPAL -->
                <nav
                    class="flex-grow-0 pt-3 d-flex flex-column border-end border-1 border-light navPrin vh-100 pe-4 ps-1 align-items-end"
                >
                    <!-- NAVEGACIÓN -->
                    <a href="{{ route('index') }}">
                        <img
                            src="{{ asset('media/imgs/pagPrincipal/logoLetras.png') }}"
                            alt="DRACO"
                            class="logoDraco mb-5"
                        />
                    </a>
                    <a href="{{ route('pagPrincipal') }}" class="mb-4 me-3 enlPrin"
                        >Aprender</a
                    >
                    <a href="{{ route('store') }}" class="mb-4 me-3 enlPrin">Tienda</a>
                    <a href="{{ route('admin') }}" class="mb-4 me-3 enlPrin">Admin</a>
                </nav>

                <main class="flex-grow-1 p-2">
                    <div class="p-1 d-flex align-items-center justify-content-end mb-1">
                        <div class="form-check form-switch me-3">
                            <label class="switch">
                                <input type="checkbox" id="toggleTheme" checked />
                                <span class="slider"></span>
                            </label>
                        </div>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btnSemiTran">Log Out</button>
                        </form>
                    </div>

                    <!-- PERFIL -->
                    <div class="container-fluid px-3 px-md-5">
                        <div
                            class="row align-items-center gy-4 ps-5 justify-content-center justify-content-md-start"
                        >
                            <div
                                class="col-12 col-md-auto d-flex justify-content-center"
                            >
                                <div
                                    class="imgPerfil d-flex justify-content-end p-3 border border-2 border-light"
                                >
                                    <button class="btnEditFotoPerfil">
                                        <img
                                            src="{{ asset('media/imgs/iconos/pencil.png') }}"
                                            alt="Editar"
                                        />
                                    </button>
                                </div>
                            </div>

                            <div class="col text-center text-md-start">
                                <h2
                                    class="d-flex justify-content-center justify-content-md-start align-items-center gap-2"
                                >
                                    <span class="username"
                                        >{{ Auth::user()->name}}</span
                                    >
                                    <button class="btnEditNombreUsuario">
                                        <img
                                            src="{{ asset('media/imgs/iconos/pencil.png') }}"
                                            alt="Editar"
                                        />
                                    </button>
                                </h2>

                                <p class="gray-text">
                                    {{ Auth::user()->email }}
                                </p>
                                <p class="gray-text">
                                    Se unió en
                                    <span class="fecha">{{ Auth::user()->created_at->format('d/m/Y') }}</span>
                                </p>
                            </div>
                        </div>
                    </div>


                    <div class="container-fluid ms-5 ps-3">
                        <div class="row">
                            <div class="col-md-3 d-flex flex-column gap-5 mt-4">
                                <button class="btnAdmin">TEMÁTICA</button>
                                <button class="btnAdmin">AÑADIR PREGUNTA</button>
                                <button class="btnAdmin active-admin">MODIFICAR PREGUNTA</button>
                                <button class="btnAdmin">ELIMINAR PREGUNTA</button>
                            </div>

                            <div class="col-md-7">
                                <div class="admin-card">
                                    <div class="d-flex justify-content-center">
                                        <span class="badge-nivel">NIVEL</span>
                                    </div>
                                    <div class="admin-content-area">
                                        </div>
                                    <div class="d-flex justify-content-center">
                                        <button class="btn-terminar">TERMINAR</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <script src="{{ asset('js/bootstrap.bundle.js') }}"></script>
        <script src="{{ asset('js/autotranslate.js') }}"></script>
        <div id="gt" style="display:none"></div>
    </body>
</html>
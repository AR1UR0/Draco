<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0"
        />
        <title>Draco - Aprende sobre tus temas favoritos</title>

        <link
            rel="shortcut icon"
            href="{{ asset('media/imgs/icoDraco.png') }}"
            type="image/x-icon"
        />
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/main.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/perfil/perfil.css') }}" />
    </head>

    <body class="m-0">
        <div class="container-fluid p-0">
            <div class="row g-0">
                <div class="navPrin col-12 col-md-auto border-end border-light">
                    <nav
                        class="navPrin vh-md-100 p-3 d-none d-md-flex flex-column align-items-end "
                    >
                        <a href="{{ route('index') }}">
                            <img
                                src="{{ asset('media/imgs/pagPrincipal/logoLetras.png') }}"
                                alt="DRACO"
                                class="logoDraco mb-5"
                            />
                        </a>
                        <a href="{{ route('pagPrincipal') }}" class="d-block mb-3 enlPrin">Aprender</a>
                        <a href="{{ route('store') }}" class="d-block mb-3 enlPrin">Tienda</a>
                        <a href="{{ route('perfil') }}" class="d-block mb-3 enlPrin">Perfil</a>
                    </nav>

                    <div
                        class="d-flex d-md-none align-items-center justify-content-between p-2"
                    >
                        <a href="{{ route('pagPrincipal') }}">
                            <img
                                src="{{ asset('media/imgs/pagPrincipal/logoLetras.png') }}"
                                alt="DRACO"
                                class="logoDraco ms-3"
                            />
                        </a>

                        <button
                            class="btn btn-outline-secondary me-3 btnHamb text-light"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#menuHamburger"
                            aria-controls="menuHamburger"
                            aria-expanded="false"
                            aria-label="Toggle navigation"
                        >
                            <span>
                                <img
                                    src="{{ asset('media/imgs/menuDark.png') }}"
                                    alt="="
                                    style="width: 40px"
                                />
                            </span>
                        </button>
                    </div>

                    <div class="collapse d-md-none" id="menuHamburger">
                        <div class="menuHamb">
                            <a href="{{ route('pagPrincipal') }}" class="d-block py-3 enlPrinWider">Aprender</a>
                            <a href="{{ route('store') }}" class="d-block py-3 enlPrinWider">Tienda</a>
                            <a href="{{ route('perfil') }}" class="d-block py-3 enlPrinWider">Perfil</a>
                        </div>
                    </div>
                    
                    <hr class="border border-light mb-4 mt-2 d-block d-md-none" />
                </div>

                <main class="col p-0">
                    <div
                        class="p-3 d-flex justify-content-end align-items-center gap-3"
                    >
                        <!-- DROPDOWN IDIOMAS -->
                        <div class="dropdown d-none d-sm-block">
                            <button class="btn btn-idioma dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                Page Language
                            </button>

                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="#" onclick="setLanguage('en'); return false;">
                                        English
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#" onclick="setLanguage('es'); return false;">
                                        Spanish
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <label class="switch">
                            <input type="checkbox" id="toggleTheme" checked />
                            <span class="slider"></span>
                        </label>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btnSemiTran">Log Out</button>
                        </form>
                    </div>

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
                                    <span class="username">{{ Auth::user()->name }}</span>
                                    <button class="btnEditNombreUsuario">
                                        <img
                                            src="{{ asset('media/imgs/iconos/pencil.png') }}"
                                            alt="Editar"
                                        />
                                    </button>
                                </h2>

                                <p class="gray-text">{{ Auth::user()->email }}</p>
                                <p class="gray-text">
                                    Se unió en
                                    <span class="fecha">{{ Auth::user()->created_at->format('d/m/Y') }}</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="container-fluid px-3 px-md-5 mt-5 justify-content-center justify-content-md-start"
                    >
                        <h4
                            class="fw-bolder ms-5 mb-4 text-center text-md-start"
                        >
                            Estadísticas
                        </h4>
                        <div class="row d-flex justify-content-center">
                            <div
                                class="col-10 col-md-4 bloqueStats d-flex align-items-center"
                            >
                                <img
                                    src="{{ asset('media/imgs/iconos/burn.png') }}"
                                    class="fotoStats"
                                />
                                <div><span class="racha">&nbsp;{{ Auth::check() ? (Auth::user()->streak ?? 0) : 0 }}</span><br />Días de racha</div>
                            </div>

                            <div
                                class="col-10 col-md-4 bloqueStats d-flex align-items-center"
                            >
                                <img
                                    src="{{ asset('media/imgs/iconos/storm.png') }}"
                                    class="fotoStats"
                                />
                                <div><span class="racha">&nbsp;&nbsp;{{ Auth::check() ? Auth::user()->points : 0 }}</span><br />EXP ganada</div>
                            </div>

                            <div
                                class="col-10 col-md-4 bloqueStats d-flex align-items-center"
                            >
                                <img
                                    src="{{ asset('media/imgs/iconos/coin.png') }}"
                                    class="fotoStats"
                                />
                                <div>7000<br />Monedas</div>
                            </div>

                            <div
                                class="col-10 col-md-4 bloqueStats d-flex align-items-center"
                            >
                                <img
                                    src="{{ asset('media/imgs/iconos/heart.png') }}"
                                    class="fotoStats"
                                />
                                <div><span class="racha">&nbsp;{{ Auth::check() ? Auth::user()->current_lives : 5 }}</span><br />Vidas</div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <script src="{{ asset('js/bootstrap.bundle.js') }}"></script>
        <script src="{{ asset('js/themeChange.js') }}"></script>
        <script src="{{ asset('js/toastCopy.js') }}"></script>
                
        <div id="google_translate_element"></div>

        <script>
            function setCookie(name, value, days = 365) {
                const d = new Date();
                d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
                document.cookie = name + "=" + value + ";expires=" + d.toUTCString() + ";path=/";
            }

            function getCookie(name) {
                const cname = name + "=";
                const decodedCookie = decodeURIComponent(document.cookie);
                const ca = decodedCookie.split(';');
                for(let i = 0; i < ca.length; i++) {
                    let c = ca[i].trim();
                    if (c.indexOf(cname) == 0) return c.substring(cname.length);
                }
                return null;
            }

            // GOOGLE INIT
            function googleTranslateElementInit() {
                new google.translate.TranslateElement({
                    pageLanguage: 'es',
                    autoDisplay: false
                }, 'google_translate_element');
            }

            // SET LANGUAGE
            function setLanguage(lang) {
                setCookie("site_lang", lang);

                document.querySelector('.btn-idioma').textContent =
                    lang === 'en' ? 'English' : 'Spanish';

                const interval = setInterval(() => {
                    const select = document.querySelector('.goog-te-combo');

                    if (select) {
                        select.value = lang;
                        select.dispatchEvent(new Event('change'));
                        clearInterval(interval);
                    }
                }, 100);
            }

            // AUTO LOAD
            window.addEventListener('load', () => {
                let lang = getCookie("site_lang");

                if (!lang) {
                    lang = "en";
                    setCookie("site_lang", "en");
                }

                setLanguage(lang);
            });
        </script>

        <script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

    </body>
</html>
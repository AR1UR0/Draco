<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Draco - Aprende sobre tus temas favoritos</title>
    <link rel="shortcut icon" href="{{ asset('media/imgs/icoDraco.png') }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/firstConfig.css') }}" />
</head>

<body>
    <div class="d-flex flex-column min-vh-100">
        <!-- HEADER -->
        <header class="container d-flex justify-content-between align-items-center py-3">
            <a href="{{ route('index') }}">
                <img src="{{ asset('media/imgs/logoDraco.png') }}" alt="Draco" class="logoDraco" />
            </a>

            <div class="d-flex align-items-center gap-3">
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

                <!-- CAMBIO DE TEMA -->
                <label class="switch m-0">
                    <input type="checkbox" id="toggleTheme" checked />
                    <span class="slider"></span>
                </label>
            </div>
        </header>
        <main class="flex-grow-1 d-flex align-items-center py-5">
            <div class="container text-center">
                <section id="step-1">
                    <h4 class="mb-4 fw-semibold">Quiero aprender sobre:</h4>

                    <div class="row justify-content-center g-4">
                        <div class="col-6 col-md-4">
                            <div class="topic-card">
                                <div class="topic-inner">
                                    <div class="topic-front notranslate">Berserk</div>
                                    <div class="topic-back">
                                        <img src="{{ asset('media/imgs/temas/berserk.jpg') }}" alt="Berserk">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-md-4">
                            <div class="topic-card">
                                <div class="topic-inner">
                                    <div class="topic-front notranslate">LOTR</div>
                                    <div class="topic-back">
                                        <img src="{{ asset('media/imgs/temas/lotr.jpg') }}" alt="Lord of the Rings">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-md-4">
                            <div class="topic-card">
                                <div class="topic-inner">
                                    <div class="topic-front notranslate">GloryHammer</div>
                                    <div class="topic-back">
                                        <img src="{{ asset('media/imgs/temas/gloryhammer.jpg') }}" alt="GloryHammer">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-md-4">
                            <div class="topic-card">
                                <div class="topic-inner">
                                    <div class="topic-front notranslate">WoW</div>
                                    <div class="topic-back">
                                        <img src="{{ asset('media/imgs/temas/wow.jpg') }}" alt="World of Warcraft">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-md-4">
                            <div class="topic-card">
                                <div class="topic-inner">
                                    <div class="topic-front notranslate">Mitología</div>
                                    <div class="topic-back">
                                        <img src="{{ asset('media/imgs/temas/mitologia.jpg') }}" alt="Mitología">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-md-4">
                            <div class="topic-card">
                                <div class="topic-inner">
                                    <div class="topic-front notranslate">Star Wars</div>
                                    <div class="topic-back">
                                        <img src="{{ asset('media/imgs/temas/starwars.jpg') }}" alt="Star Wars">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5">
                        <button id="btn-continuar" class="btn btn-step-next px-5">CONTINUAR</button>
                    </div>
                </section>
                <section id="step-2" class="d-none">
                    <h4 class="mb-4 fw-semibold">¿Cuál es tu meta diaria?</h4>
                    <div class="d-flex flex-column align-items-center gap-3">
                        <button class="btn btn-meta-option">5 min/día</button>
                        <button class="btn btn-meta-option">10 min/día</button>
                        <button class="btn btn-meta-option">15 min/día</button>
                        <button class="btn btn-meta-option">+20 min/día</button>
                    </div>

                    <div class="mt-5">
                        <button id="btn-to-step-3" class="btn btn-step-next px-5">CONTINUAR</button>
                    </div>
                </section>
                <section id="step-3" class="d-none">
                    <h4 class="mb-4 fw-semibold">¿Desde donde quieres empezar?</h4>

                    <div class="d-flex flex-column align-items-center gap-4">
                        <div id="start-beginner" class="level-card d-flex align-items-center p-3">
                            <img src="{{ asset('media/imgs/iconos/libro-icon.png') }}" alt="Libro" class="level-icon me-3">
                            <div class="text-start">
                                <h5 class="mb-1 fw-bold">Desde el principio</h5>
                                <p class="mb-0 text-muted">Completa el nivel más fácil sobre tu tema</p>
                            </div>
                        </div>

                        <div id="start-placement" class="level-card d-flex align-items-center p-3">
                            <img src="{{ asset('media/imgs/iconos/lupa-icon.png') }}" alt="Lupa" class="level-icon me-3">
                            <div class="text-start">
                                <h5 class="mb-1 fw-bold">Elegir el nivel</h5>
                                <p class="mb-0 text-muted">Podrás elegir el nivel con el que quieres empezar</p>
                            </div>
                        </div>
                    </div>
                </section>
                <section id="step-4" class="d-none">
                    <h4 class="mb-4 fw-semibold">Selecciona tu nivel de conocimiento:</h4>

                    <div class="d-flex flex-column align-items-center gap-3">
                        <button id="lvl-1" class="btn btn-meta-option">
                            <span class="fw-bold">Nivel 1</span> - Principiante
                        </button>

                        <button id="lvl-2" class="btn btn-meta-option">
                            <span class="fw-bold">Nivel 2</span> - Intermedio
                        </button>

                        <button id="lvl-3" class="btn btn-meta-option">
                            <span class="fw-bold">Nivel 3</span> - Avanzado
                        </button>
                    </div>

                    <div class="mt-4">
                        <a href="#" id="back-to-step-3" class="btn btn-step-next px-5">
                            <i class="bi bi-arrow-left"></i> VOLVER
                        </a>
                    </div>
                </section>
            </div>
        </main>

        <script src="{{ asset('js/bootstrap.bundle.js') }}"></script>
        <script src="{{ asset('js/themeChange.js') }}"></script>
        <script src="{{ asset('js/firstConfig/script.js') }}"></script>
        
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
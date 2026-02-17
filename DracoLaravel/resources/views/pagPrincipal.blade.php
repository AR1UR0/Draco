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
        <link rel="stylesheet" href="{{ asset('css/pagPrincipal/pagPrincipal.css') }}" />
    </head>
    <body>
        <div class="container-fluid">
            
            <div class="container-fluid p-0 g-0 ps-md-4 d-flex mainContainer">
                <!-- CONTENEDOR PRINCIPAL -->
                <nav
                    class="d-none d-lg-flex flex-grow-0 pt-3 d-flex flex-column border-end border-1 border-light navPrin vh-100 pe-2 ps-1 align-items-end"
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

                    @auth
                    <a href="{{ route('store') }}" class="mb-4 me-3 enlPrin">Tienda</a>
                        @if(Auth::user()->role_id==1)
                        <a href="{{ route('admin') }}" class="mb-4 me-3 enlPrin">Admin</a>
                        @else
                        <a href="{{ route('perfil') }}" class="mb-4 me-3 enlPrin">Perfil</a>
                        @endif
                    @endauth

                </nav>
                <main class="d-none d-md-block flex-grow-1">
                    <!-- CONTENIDO PRINCIPAL -->
                    <div class="topMainContent">
                        <span class="tema notranslate">Berserk</span>: FASE
                        <span class="fase">1 Niveles</span>
                    </div>
                    <!-- MAPA DE LOS ELEMENTOS EN UN GRID DE BOOTSTRAP -->
                    <div class="mainContent">
                    <div class="row">
                        <div class="col-4 colMain">
                            <button class="btn-round" onclick="irAlQuiz(1)">1</button>
                        </div>
                        <div class="col-4 colMain">
                            <button class="btn-round" onclick="irAlQuiz(2)">2</button>
                        </div>
                        <div class="col-4 colMain"></div>
                    </div>
                    <div class="row">
                        <div class="col-4 colMain"></div>
                        <div class="col-4 colMain"></div>
                        <div class="col-4 colMain">
                            <button class="btn-round" onclick="irAlQuiz(3)">3</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 colMain"></div>
                        <div class="col-4 colMain">
                            <button class="btn-round" onclick="irAlQuiz(4)">4</button>
                        </div>
                        <div class="row">
                            <div class="col-4 colMain">
                                <button class="btn-round" onclick="irAlQuiz(5)">5</button>
                            </div>
                            <div class="col-4 colMain"></div>
                            <div class="col-4 colMain"></div>
                        </div>
                        <div class="row">
                            <div class="col-4 colMain"></div>
                            <div class="col-4 colMain">
                                <button class="btn-round" onclick="irAlQuiz(6)">6</button>
                            </div>
                            <div class="col-4 colMain">
                                <button class="btn-round" onclick="irAlQuiz(7)">7</button>
                            </div>
                        </div>
                    </div>
                    </div>
                </main>
                <aside
                    class="flex-grow-1 flex-md-grow-0 pt-3 ps-3 border-start border-md-1 border-light asidePrin vh-100 d-flex flex-column"
                >
                    <!-- MENU HAMBURGUESA -->
                    <div
                        class="d-flex d-md-none align-items-center justify-content-between p-2"
                    >
                        <a href="{{ route('index') }}">
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
                            <span
                                ><img
                                    src="{{ asset('media/imgs/menuDark.png') }}"
                                    alt="="
                                    style="width: 40px"
                            /></span>
                        </button>
                    </div>

                    <div class="collapse d-md-none" id="menuHamburger">
                        <div class="menuHamb">
                            <a href="{{ route('pagPrincipal') }}" class="d-block py-3 enlPrinWider"
                                >Aprender</a
                            >
                            
                            @auth
                            <a href="{{ route('store') }}" class="d-block py-3 enlPrinWider">Tienda</a>
                                @if(Auth::user()->role_id==1)
                                <a href="{{ route('admin') }}" class="d-block py-3 enlPrinWider">Admin</a>
                                @else
                                <a href="{{ route('perfil') }}" class="d-block py-3 enlPrinWider">Perfil</a>
                                @endif
                            @endauth
                        </div>
                    </div>
                    <hr
                        class="border border-light mb-4 mt-2 d-block d-md-none"
                    />
                    <!-- PANEL LATERAL -->
                    <div
                        class="d-flex flex-grow-0 parteArriba justify-content-evenly align-items-center mb-3 me-5"
                    >
                        <!-- IMAGENES DE TEMA, RACHA, DINERO Y VIDAS -->
                        <div>
                            
                            <div class="dropdown d-none d-sm-block">
                                <button class="btn btn-temas dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ asset('media/imgs/temas/berserk.jpg') }}" id="imgPrincipal" class="border border-light imgTema" />
                                </button>
                                
                                <ul class="dropdown-menu">
                                    <div class="d-flex justify-content-center align-items-center">
                                        @foreach($tematicas as $tematica)
                                            <li>
                                                <a class="dropdown-item p-1" href="#" 
                                                    onclick="cambiarImagenYGuardarId('{{ asset('media/imgs/temas/' . $tematica->image) }}', '{{ $tematica->name }}', '{{ $tematica->id }}')">
                                                    <img src="{{ asset('media/imgs/temas/' . $tematica->image) }}" 
                                                    class="border border-light imgTema imgTemaDropdown" 
                                                    alt="{{ $tematica->name }}"
                                                    id="imgTema{{ $tematica->id }}" />
                                                </a>
                                            </li>
                                        @endforeach
                                    </div>
                                </ul>
                            </div>
                        </div>
                        <div
                            class="d-flex align-items-center justify-content-center"
                        >
                            <img
                                src="{{ asset('media/imgs/iconos/burn.png') }}"
                                alt="Racha:"
                                class="imgIco"
                            />
                            <span class="racha">&nbsp;{{ Auth::check() ? (Auth::user()->streak ?? 0) : 0 }}</span>
                        </div>
                        <div
                            class="d-flex align-items-center justify-content-center"
                        >
                            <img
                                src="{{ asset('media/imgs/iconos/coin.png') }}"
                                alt="Dinero:"
                                class="imgIco"
                            />
                            <span class="racha">&nbsp;{{ Auth::check() ? Auth::user()->points : 0 }}</span>
                        </div>
                        <div
                            class="d-flex align-items-center justify-content-center"
                        >
                            <img
                                src="{{ asset('media/imgs/iconos/heart.png') }}"
                                alt="Vida:"
                                class="imgIco"
                            />
                            <span class="racha">&nbsp;{{ Auth::check() ? Auth::user()->current_lives : 5 }}</span>
                        </div>
                    </div>
                    <hr
                        class="border border-light mb-2 mt-2 d-block d-md-none"
                    />
                    <!-- DIV PARA DRACO PLUS Y ANUNCIO -->
                    <div
                        class="d-none flex-grow-0 d-md-flex flex-column justify-content-between"
                    >
                        <!-- DRACO PLUS -->
                        <div
                            class="dracoPlus dracoPlusGlow flex-grow-1 align-items-center justify-content-center d-flex flex-column"
                        >
                            <div class="content">
                                <h2>Draco Plus</h2>
                                <p>
                                    ¡Desbloquea contenido exclusivo y racha
                                    infinita!
                                </p>
                                <button class="btn btnPlus px-4 py-2 mt-2" data-bs-toggle="modal" data-bs-target="#modalPago">
                                PRUEBA PLUS GRATIS
                                </button>
                            </div>
                        </div>
                        <!-- ANUNCIO -->
                        <div class="panelAnuncio flex-grow-1">
                            <a href="https://LAPAGINAWEB.com" target="_blank" class="anuncio-link">
                                <img
                                    src="{{ asset('media/pruebaAnuncio.jpg') }}"
                                    alt="Anuncio"
                                    class="imgAnuncio"
                                />
                                <div class="overlay-button">
                                    <button class="btnAnuncio">VISITAR WEB</button>
                                </div>
                            </a>
                        </div>
                    </div>
                    <!-- DIV RESPONSIVE -->
                    <div class="d-block d-md-none">
                        <!-- CONTENIDO PRINCIPAL -->
                        <div class="topMainContent">
                        <span class="tema notranslate">Berserk</span>: FASE
                        <span class="fase">1</span>
                        </div>
                        <!-- MAPA DE LOS ELEMENTOS EN UN GRID DE BOOTSTRAP -->
                       <div class="mainContent">
                        <div class="row">
                            <div class="col-4 colMain">
                                <button class="btn-round" onclick="irAlQuiz(1)">1</button>
                            </div>
                            <div class="col-4 colMain">
                                <button class="btn-round" onclick="irAlQuiz(2)">2</button>
                            </div>
                            <div class="col-4 colMain"></div>
                        </div>
                        <div class="row">
                            <div class="col-4 colMain"></div>
                            <div class="col-4 colMain"></div>
                            <div class="col-4 colMain">
                                <button class="btn-round" onclick="irAlQuiz(3)">3</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 colMain"></div>
                            <div class="col-4 colMain">
                                <button class="btn-round" onclick="irAlQuiz(4)">4</button>
                            </div>
                            <div class="col-4 colMain"></div>
                        </div>
                        <div class="row">
                            <div class="col-4 colMain">
                                <button class="btn-round" onclick="irAlQuiz(5)">5</button>
                            </div>
                            <div class="col-4 colMain"></div>
                            <div class="col-4 colMain"></div>
                        </div>
                        <div class="row">
                            <div class="col-4 colMain"></div>
                            <div class="col-4 colMain">
                                <button class="btn-round" onclick="irAlQuiz(6)">6</button>
                            </div>
                            <div class="col-4 colMain">
                                <button class="btn-round" onclick="irAlQuiz(7)">7</button>
                            </div>
                        </div>
                    </div>
                    </div>
                    <hr
                        class="border border-light mb-2 mt-2 d-block d-md-none"
                    />
                    <footer
                        class="flex-grow-0 ms-2 ms-md-0 mt-3 pb-4 pb-md-0 container text-center d-flex d-sm-none d-md-flex flex-column"
                    >
                        <!-- FOOTER LATERAL -->
                        <div class="row">
                            <div class="col-4 col4">
                                <a
                                    href="#"
                                    data-bs-toggle="modal"
                                    data-bs-target="#contactModal"
                                    >Contáctanos</a
                                >
                            </div>
                            <div class="col-8">
                                <a
                                    href="#"
                                    data-bs-toggle="modal"
                                    data-bs-target="#termsModal"
                                    >Términos de Privacidad</a
                                >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col colF">
                                <a
                                    href="#"
                                    data-bs-toggle="modal"
                                    data-bs-target="#aboutModal"
                                    >Sobre Nosotros</a
                                >
                            </div>
                            <div class="col colF">
                                <a href="#" id="liveToastBtn">Copyright</a>
                            </div>
                            <div class="col colF">
                                <a
                                    href="#"
                                    data-bs-toggle="modal"
                                    data-bs-target="#mapModal"
                                    >Dirección</a
                                >
                            </div>
                        </div>
                        <div
                            class="d-none container mt-4 mb-4 justify-content-evenly align-items-center d-md-flex"
                        >
                            <img
                                src="{{ asset('media/imgs/iconos/instagram.png') }}"
                                alt="Instagram"
                                class="imgFooterPrin"
                            />
                            <img
                                src="{{ asset('media/imgs/iconos/twitter.png') }}"
                                alt="Twitter"
                                class="imgFooterPrin"
                            />
                            <img
                                src="{{ asset('media/imgs/iconos/facebook.png') }}"
                                alt="Facebook"
                                class="imgFooterPrin"
                            />
                        </div>
                    </footer>
                    <footer
                        class="footerMD d-none d-sm-flex d-md-none d-flex flex-column text-center mt-3 pb-4 pb-md-0"
                    >
                        <div class="row">
                            <div class="col colF">
                                <a
                                    href="#"
                                    data-bs-toggle="modal"
                                    data-bs-target="#contactModal"
                                    >Contáctanos</a
                                >
                            </div>
                            <div class="col colF">
                                <a
                                    href="#"
                                    data-bs-toggle="modal"
                                    data-bs-target="#termsModal"
                                    >Términos de Privacidad</a
                                >
                            </div>
                            <div class="col colF">
                                <a
                                    href="#"
                                    data-bs-toggle="modal"
                                    data-bs-target="#aboutModal"
                                    >Sobre Nosotros</a
                                >
                            </div>
                            <div class="col colF">
                                <a href="#" id="liveToastBtn">Copyright</a>
                            </div>
                            <div class="col colF">
                                <a
                                    href="#"
                                    data-bs-toggle="modal"
                                    data-bs-target="#mapModal"
                                    >Dirección</a
                                >
                            </div>
                        </div>
                        <div
                            class="d-none d-sm-flex d-md-none container mt-4 mb-4 justify-content-evenly align-items-center"
                        >
                            <img
                                src="{{ asset('media/imgs/iconos/instagram.png') }}"
                                alt="Instagram"
                                class="imgFooterPrin"
                            />
                            <img
                                src="{{ asset('media/imgs/iconos/twitter.png') }}"
                                alt="Twitter"
                                class="imgFooterPrin"
                            />
                            <img
                                src="{{ asset('media/imgs/iconos/facebook.png') }}"
                                alt="Facebook"
                                class="imgFooterPrin"
                            />
                        </div>
                    </footer>
                </aside>
            </div>
        </div>

        <!-- TOAST COPYRIGHT -->
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div
                id="liveToast"
                class="toast"
                role="alert"
                aria-live="assertive"
                aria-atomic="true"
            >
                <div
                    class="toast-header d-flex justify-content-between align-items-center"
                >
                    <img
                        src="{{ asset('media/imgs/icoDraco.png') }}"
                        class="rounded me-2"
                        alt="..."
                        style="width: 25px"
                    />
                    <div
                        class="d-flex justify-content-center align-items-center"
                    >
                        <small>Draco &copy;</small>
                        <button
                            type="button"
                            class="btn-close me-2"
                            data-bs-dismiss="toast"
                            aria-label="Close"
                        ></button>
                    </div>
                </div>
                <div class="toast-body">
                    Copyright &copy; 2025-2026 Draco Enterprises. All rights
                    reserved.
                </div>
            </div>
        </div>

        <!-- MODAL DE TÉRMINOS Y CONDICIONES -->
        <div
            class="modal fade"
            id="termsModal"
            tabindex="-1"
            aria-labelledby="termsModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <img
                                src="{{ asset('media/imgs/icoDraco.png') }}"
                                class="rounded me-2"
                                alt="..."
                                style="width: 25px"
                            />
                        <h5 class="modal-title" id="termsModalLabel">
                            Términos y Condiciones – DRACO
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Cerrar"
                        ></button>
                    </div>
                    <div class="modal-body texto-justificado">
                        <p>
                            <strong>1. Introducción</strong><br />
                            Bienvenido a <strong>DRACO</strong>, una plataforma
                            web para aprender sobre universos de fantasía y
                            videojuegos como The Lord of the Rings, GloryHammer,
                            World of Warcraft y Minecraft. Al usar nuestra
                            página aceptas estos términos.
                        </p>

                        <p>
                            <strong>2. Uso de la Plataforma</strong><br />
                            DRACO está destinada al aprendizaje autodidacta y
                            entretenimiento educativo. Puede usarse desde
                            cualquier dispositivo con navegador, y debe
                            utilizarse de manera respetuosa y ética.
                        </p>

                        <p>
                            <strong>3. Contenido</strong><br />
                            Todo el contenido es solo con fines educativos y de
                            entretenimiento. No se permite reproducir,
                            distribuir ni modificar el contenido sin
                            autorización.
                        </p>

                        <p>
                            <strong>4. Registro y Seguridad</strong><br />
                            Algunos servicios requieren registro. Eres
                            responsable de mantener tu usuario y contraseña
                            seguros y de notificar cualquier uso no autorizado.
                        </p>

                        <p>
                            <strong>5. Privacidad</strong><br />
                            Solo recopilamos los datos necesarios para el
                            funcionamiento del sitio. Consulta nuestra política
                            de privacidad para más detalles.
                        </p>

                        <p>
                            <strong>6. Modificaciones</strong><br />
                            DRACO puede actualizar estos términos en cualquier
                            momento. Te recomendamos revisarlos periódicamente.
                        </p>

                        <p>
                            <strong>7. Limitación de Responsabilidad</strong
                            ><br />
                            DRACO no garantiza disponibilidad continua ni
                            ausencia de errores y no se hace responsable de
                            daños derivados del uso del sitio.
                        </p>

                        <p>
                            <strong>8. Ley Aplicable</strong><br />
                            Estos términos se rigen por la legislación española.
                            Cualquier disputa se resolverá ante los tribunales
                            competentes.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL SOBRE NOSOTROS -->
        <div
            class="modal fade"
            id="aboutModal"
            tabindex="-1"
            aria-labelledby="aboutModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <img
                                src="{{ asset('media/imgs/icoDraco.png') }}"
                                class="rounded me-2"
                                alt="..."
                                style="width: 25px"
                            />
                        <h5 class="modal-title" id="aboutModalLabel">
                            Sobre Nosotros – DRACO
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Cerrar"
                        ></button>
                    </div>
                    <div class="modal-body texto-justificado">
                        <p>
                            Draco es un proyecto educativo y tecnológico diseñado para
                            ofrecer a los usuarios una plataforma interactiva donde puedan 
                            aprender y explorar sus temas favoritos de manera intuitiva y visual. 
                            Nuestro objetivo es crear un espacio donde el conocimiento se presente 
                            de forma clara, atractiva y accesible desde cualquier dispositivo.
                        </p>
                        <p>
                            Nuestro equipo ha trabajado para que la experiencia de usuario sea fluida 
                            y atractiva: desde la elección de colores y tipografías hasta la implementación 
                            de funcionalidades que permiten personalizar la navegación. Además, Draco 
                            incluye elementos de identidad visual como su icono distintivo, lo que refuerza 
                            la experiencia de marca y facilita la identificación de la plataforma.
                        </p>
                        <p>
                            Estamos comprometidos con la innovación y la calidad educativa, ofreciendo un 
                            entorno seguro y confiable para estudiantes y curiosos por igual. Nuestro objetivo 
                            final es empoderar a los usuarios, facilitando el aprendizaje autónomo y fomentando 
                            la exploración de nuevos conocimientos.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL MAPA/DIRECCIÓN -->
        <div class="modal fade" id="mapModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="d-flex align-items-center">
                            <img
                                src="{{ asset('media/imgs/icoDraco.png') }}"
                                class="rounded me-2"
                                alt="..."
                                style="width: 25px"
                            />
                            <h5 class="modal-title">Nuestra Ubicación</h5>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><i class="notranslate">Carrer D'Alberic, 18, Extramurs, 46008 València, Valencia</i></p>
                        <div id="map" style="width: 100%; height: 400px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL CONTACTOS -->
        <div class="modal fade" id="contactModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="d-flex align-items-center">
                            <img
                                src="{{ asset('media/imgs/icoDraco.png') }}"
                                class="rounded me-2"
                                alt="..."
                                style="width: 25px"
                            />
                            <h5 class="modal-title">Los miembros del equipo</h5>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex align-items-center justify-content-between gap-4 ps-5 pe-5">
                        <div class="d-flex flex-column justify-content-center gap-3">
                            <p><small>Arturo Ortiz López</small></p>
                            <img 
                                src="{{ asset('media/imgs/iconos/linkedin.png') }}"
                                class="rounded me-2" 
                                alt="LinkedIn"
                                style="width: 150px; cursor: pointer;"
                                onclick="window.open('https://www.linkedin.com/in/arturo-ortiz-lópez-a323152aa/', '_blank')"
                            />
                        </div>
                        <div class="d-flex flex-column justify-content-center gap-3">
                            <p><small>Thais Núñez Agulló</small></p>
                            <img 
                                src="{{ asset('media/imgs/iconos/linkedin.png') }}"
                                class="rounded me-2" 
                                alt="LinkedIn"
                                style="width: 150px; cursor: pointer;"
                                onclick="window.open('https://www.linkedin.com/in/thais-nu%C3%B1ez-agullo-93840019a/', '_blank')"
                            />
                        </div>
                        <div class="d-flex flex-column justify-content-center gap-3">
                            <p><small>Marta Clemente Collado</small></p>
                            <img 
                                src="{{ asset('media/imgs/iconos/linkedin.png') }}"
                                class="rounded me-2" 
                                alt="LinkedIn"
                                style="width: 150px; cursor: pointer;"
                                onclick="window.open('https://www.linkedin.com/in/marta-clemente-collado-6616b227b/', '_blank')"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
<!-- Modal para el pago de DracoPlus -->
<div class="modal fade" id="modalPago" tabindex="-1" aria-labelledby="modalPagoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalPagoLabel">Suscribirse a Draco Plus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="paymentForm">
                    <div class="mb-4 text-center">
                        <div class="btn-group w-100" role="group" aria-label="Métodos de pago">
                            <input type="radio" class="btn-check" name="payMethod" id="methodCard" autocomplete="off" checked onclick="switchPay('card')">
                            <label class="btn btn-outline-draco" for="methodCard">Tarjeta Bancaria</label>

                            <input type="radio" class="btn-check" name="payMethod" id="methodIban" autocomplete="off" onclick="switchPay('iban')">
                            <label class="btn btn-outline-draco" for="methodIban">IBAN / SEPA</label>
                        </div>

                    <div id="sectionCard">
                        <div class="mb-3">
                            <label class="form-label small text-uppercase fw-bold">Titular de la tarjeta</label>
                            <input type="text" class="form-control" placeholder="Nombre completo" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small text-uppercase fw-bold">Número de tarjeta</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="0000 0000 0000 0000" id="numTarj" required>
                                <span class="input-group-text"><i class="bi bi-credit-card"></i></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label small text-uppercase fw-bold">Fecha Exp.</label>
                                <input type="text" class="form-control" placeholder="MM/AA" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label small text-uppercase fw-bold">CVC/CVV</label>
                                <input type="password" class="form-control" placeholder="123" maxlength="4" required>
                            </div>
                        </div>
                    </div>

                    <div id="sectionIban" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label small text-uppercase fw-bold">Número de cuenta (IBAN)</label>
                            <input type="text" class="form-control" placeholder="ES00 0000 0000 0000 0000">
                            <div class="form-text mt-2">Se domiciliará el pago mensualmente en tu cuenta bancaria.</div>
                        </div>
                    </div>

                    <div class="alert alert-primary py-2 d-flex align-items-center btn-outline-draco">
                        <small>Pago seguro encriptado por DracoSecure.</small>
                    </div>

                    <button type="submit" class="btn btnPlus w-100 py-2 fw-bold text-uppercase mt-3">Confirmar Suscripción</button>
                </form>
            </div>
        </div>
    </div>
</div>

        <!-- SCRIPTS -->
        <script src="{{ asset('js/bootstrap.bundle.js') }}"></script>
        <script src="{{ asset('js/themeChange.js') }}"></script>
        <script src="{{ asset('js/toastCopy.js') }}"></script>
        <script>
            function cambiarImagen(nuevaRuta, nombreTema) {
                document.getElementById('imgPrincipal').src = nuevaRuta;
                document.querySelector('.tema').textContent = nombreTema;
            }
        </script>
        <script>
            let map;
            const urlParams = new URLSearchParams(window.location.search);
            let temaSeleccionadoId = urlParams.get("tematica");
            

    function cambiarImagenYGuardarId(ruta, nombre, id) {
        // 1. Llama a tu función original para que cambie la imagen como siempre
        if (typeof cambiarImagen === 'function') {
            cambiarImagen(ruta, nombre);
        }

        // 2. Guarda el ID de la temática
        temaSeleccionadoId = id;

        // 3. (Opcional) Mostrar el contenedor de niveles si estaba oculto
        const divNiveles = document.getElementById('seccionNiveles');
        if (divNiveles) divNiveles.style.display = 'block';
    }

    function irAlQuiz(nivel) {
        if (!temaSeleccionadoId) {
            alert("Selecciona un tema primero");
            return;
        }
        // Redirige a la URL que tu JS original sabe leer
        window.location.href = `/pregunta-texto?tematica=${temaSeleccionadoId}&pregunta=${nivel}`;
    }
            function initMap() {
                const modal = document.getElementById('mapModal');
                
                // Escuchamos el evento de Bootstrap cuando el modal termina de abrirse
                modal.addEventListener('shown.bs.modal', function () {
                    const position = { lat: 39.46846981708395, lng: -0.38866599592922074 }; 

                    // Si el mapa ya existe, no lo recreamos, solo lo centramos
                    if (!map) {
                        map = new google.maps.Map(document.getElementById("map"), {
                            zoom: 16,
                            center: position,
                            mapTypeId: 'hybrid'
                    });

                    new google.maps.Marker({
                        position: position,
                        map: map,
                    });
                    } else {
                    // Re-centrar el mapa por si acaso
                        google.maps.event.trigger(map, "resize");
                        map.setCenter(position);
                    }
                });
            }
        </script>
        @if(session('error'))
        <script>
            // Esto capturará el mensaje "No tienes vidas suficientes" 
            // que enviamos desde el controlador
            alert("{{ session('error') }}");
        </script>
        @endif
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCIwM93aStjLTqInGUdQriLgLoIiV-hM4g&callback=initMap" async defer></script>
        <script src="{{ asset('js/autotranslate.js') }}"></script>
        <div id="gt" style="display:none"></div>
    </body>
</html>

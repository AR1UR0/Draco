<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Draco - Aprende sobre tus temas favoritos</title>
  <link rel="shortcut icon" href="{{ asset('media/imgs/icoDraco.png') }}" type="image/x-icon" />
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/main.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/pagPrincipal/pagPrincipal.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/store.css') }}">
</head>

<body>
  <div class="container-fluid">
    <div class="container-fluid p-0 g-0 ps-4 d-flex flex-column flex-md-row">
      <!-- CONTENEDOR PRINCIPAL -->
      <nav
        class="d-none d-md-flex flex-grow-0 pt-3 d-flex flex-column border-end border-1 border-light navPrin pe-4 ps-1 align-items-end">
        <!-- NAVEGACIÓN -->
        <a href="{{ route('index') }}">
          <img src="{{ asset('media/imgs/pagPrincipal/logoLetras.png') }}" alt="DRACO" class="logoDraco mb-5" />
        </a>
        <a href="{{ route('pagPrincipal') }}" class="mb-4 me-3 enlPrin">Aprender</a>
        <a href="{{ route('store') }}" class="mb-4 me-3 enlPrin">Tienda</a>
            @if(Auth::user()->role_id==1)
            <a href="{{ route('admin') }}" class="mb-4 me-3 enlPrin">Admin</a>
            @else
            <a href="{{ route('perfil') }}" class="mb-4 me-3 enlPrin">Perfil</a>
            @endif
        


      </nav>
  <!-- MENU HAMBURGUESA -->
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
              <a href="{{ route('store') }}" class="d-block py-3 enlPrinWider">Tienda</a>
                  @if(Auth::user()->role_id==1)
                  <a href="{{ route('admin') }}" class="d-block py-3 enlPrinWider">Admin</a>
                  @else
                  <a href="{{ route('perfil') }}" class="d-block py-3 enlPrinWider">Perfil</a>
                  @endif
          </div>
      </div>
      <hr
          class="border border-light mb-4 mt-2 d-block d-md-none"
      />

      <!-- MAIN -->
      <main class="flex-grow-1 d-flex flex-column align-items-center py-4">
        <div class="dracoPlus2 dracoPlusGlow2 d-flex flex-column align-items-center justify-content-center mx-5 mb-5">
          <div class="content p-3">
            <h2 class="fw-bold">Consigue vidas ilimitadas y muchas otras ventajas con Draco Plus</h2>
            <p>Con un descuento incluido en el plan de 12 meses.</p>
            <button class="btn btnPlus">OBTÉN UN 60% DE DESCUENTO</button>
          </div>
        </div>

        <div class="panelVidas w-100 px-5">
          <h5 class="fw-bold mb-3 text-uppercase">Vidas</h5>

          <div class="vidaItem d-flex align-items-center justify-content-between p-3">
            <div class="d-flex align-items-center">
              <img src="{{ asset('media/imgs/iconos/heart.png') }}" alt="Vidas" class="me-3 iconVida">
              <div>
                <h6 class="mb-0 fw-bold titleItem">Recupera tus vidas</h6>
                <small class="text-muted">Recarga todas tus vidas y aumenta las posibilidades de terminar una
                  lección.</small>
              </div>
            </div>
            <button class="btn btnVida btn-outline-dark text-uppercase">Recargar</button>
          </div>

          <div class="vidaItem d-flex align-items-center justify-content-between p-3">
            <div class="d-flex align-items-center">
              <img src="{{ asset('media/imgs/iconos/heartBlue.png') }}" alt="Vidas" class="me-3 iconVida">
              <div>
                <h6 class="mb-0 fw-bold titleItem">Obtén vidas ilimitadas</h6>
                <small class="text-muted">Consigue vidas ilimitadas para poder disfrutar y probar sin límites.</small>
              </div>
            </div>
            <button class="btn btnVida btn-outline-dark text-uppercase">Obtener Super</button>
          </div>
        </div>

        <div class="panelVidas w-100 px-5 mt-4">
          <h5 class="fw-bold mb-3 text-uppercase">Cosméticos</h5>
          <div class="d-flex align-items-center justify-content-between slider-cos">
            <button class="btn arrow-btn">&lt;</button>
            <span class="cos-item">COS1</span>
            <span class="cos-item">COS2</span>
            <span class="cos-item">COS3</span>
            <span class="cos-item">COS4</span>
            <button class="btn arrow-btn">&gt;</button>
          </div>
        </div>
      </main>
      <aside class="flex-grow-0 pt-3 ps-3 border-start border-1 border-light asidePrin d-flex flex-column">
        <!-- PANEL LATERAL -->
        <div class="d-flex flex-grow-0 parteArriba justify-content-evenly align-items-center mb-3">
          <!-- IMAGENES DE TEMA, RACHA, DINERO Y VIDAS -->
          <div>
            <img src="{{ asset('media/imgs/temas/berserk.jpg') }}" alt=" " class="border border-light imgTema" />
          </div>
          <div class="d-flex align-items-center justify-content-center">
            <img src="{{ asset('media/imgs/iconos/burn.png') }}" alt="Racha:" class="imgIco" />
            <span class="racha">&nbsp;{{ Auth::check() ? (Auth::user()->streak ?? 0) : 0 }}</span>
          </div>
          <div class="d-flex align-items-center justify-content-center">
            <img src="{{ asset('media/imgs/iconos/coin.png') }}" alt="Dinero:" class="imgIco" />
            <span>7000</span>
          </div>
          <div class="d-flex align-items-center justify-content-center">
            <img src="{{ asset('media/imgs/iconos/heart.png') }}" alt="Vida:" class="imgIco" />
            <span class="racha">&nbsp;{{ Auth::check() ? Auth::user()->current_lives : 5 }}</span>
          </div>
        </div>
        <!-- DIV PARA DRACO PLUS Y ANUNCIO -->
        <div class="flex-grow-1 d-flex flex-column justify-content-between">
          <!-- DRACO PLUS -->
          <div class="dracoPlus dracoPlusGlow flex-grow-1 align-items-center justify-content-center d-flex flex-column">
            <div class="content">
              <h2>Draco Plus</h2>
              <p>¡Desbloquea contenido exclusivo y racha infinita!</p>
              <button class="btn btnPlus px-4 py-2 mt-2" data-bs-toggle="modal" data-bs-target="#modalPago">
              PRUEBA PLUS GRATIS
              </button>
            </div>
          </div>
          <!-- ANUNCIO -->
          <div class="panelAnuncio flex-grow-1">
            <h2>Anuncio Interesante</h2>
            <p>Mira que anuncio más chulo y más interesante mola mucho.</p>
            <button>ANUNCIO AQUÍ SISISI</button>
          </div>
        </div>

        <footer class="flex-grow-0 mt-3 container text-center">
          <!-- FOOTER LATERAL -->
          <div class="row">
            <div class="col-4 col4">Contactos</div>
            <div class="col-8">
              <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Términos de Privacidad</a>
            </div>
          </div>
          <div class="row">
            <div class="col">Sobre Nosotros</div>
            <div class="col">
              <a href="#" id="liveToastBtn">Copyright</a>
            </div>
            <div class="col">Dirección</div>
          </div>
          <div class="container mt-4 mb-4 justify-content-evenly align-items-center d-flex">
            <img src="{{ asset('media/imgs/iconos/instagram.png') }}" alt="Instagram" class="imgFooterPrin" />
            <img src="{{ asset('media/imgs/iconos/twitter.png') }}" alt="Twitter" class="imgFooterPrin" />
            <img src="{{ asset('media/imgs/iconos/facebook.png') }}" alt="Facebook" class="imgFooterPrin" />
          </div>
        </footer>
      </aside>
    </div>
  </div>

  <!-- TOAST COPYRIGHT -->
  <div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header d-flex justify-content-between align-items-center">
        <img src="{{ asset('media/imgs/icoDraco.png') }}" class="rounded me-2" alt="..." style="width: 25px" />
        <div class="d-flex justify-content-center align-items-center">
          <small>Draco &copy;</small>
          <button type="button" class="btn-close me-2" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>
      <div class="toast-body">
        Copyright &copy; 2025-2026 Draco Enterprises. All rights reserved.
      </div>
    </div>
  </div>

  <!-- MODAL DE TÉRMINOS Y CONDICIONES -->
  <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="termsModalLabel">
            Términos y Condiciones – Plataforma DRACO
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <p>
            <strong>1. Introducción</strong><br />
            Bienvenido a <strong>DRACO</strong>, una plataforma web para
            aprender sobre universos de fantasía y videojuegos como The Lord
            of the Rings, GloryHammer, World of Warcraft y Minecraft. Al usar
            nuestra página aceptas estos términos.
          </p>

          <p>
            <strong>2. Uso de la Plataforma</strong><br />
            DRACO está destinada al aprendizaje autodidacta y entretenimiento
            educativo. Puede usarse desde cualquier dispositivo con navegador,
            y debe utilizarse de manera respetuosa y ética.
          </p>

          <p>
            <strong>3. Contenido</strong><br />
            Todo el contenido es solo con fines educativos y de
            entretenimiento. No se permite reproducir, distribuir ni modificar
            el contenido sin autorización.
          </p>

          <p>
            <strong>4. Registro y Seguridad</strong><br />
            Algunos servicios requieren registro. Eres responsable de mantener
            tu usuario y contraseña seguros y de notificar cualquier uso no
            autorizado.
          </p>

          <p>
            <strong>5. Privacidad</strong><br />
            Solo recopilamos los datos necesarios para el funcionamiento del
            sitio. Consulta nuestra política de privacidad para más detalles.
          </p>

          <p>
            <strong>6. Modificaciones</strong><br />
            DRACO puede actualizar estos términos en cualquier momento. Te
            recomendamos revisarlos periódicamente.
          </p>

          <p>
            <strong>7. Limitación de Responsabilidad</strong><br />
            DRACO no garantiza disponibilidad continua ni ausencia de errores
            y no se hace responsable de daños derivados del uso del sitio.
          </p>

          <p>
            <strong>8. Ley Aplicable</strong><br />
            Estos términos se rigen por la legislación española. Cualquier
            disputa se resolverá ante los tribunales competentes.
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            Cerrar
          </button>
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
  <script src="{{ asset('js/autotranslate.js') }}"></script>
  <div id="gt" style="display:none"></div>
</body>

</html>
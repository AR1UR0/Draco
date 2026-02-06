/**
 * @fileoverview JavaScript para el carrusel de imágenes en la página principal.
 * @author Arturo/Draco Team
 * @version 1.1.0
 */

/**
 * Inicializa el comportamiento del carrusel cuando la página está lista.

 */
document.addEventListener("DOMContentLoaded", () => {
    /**
     * Elemento contenedor (track) que agrupa los items del carrusel.
     * @type {HTMLElement|null}
     */
    const track = document.getElementById("carouselTrack");

    /**
     * Bandera para evitar reentradas: impide iniciar otra animación mientras
     * la actual no ha finalizado.
     * @type {boolean}
     */
    let isMoving = false;

    /**
     * Calcula el ancho en píxeles de un elemento del carrusel incluyendo
     * los márgenes izquierdo y derecho calculados por CSS.
     *
     * @returns {number} Ancho total del item en píxeles (offsetWidth + margen).
     */
    function getItemWidth() {
        if (!track || !track.children.length) return 0;

        const item = track.children[0];
        const style = getComputedStyle(item);
        const margin =
            parseFloat(style.marginLeft) + parseFloat(style.marginRight);

        return item.offsetWidth + margin;
    }

    /**
     * Mueve el carrusel una posición hacia la izquierda.
     *
     * El flujo es el siguiente:
     * 1. Si ya se está moviendo (`isMoving`), salir para evitar colisiones.
     * 2. Calcular el ancho del primer elemento.
     * 3. Aplicar una transición CSS para desplazar la pista hacia la izquierda
     *    el ancho del item.
     * 4. Tras finalizar la animación, deshabilitar la transición, mover el
     *    primer elemento al final de la pista y resetear la transform.
     *
     * Efectos secundarios: modifica el DOM (reordena hijos del `track`) y
     * estilos inline (`transition`, `transform`).
     *
     * @returns {void}
     */
    function moveCarousel() {
        if (!track) return;
        if (isMoving) return;
        isMoving = true;

        const itemWidth = getItemWidth();

        // Animar la pista para desplazar el primer item hacia la izquierda
        track.style.transition = "transform 0.5s ease";
        track.style.transform = `translateX(-${itemWidth}px)`;

        // Al terminar la animación, reordenamos los elementos y reseteamos
        setTimeout(() => {
            track.style.transition = "none";
            // Mover el primer hijo al final para crear efecto de bucle
            track.appendChild(track.firstElementChild);
            // Resetear la transformación para dejar la pista en su lugar
            track.style.transform = "translateX(0)";
            isMoving = false;
        }, 500);
    }

    // Iniciar el ciclo automático cada 3 segundos (3000 ms).
    setInterval(moveCarousel, 3000);
});

document.addEventListener("DOMContentLoaded", function () {
    var popoverTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="popover"]'),
    );

    popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl, {
            // ESTA ES LA CLAVE: El contenedor es el padre directo
            container: popoverTriggerEl.parentElement,
            trigger: "click",
        });
    });
});

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".popoverTema").forEach((el) => {
        const pop = new bootstrap.Popover(el, {
            content: "PRÓXIMAMENTE",
            placement: "top",
            trigger: "manual",
            animation: false,
        });

        el.addEventListener("click", () => {
            // Oculta cualquier otro popover abierto
            document.querySelectorAll(".popoverTema").forEach((other) => {
                if (other !== el) {
                    bootstrap.Popover.getInstance(other)?.hide();
                }
            });

            pop.show();

            // Se cierra solo tras 1 segundos
            setTimeout(() => pop.hide(), 1000);
        });
    });

    // Click fuera = cerrar todo
    document.addEventListener("click", (e) => {
        if (!e.target.closest(".popoverTema")) {
            document.querySelectorAll(".popoverTema").forEach((el) => {
                bootstrap.Popover.getInstance(el)?.hide();
            });
        }
    });
});

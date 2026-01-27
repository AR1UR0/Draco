/**
 * @fileoverview Gestión de la configuración inicial de usuario (Wizard).
 * Controla el giro de las tarjetas de temas, la navegación entre secciones (pasos)
 * y las redirecciones finales basadas en el nivel seleccionado.
 * * @author Marta/Draco Team
 * @version 1.0.0
 */

document.addEventListener("DOMContentLoaded", () => {

    /**
     * Maneja el efecto de giro (flip) de las tarjetas de temas.
     * Al hacer clic en una tarjeta, se alterna la clase 'flipped'.
     * @listens click
     */
    document.querySelectorAll(".topic-card").forEach((card) => {
        card.addEventListener("click", () => {
            card.classList.toggle("flipped");
        });
    });

    // --- ELEMENTOS DE NAVEGACIÓN ---
    
    /** @type {HTMLElement} Botón para avanzar del paso 1 al 2 */
    const btnToStep2 = document.getElementById("btn-continuar");
    
    /** @type {HTMLElement} Botón para avanzar del paso 2 al 3 */
    const btnToStep3 = document.getElementById("btn-to-step-3");
    
    /** @type {HTMLElement} Sección del Paso 1: Selección de temas */
    const paso1 = document.getElementById("step-1");
    
    /** @type {HTMLElement} Sección del Paso 2: Meta diaria */
    const paso2 = document.getElementById("step-2");
    
    /** @type {HTMLElement} Sección del Paso 3: Modo de inicio */
    const paso3 = document.getElementById("step-3");

    /**
     * Cambia la visibilidad del Paso 1 al Paso 2.
     * @listens click
     */
    if (btnToStep2) {
        btnToStep2.addEventListener("click", () => {
            paso1.classList.add("d-none");
            paso2.classList.remove("d-none");
            window.scrollTo(0, 0);
        });
    }

    /**
     * Cambia la visibilidad del Paso 2 al Paso 3.
     * @listens click
     */
    if (btnToStep3) {
        btnToStep3.addEventListener("click", () => {
            paso2.classList.add("d-none");
            paso3.classList.remove("d-none");
            window.scrollTo(0, 0);
        });
    }

    // --- SELECCIÓN DE NIVEL Y REDIRECCIONES ---

    /** @type {HTMLElement} Opción para empezar desde nivel principiante */
    const opcionPrincipio = document.getElementById("start-beginner");
    
    /** @type {HTMLElement} Opción para abrir el selector de niveles específicos */
    const opcionNivel = document.getElementById("start-placement");

    /**
     * Redirige al usuario al dashboard principal comenzando desde cero.
     * @listens click
     */
    if (opcionPrincipio) {
        opcionPrincipio.addEventListener("click", () => {
            // window.location.href = "dashboard.html"; 
        });
    }

    /**
     * Oculta el Paso 3 y muestra el selector de niveles (Paso 4).
     * @listens click
     */
    if (opcionNivel) {
        opcionNivel.addEventListener("click", () => {
            paso3.classList.add("d-none");
            const paso4 = document.getElementById("step-4");
            if (paso4) paso4.classList.remove("d-none");
            window.scrollTo(0, 0);
        });
    }

    // --- REDIRECCIÓN POR NIVELES ESPECÍFICOS ---

    const btnLvl1 = document.getElementById("lvl-1");
    const btnLvl2 = document.getElementById("lvl-2");
    const btnLvl3 = document.getElementById("lvl-3");

    /**
     * Redirige a la página del Nivel 1.
     * @listens click
     */
    if (btnLvl1) {
        btnLvl1.addEventListener("click", () => {
           // window.location.href = "nivel1.html";
        });
    }

    /**
     * Redirige a la página del Nivel 2.
     * @listens click
     */
    if (btnLvl2) {
        btnLvl2.addEventListener("click", () => {
            // window.location.href = "nivel2.html";
        });
    }

    /**
     * Redirige a la página del Nivel 3.
     * @listens click
     */
    if (btnLvl3) {
        btnLvl3.addEventListener("click", () => {
            // window.location.href = "nivel3.html";
        });
    }

    /**
     * Permite al usuario retroceder del Paso 4 al Paso 3.
     * @type {HTMLElement}
     * @listens click
     */
    const btnBackTo3 = document.getElementById("back-to-step-3");
    if (btnBackTo3) {
        btnBackTo3.addEventListener("click", (e) => {
            e.preventDefault();
            document.getElementById("step-4").classList.add("d-none");
            paso3.classList.remove("d-none");
        });
    }
});
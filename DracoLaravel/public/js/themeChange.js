/**
 * @fileoverview JavaScript para el cambio de tema en todas las páginas.
 * Proporciona utilidades para aplicar el tema claro/oscuro y actualizar
 * las clases y atributos necesarios en el DOM.
 *
 * Ahora con persistencia de tema mediante cookies.
 *
 * @author Arturo/Draco Team
 * @version 1.2.0
 */

/**
 * Control que alterna el tema (checkbox, switch, etc.). Puede ser `null`
 * si no existe el elemento en la página actual; comprobar antes de usar.
 * @type {HTMLInputElement|null}
 */
const toggle = document.getElementById("toggleTheme");

/**
 * Referencia al elemento raíz `<html>` para establecer el atributo
 * `data-bs-theme` utilizado por Bootstrap u otras utilidades.
 * @type {HTMLHtmlElement}
 */
const html = document.documentElement;

/**
 * Función para crear o actualizar cookies.
 * @param {string} name - Nombre de la cookie.
 * @param {string} value - Valor de la cookie.
 * @param {number} days - Días hasta que expire la cookie.
 */
function setCookie(name, value, days) {
    const d = new Date();
    d.setTime(d.getTime() + days * 24 * 60 * 60 * 1000);
    document.cookie = `${name}=${value};expires=${d.toUTCString()};path=/`;
}

/**
 * Función para leer cookies.
 * @param {string} name - Nombre de la cookie a leer.
 * @returns {string|null} Valor de la cookie o null si no existe.
 */
function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(";").shift();
    return null;
}

/**
 * Aplica el tema y actualiza las clases relevantes en el DOM.
 *
 * @param {boolean} isDark - Si true aplica el tema oscuro, si false el claro.
 * @returns {void}
 *
 * Efectos secundarios:
 * - Modifica `data-bs-theme` en `<html>`.
 * - Añade/quita clases en `document.body` y otros elementos para ajustar
 *   colores, bordes y textos según el tema.
 */
function applyTheme(isDark) {
    const theme = isDark ? "dark" : "light";
    html.setAttribute("data-bs-theme", theme);

    // CAMBIO DE CLASES EN EL BODY Y OTROS ELEMENTOS
    const body = document.body;
    const btnTerciary = document.querySelector(".btnTerciary");
    const imgCarr = document.querySelectorAll(".imgCarr");
    const navPrin = document.querySelector(".navPrin");
    const asidePrin = document.querySelector(".asidePrin");
    const imgTema = document.querySelector(".imgTema");
    const imgPerfil = document.querySelector(".imgPerfil");
    const hr = document.querySelectorAll("hr");
    const btnHamb = document.querySelector(".btnHamb");

    // APLICAR CLASES SEGUN EL TEMA
    if (isDark) {
        body.classList.add("bg-dark", "text-light");
        body.classList.remove("bg-light", "text-dark");

        if (btnTerciary) {
            btnTerciary.classList.add("btnTerciaryDark");
            btnTerciary.classList.remove("btnTerciaryLight");
        }

        if (navPrin) {
            navPrin.classList.add("border-light");
            navPrin.classList.remove("border-dark");
        }

        if (asidePrin) {
            asidePrin.classList.add("border-light");
            asidePrin.classList.remove("border-dark");
        }

        if (imgTema) {
            imgTema.classList.add("border-light");
            imgTema.classList.remove("border-dark");
        }

        if (imgPerfil) {
            imgPerfil.classList.add("border-light");
            imgPerfil.classList.remove("border-dark");
        }

        if (hr) {
            hr.forEach((line) => {
                line.classList.add("border-light");
                line.classList.remove("border-dark");
            });
        }

        if (btnHamb) {
            btnHamb.classList.add("text-light");
            btnHamb.classList.remove("text-dark");
        }

        imgCarr.forEach((img) => {
            img.classList.add("border-light");
            img.classList.remove("border-dark");
        });
    } else {
        body.classList.add("bg-light", "text-dark");
        body.classList.remove("bg-dark", "text-light");

        if (btnTerciary) {
            btnTerciary.classList.add("btnTerciaryLight");
            btnTerciary.classList.remove("btnTerciaryDark");
        }

        if (navPrin) {
            navPrin.classList.add("border-dark");
            navPrin.classList.remove("border-light");
        }

        if (asidePrin) {
            asidePrin.classList.add("border-dark");
            asidePrin.classList.remove("border-light");
        }

        if (imgTema) {
            imgTema.classList.add("border-dark");
            imgTema.classList.remove("border-light");
        }

        if (imgPerfil) {
            imgPerfil.classList.add("border-dark");
            imgPerfil.classList.remove("border-light");
        }

        if (hr) {
            hr.forEach((line) => {
                line.classList.add("border-dark");
                line.classList.remove("border-light");
            });
        }

        if (btnHamb) {
            btnHamb.classList.add("text-dark");
            btnHamb.classList.remove("text-light");
        }

        imgCarr.forEach((img) => {
            img.classList.add("border-dark");
            img.classList.remove("border-light");
        });
    }
}

/**
 * Inicialización del tema al cargar la página.
 * Se comprueba primero la cookie para aplicar el tema guardado.
 * Si no existe cookie, se usa el estado del toggle o tema por defecto.
 */
const savedTheme = getCookie("theme"); // <-- NUEVO: leer cookie 'theme'
if (savedTheme) {
    const isDark = savedTheme === "dark";
    applyTheme(isDark);

    // Sincronizar toggle si existe
    if (toggle) toggle.checked = isDark;
} else {
    // Si no hay cookie, usar toggle.checked o default light
    applyTheme(toggle ? toggle.checked : false);
}

/**
 * Listener para el toggle.
 * Aplica el tema y actualiza la cookie cada vez que el usuario cambia el toggle.
 */
if (toggle) {
    toggle.addEventListener("change", () => {
        applyTheme(toggle.checked);

        // <-- NUEVO: actualizar cookie cuando el toggle cambia
        setCookie("theme", toggle.checked ? "dark" : "light", 30); // 30 días
    });
}

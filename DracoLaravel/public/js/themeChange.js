/**
 * @fileoverview JavaScript for theme switching across all pages.
 * Provides utilities to apply light/dark theme and update
 * the necessary classes and attributes in the DOM.
 *
 * Now with theme persistence using cookies.
 *
 * @author Arturo/Draco Team
 * @version 1.2.0
 */

/**
 * Control that toggles the theme (checkbox, switch, etc.). Can be `null`
 * if the element doesn't exist on the current page; check before using.
 * @type {HTMLInputElement|null}
 */
const toggle = document.getElementById("toggleTheme");

/**
 * Reference to the root `<html>` element to set the
 * `data-bs-theme` attribute used by Bootstrap and other utilities.
 * @type {HTMLHtmlElement}
 */
const html = document.documentElement;

/**
 * Function to create or update cookies.
 * @param {string} name - Name of the cookie.
 * @param {string} value - Value of the cookie.
 * @param {number} days - Days until the cookie expires.
 */
function setCookie(name, value, days) {
    const d = new Date();
    d.setTime(d.getTime() + days * 24 * 60 * 60 * 1000);
    document.cookie = `${name}=${value};expires=${d.toUTCString()};path=/`;
}

/**
 * Function to read cookies.
 * @param {string} name - Name of the cookie to read.
 * @returns {string|null} Cookie value or null if it doesn't exist.
 */
function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(";").shift();
    return null;
}

/**
 * Applies the theme and updates relevant classes in the DOM.
 *
 * @param {boolean} isDark - If true applies dark theme, if false the light theme.
 * @returns {void}
 *
 * Side effects:
 * - Modifies `data-bs-theme` on `<html>`.
 * - Adds/removes classes on `document.body` and other elements to adjust
 *   colors, borders and text according to the theme.
 */
function applyTheme(isDark) {
    const theme = isDark ? "dark" : "light";
    html.setAttribute("data-bs-theme", theme);

    // Change classes on body and other elements
    const body = document.body;
    const btnTerciary = document.querySelector(".btnTerciary");
    const imgCarr = document.querySelectorAll(".imgCarr");
    const navPrin = document.querySelector(".navPrin");
    const asidePrin = document.querySelector(".asidePrin");
    const imgTema = document.querySelector(".imgTema");
    const imgPerfil = document.querySelector(".imgPerfil");
    const hr = document.querySelectorAll("hr");
    const btnHamb = document.querySelector(".btnHamb");

    // Apply classes according to the theme
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
 * Theme initialization when the page loads.
 * Checks the cookie first to apply the saved theme.
 * If no cookie exists, uses the toggle state or default light theme.
 */
const savedTheme = getCookie("theme"); // Read the 'theme' cookie
if (savedTheme) {
    const isDark = savedTheme === "dark";
    applyTheme(isDark);

    // Synchronize toggle if it exists
    if (toggle) toggle.checked = isDark;
} else {
    // If no cookie exists, use toggle.checked or default light theme
    applyTheme(toggle ? toggle.checked : false);
}

/**
 * Event listener for the toggle.
 * Applies the theme and updates the cookie each time the user changes the toggle.
 */
if (toggle) {
    toggle.addEventListener("change", () => {
        applyTheme(toggle.checked);

        // Update cookie when the toggle changes
        setCookie("theme", toggle.checked ? "dark" : "light", 30); // 30 days
    });
}

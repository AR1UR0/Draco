// CONSTANTES DEL TOGGLE Y EL DOCUMENTO
const toggle = document.getElementById("toggleTheme");
const html = document.documentElement;

// FUNCION PARA APLICAR EL TEMA
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

// INICIALIZAR EL TEMA SEGUN EL TOGGLE
if (toggle) {
    applyTheme(toggle.checked);
    toggle.addEventListener("change", () => applyTheme(toggle.checked));
}

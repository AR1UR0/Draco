const toggle = document.getElementById("toggleTheme");
const html = document.documentElement;

function applyTheme(isDark) {
    const theme = isDark ? "dark" : "light";
    html.setAttribute("data-bs-theme", theme);

    // Gestión de clases especificas
    const body = document.body;
    const btnTerciary = document.querySelector(".btnTerciary");

    if (isDark) {
        body.classList.add("bg-dark", "text-light");
        body.classList.remove("bg-light", "text-dark");
        if (btnTerciary) {
            btnTerciary.classList.add("btnTerciaryDark");
            btnTerciary.classList.remove("btnTerciaryLight");
        }
    } else {
        body.classList.add("bg-light", "text-dark");
        body.classList.remove("bg-dark", "text-light");
        if (btnTerciary) {
            btnTerciary.classList.add("btnTerciaryLight");
            btnTerciary.classList.remove("btnTerciaryDark");
        }
    }
}

if (toggle) {
    applyTheme(toggle.checked);
    toggle.addEventListener("change", () => applyTheme(toggle.checked));
}

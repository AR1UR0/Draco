/**
 * @fileoverview Script para mostrar un toast de Bootstrap al hacer
 * clic en un botón. Proporciona una inicialización segura que no produce
 * errores si los elementos no existen en la página.
 * @author Arturo/Draco Team
 * @version 1.1.0
 */

/**
 * Elemento disparador del toast (por ejemplo, un botón). Puede ser `null`
 * si no existe en la página actual.
 * @type {HTMLElement|null}
 */
const toastTrigger = document.getElementById("liveToastBtn");

/**
 * Contenedor o plantilla del toast que utiliza Bootstrap.
 * @type {HTMLElement|null}
 */
const toastLiveExample = document.getElementById("liveToast");

/**
 * Inicializa el toast y añade el listener al botón disparador.
 *
 * Si `toastTrigger` no existe, la inicialización se omite para evitar
 * errores en páginas que no usan este componente.
 */
if (toastTrigger) {
    // Obtener o crear la instancia de Bootstrap Toast asociada al elemento
    // `toastLiveExample`. Bootstrap gestionará la instancia internamente.
    const toastBootstrap =
        bootstrap.Toast.getOrCreateInstance(toastLiveExample);

    // Mostrar el toast cuando el usuario haga clic en el disparador.
    toastTrigger.addEventListener("click", () => {
        toastBootstrap.show();
    });
}

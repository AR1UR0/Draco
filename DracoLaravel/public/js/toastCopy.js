/**
 * @fileoverview Script to show a Bootstrap toast when clicking
 * a button. Provides safe initialization that doesn't produce
 * errors if elements don't exist on the page.
 * @author Arturo/Draco Team
 * @version 1.1.0
 */

/**
 * Toast trigger element (for example, a button). Can be `null`
 * if it doesn't exist on the current page.
 * @type {HTMLElement|null}
 */
const toastTrigger = document.getElementById("liveToastBtn");

/**
 * Container or template of the toast that uses Bootstrap.
 * @type {HTMLElement|null}
 */
const toastLiveExample = document.getElementById("liveToast");

/**
 * Initializes the toast and adds the event listener to the trigger button.
 *
 * If `toastTrigger` doesn't exist, initialization is skipped to avoid
 * errors on pages that don't use this component.
 */
if (toastTrigger) {
    // Get or create the Bootstrap Toast instance associated with the
    // `toastLiveExample` element. Bootstrap will manage the instance internally.
    const toastBootstrap =
        bootstrap.Toast.getOrCreateInstance(toastLiveExample);

    // Show the toast when the user clicks the trigger button.
    toastTrigger.addEventListener("click", () => {
        toastBootstrap.show();
    });
}

/**
* @fileoverview User initial configuration management (Wizard).
* Controls the one-time theme selection, navigation between steps
* and stores the user's final choice for future reference.
* @author Marta
* @version 1.2.0
*/

document.addEventListener("DOMContentLoaded", () => {
    /** * "Flipped" card logic:
    * Exclusive selection system. Clicking on a
    theme (Gloryhammer, LOTR, etc.) rotates the card 180 degrees using CSS.
    * The script ensures that only one card can be selected at a time.
    */
    let temaSeleccionado = null;
    const cards = document.querySelectorAll(".topic-card");

    cards.forEach((card) => {
        card.addEventListener("click", () => {
            // If the card is already turned, we uncheck it and reset the selection
            if (card.classList.contains("flipped")) {
                card.classList.remove("flipped");
                temaSeleccionado = null;
            } else {
                // We close any other open cards
                cards.forEach((c) => c.classList.remove("flipped"));

                // We turn the current card over.
                card.classList.add("flipped");

                // WE SAVE THE CHOICE: We extract the text from the 'topic-front'
                temaSeleccionado = card
                    .querySelector(".topic-front")
                    .innerText.trim();
                console.log("Tema elegido actualmente:", temaSeleccionado);
            }
        });
    });

    /**
    * Navigation between steps:
    * The system uses Bootstrap classes ('d-none') to toggle the visibility
    of the sections. This ensures a smooth and fast transition.
    * Step 1: Theme Selection.
    * Step 2: Daily Goal Selection.
    * Step 3: Level Decision (Choice from the beginning or level selection).
    * Step 4: Specific level selector (Functionality coming soon).
    */

    /** @type {HTMLElement} Button to advance from step 1 to step 2 */
    const btnToStep2 = document.getElementById("btn-continuar");

    /** @type {HTMLElement} Button to advance from step 2 to step 3 */
    const btnToStep3 = document.getElementById("btn-to-step-3");

    /** @type {HTMLElement} Step 1 Section: Topic Selection */
    const paso1 = document.getElementById("step-1");

    /** @type {HTMLElement} Step 2 Section: Daily Goal Selection */
    const paso2 = document.getElementById("step-2");

    /** @type {HTMLElement} Step 3 Section: Start Mode Selection */
    const paso3 = document.getElementById("step-3");

    /**
    * Changes the visibility from Step 1 to Step 2.
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
    * Changes the visibility of Step 2 to Step 3.
    * @listens click
    */
    if (btnToStep3) {
        btnToStep3.addEventListener("click", () => {
            paso2.classList.add("d-none");
            paso3.classList.remove("d-none");
            window.scrollTo(0, 0);
        });
    }

    // --- LEVEL SELECTION AND REDIRECTIONS ---

    /** @type {HTMLElement} Option to start from beginner level */
    const opcionPrincipio = document.getElementById("start-beginner");

    /** @type {HTMLElement} Option to open the specific levels selector */
    const opcionNivel = document.getElementById("start-placement");

    /**
    * Redirects the user to the main dashboard, starting from scratch.
    * @listens click
    */
    if (opcionPrincipio) {
        opcionPrincipio.addEventListener("click", () => {
            // window.location.href = "dashboard.html";
        });
    }

    /**
     * Hides Step 3 and shows the specific levels selector (Step 4).
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

// --- REDIRECT BY SPECIFIC LEVELS ---
    const btnLvl1 = document.getElementById("lvl-1");
    const btnLvl2 = document.getElementById("lvl-2");
    const btnLvl3 = document.getElementById("lvl-3");

    //This was set up for future implementations, but for now, it redirects to the general dashboard regardless of the selected level.
    //This was done to simplify the initial experience and avoid confusion, as the specific levels are not yet implemented.
    //In the future, each button will be able to redirect to a custom section of the dashboard depending on the selected level.

    /**
    * Redirects to the Level 1 page.
    * @listens click
    */
    if (btnLvl1) {
        btnLvl1.addEventListener("click", () => {
            // window.location.href = "nivel1.html";
        });
    }

    /**
    * Redirects to the Level 2 page.
    * @listens click
    */
    if (btnLvl2) {
        btnLvl2.addEventListener("click", () => {
            // window.location.href = "nivel2.html";
        });
    }

    /**
    * Redirects to the Level 3 page.
    * @listens click
    */
    if (btnLvl3) {
        btnLvl3.addEventListener("click", () => {
            // window.location.href = "nivel3.html";
        });
    }

    /**
    * Allows the user to go back from Step 4 to Step 3.
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

const empezar = document.querySelector("#start-beginner");

empezar.addEventListener("click", () => {
    window.location.href = "/pagPrincipal";
});

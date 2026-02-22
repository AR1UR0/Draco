/**
 * @fileoverview JavaScript for the modal handler that displays information about different themes (Berserk, GloryHammer, LOTR).
 * @author Arturo/Draco Team
 * @version 1.0.0
 */

/**
 * Initializes the theme modal behavior when the page is ready.
 */
document.addEventListener("DOMContentLoaded", function () {
    /**
     * Modal element that displays theme information.
     * @type {HTMLElement|null}
     */
    const modal = document.getElementById("modalTemas");

    /**
     * Button or trigger element for the Berserk theme.
     * @type {HTMLElement|null}
     */
    const temaBerserk = document.getElementById("temaBerserk");

    /**
     * Button or trigger element for the GloryHammer theme.
     * @type {HTMLElement|null}
     */
    const temaGlory = document.getElementById("temaGlory");

    /**
     * Button or trigger element for the Lord of the Rings theme.
     * @type {HTMLElement|null}
     */
    const temaLOTR = document.getElementById("temaLOTR");

    /**
     * Updates the modal content based on the selected theme name.
     *
     * The flow is as follows:
     * 1. Get the modal title and body elements.
     * 2. Based on the theme name, populate the title and body with
     *    appropriate content (genre, synopsis, author, publication year).
     * 3. If the theme name doesn't match any known theme, display a
     *    "theme not found" message.
     *
     * Side effects: modifies the DOM (updates modal-title text and
     * modal-body innerHTML).
     *
     * @param {string} temaNombre - The name of the theme ("berserk", "glory", "lotr").
     * @returns {void}
     */
    function actualizarModal(temaNombre) {
        const titulo = modal.querySelector(".modal-title");
        const cuerpo = modal.querySelector(".modal-body");

        // Switch statement to handle different theme selections
        switch (temaNombre) {
            // Berserk manga/anime theme content
            case "berserk":
                titulo.textContent = "Berserk";
                cuerpo.innerHTML = `
                    <p><strong>Género:</strong> Acción, Aventura, Fantasía oscura</p>
                    <p><strong>Sinopsis:</strong>
                        En un mundo brutal dominado por la guerra y los demonios, Guts es un mercenario
                        marcado por un destino cruel. Armado con una enorme espada y una voluntad inquebrantable,
                        lucha contra fuerzas sobrenaturales mientras busca venganza y sentido a su existencia.
                        Berserk es una historia oscura sobre supervivencia, traición, amistad y el precio del poder.
                    </p>
                    <p><strong>Autor:</strong> Kentaro Miura</p>
                    <p><strong>Año de publicación:</strong> 1989 - 2021</p>
                `;
                break;
            // GloryHammer power metal band theme content
            case "glory":
                titulo.textContent = "GloryHammer";
                cuerpo.innerHTML = `
                    <p><strong>Género:</strong> Power Metal, Fantasy Metal</p>
                    <p><strong>Descripción:</strong>
                        Gloryhammer narra una saga musical de fantasía exagerada donde héroes legendarios luchan contra
                        el mal absoluto a través del tiempo y el espacio. El príncipe Angus McFife empuña el martillo
                        sagrado Gloryhammer para enfrentarse al hechicero oscuro Zargothrax en batallas cósmicas llenas
                        de dragones, magia, reinos perdidos y láseres intergalácticos. Una historia tan absurda como
                        gloriosamente épica.
                    </p>
                    <p><strong>Integrantes:</strong> Thomas Winkler, James Cartwright, Ben Turk, Paul Templing</p>
                    <p><strong>Año de formación:</strong> 2010</p>
                `;
                break;
            // Lord of the Rings fantasy epic theme content
            case "lotr":
                titulo.textContent = "El Señor de los Anillos";
                cuerpo.innerHTML = `
                    <p><strong>Género:</strong> Fantasía épica</p>
                    <p><strong>Sinopsis:</strong>
                        En la Tierra Media, el joven hobbit Frodo Bolsón recibe la peligrosa misión de destruir el
                        Anillo Único, un artefacto capaz de someter al mundo entero. Acompañado por un grupo de héroes
                        de distintas razas, deberá atravesar tierras llenas de peligros mientras el Señor Oscuro Sauron
                        extiende su sombra. Una épica aventura sobre amistad, sacrificio y esperanza.
                    </p>
                    <p><strong>Autor:</strong> J.R.R. Tolkien</p>
                    <p><strong>Año de publicación:</strong> 1954 - 1955</p>
                `;
                break;
            // Default case for unknown theme names
            default:
                titulo.textContent = "Tema no encontrado";
                cuerpo.innerHTML = `<p>No se ha encontrado información.</p>`;
                break;
        }
    }

    /**
     * Attaches click event listener to the Berserk theme trigger element.
     * Updates modal with Berserk theme information when clicked.
     */
    if (temaBerserk) {
        temaBerserk.addEventListener("click", function (e) {
            e.preventDefault(); // Prevents default href="#" behavior and parsing errors
            actualizarModal("berserk");
        });
    }

    /**
     * Attaches click event listener to the GloryHammer theme trigger element.
     * Updates modal with GloryHammer theme information when clicked.
     */
    if (temaGlory) {
        temaGlory.addEventListener("click", function (e) {
            e.preventDefault();
            actualizarModal("glory");
        });
    }

    /**
     * Attaches click event listener to the Lord of the Rings theme trigger element.
     * Updates modal with Lord of the Rings theme information when clicked.
     */
    if (temaLOTR) {
        temaLOTR.addEventListener("click", function (e) {
            e.preventDefault();
            actualizarModal("lotr");
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("modalTemas");
    const temaBerserk = document.getElementById("temaBerserk");
    const temaGlory = document.getElementById("temaGlory");
    const temaLOTR = document.getElementById("temaLOTR");

    function actualizarModal(temaNombre) {
        const titulo = modal.querySelector(".modal-title");
        const cuerpo = modal.querySelector(".modal-body");

        switch (temaNombre) {
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
            default:
                titulo.textContent = "Tema no encontrado";
                cuerpo.innerHTML = `<p>No se ha encontrado información.</p>`;
                break;
        }
    }

    if (temaBerserk) {
        temaBerserk.addEventListener("click", function (e) {
            e.preventDefault(); // Evita el salto del href="#" y errores de parsing
            actualizarModal("berserk");
        });
    }
    if (temaGlory) {
        temaGlory.addEventListener("click", function (e) {
            e.preventDefault();
            actualizarModal("glory");
        });
    }
    if (temaLOTR) {
        temaLOTR.addEventListener("click", function (e) {
            e.preventDefault();
            actualizarModal("lotr");
        });
    }
});

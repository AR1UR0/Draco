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
                    <p><strong>Sinopsis:</strong> La historia sigue a Guts, un mercenario solitario...</p>
                    <p><strong>Autor:</strong> Kentaro Miura</p>
                    <p><strong>Año de publicación:</strong> 1989 - 2021</p>
                `;
                break;
            case "glory":
                titulo.textContent = "GloryHammer";
                cuerpo.innerHTML = `
                    <p><strong>Género:</strong> Power Metal, Fantasy Metal</p>
                    <p><strong>Descripción:</strong> GloryHammer es una banda de power metal escocesa...</p>
                    <p><strong>Integrantes:</strong> Thomas Winkler, James Cartwright, Ben Turk, Paul Templing</p>
                    <p><strong>Año de formación:</strong> 2010</p>
                `;
                break;
            case "lotr":
                titulo.textContent = "El Señor de los Anillos";
                cuerpo.innerHTML = `
                    <p><strong>Género:</strong> Fantasía épica</p>
                    <p><strong>Sinopsis:</strong> La historia sigue a Frodo Bolsón y sus amigos en su misión para destruir el Anillo Único...</p>
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

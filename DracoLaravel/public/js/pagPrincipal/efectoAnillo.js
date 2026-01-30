/**
 * @fileoverview Animación de efecto para los botones en la página principal.
 * @author Arturo/Draco Team
 * @version 1.1.0
 */

/**
 * Inicializa los manejadores de evento para los nodos de nivel.
 *
 * Busca todos los elementos con la clase `.level-node` y les asigna un
 * listener de `click`. Al hacer click en un nodo se desactiva la clase
 * `active` de todas las imágenes con clase `.ring-img` y se activa la
 * correspondiente al nodo pulsado.
 */
document.querySelectorAll(".level-node").forEach((node) => {
    /**
     * Manejador de click para un `level-node`.
     *
     * Efectos:
     * - Elimina la clase `active` de todas las imágenes `.ring-img`.
     * - Añade la clase `active` a la `.ring-img` del nodo clicado.
     * - Escribe en consola el texto "Nivel seleccionado" para depuración.
     *
     * @returns {void}
     */
    node.addEventListener("click", () => {
        document
            .querySelectorAll(".ring-img")
            .forEach((r) => r.classList.remove("active"));

        node.querySelector(".ring-img").classList.add("active");

        console.log("Nivel seleccionado");
    });
});

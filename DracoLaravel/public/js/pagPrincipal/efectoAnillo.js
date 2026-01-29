document.querySelectorAll(".level-node").forEach((node) => {
    node.addEventListener("click", () => {
        document
            .querySelectorAll(".ring-img")
            .forEach((r) => r.classList.remove("active"));

        node.querySelector(".ring-img").classList.add("active");

        console.log("Nivel seleccionado");
    });
});

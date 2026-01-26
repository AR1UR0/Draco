/**
 * @fileoverview Gestión de actividad de las tarjetas de temas.
 * Este script permite que las tarjetas giren al hacer clic, además del efecto hover de CSS.
 */

/**
 * Selecciona todas las tarjetas de temas y añade un escuchador de eventos 
 * para alternar la clase de giro al hacer clic.
 * * @listens click
 * @description Al hacer clic en una tarjeta con la clase '.topic-card', 
 * se añade o quita la clase '.flipped' para activar la animación de giro.
 */
document.querySelectorAll(".topic-card").forEach((card) => {
  card.addEventListener("click", () => {
    card.classList.toggle("flipped");
  });
});

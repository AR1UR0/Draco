/**
 * @fileoverview Lógica para el sistema de trivia con soporte de audio.
 * Gestiona la carga de preguntas, reproducción de pistas multimedia,
 * validación de respuestas y estados de finalización.
 * @author Thais/Draco Team
 * @version 1.2.0
 */

/**
 * Banco de datos de la trivia con soporte para rutas de audio.
 * @type {Array<{q: string, options: string[], correct: number, audio: string}>}
 */
const quizData = [
  {
    q: "¿A qué territorio pertenece esta canción?",
    options: ["Comarca", "Edoras", "Mordor", "Rivendel"],
    correct: 0,
    audio: "../media/Audio/The Shire.mp3",
  },
  // ... más preguntas
];

/** @type {number} Índice del paso actual */
let currentStep = 0;

/** @type {number|null} Índice de la opción seleccionada */
let selectedIdx = null;

// --- ELEMENTOS DEL DOM ---

/** @type {HTMLElement} Título o enunciado de la pregunta */
const pTexto = document.getElementById("preguntaTexto");

/** @type {HTMLElement} Contenedor de botones de opciones */
const oContenedor = document.getElementById("opcionesContenedor");

/** @type {HTMLElement} Botón de acción principal */
const btnPrincipal = document.getElementById("btnPrincipal");

/** @type {HTMLElement} Barra de progreso visual */
const progBar = document.getElementById("progressBar");

/** @type {HTMLAudioElement} Elemento de audio nativo */
const audio = document.getElementById("audioPregunta");

/** @type {HTMLElement} Botón para controlar la reproducción del audio */
const btnAudio = document.getElementById("btnAudio");

/**
 * Inicializa y carga los componentes de la pregunta actual.
 * Configura el audio, resetea la interfaz y actualiza el progreso.
 */
function loadQuiz() {
  const currentQuiz = quizData[currentStep];

  // Configuración de texto
  pTexto.innerText = currentQuiz.q;

  // Gestión de carga de audio
  if (currentQuiz.audio) {
    audio.src = currentQuiz.audio;
    audio.load();
  }

  // Reseteo de estados visuales y lógicos
  oContenedor.innerHTML = "";
  selectedIdx = null;
  btnPrincipal.innerText = "COMPROBAR";
  btnPrincipal.disabled = true;
  btnPrincipal.classList.remove("btn-next");

  // Cálculo y actualización de la barra de progreso
  const percent = (currentStep / quizData.length) * 100 + 10;
  progBar.style.width = percent + "%";

  // Generación dinámica de botones de respuesta
  currentQuiz.options.forEach((opt, i) => {
    const button = document.createElement("button");
    button.className = "option-btn";
    button.innerText = opt;
    button.onclick = () => selectOption(i, button);
    oContenedor.appendChild(button);
  });
}

/**
 * Marca una opción como seleccionada y habilita el botón de comprobación.
 * @param {number} idx - Índice de la opción.
 * @param {HTMLElement} el - Botón presionado.
 */
function selectOption(idx, el) {
  document
    .querySelectorAll(".option-btn")
    .forEach((b) => b.classList.remove("active"));

  el.classList.add("active");
  selectedIdx = idx;
  btnPrincipal.disabled = false;
}

/**
 * Controlador principal de interacción.
 * Maneja la lógica de validación, detención de audio y transición de pasos.
 * @listens click
 */
btnPrincipal.onclick = () => {
  if (btnPrincipal.innerText === "COMPROBAR") {
    const data = quizData[currentStep];
    const botones = document.querySelectorAll(".option-btn");

    // Detener reproducción multimedia al validar
    audio.pause();
    audio.currentTime = 0;

    if (selectedIdx === data.correct) {
      botones[selectedIdx].classList.add("is-correct");
    } else {
      botones[selectedIdx].classList.add("is-wrong");
      botones[data.correct].classList.add("is-correct");
    }

    // Deshabilitar interacción tras la respuesta
    botones.forEach((btn) => (btn.style.pointerEvents = "none"));

    btnPrincipal.innerText = "CONTINUAR";
    btnPrincipal.classList.add("btn-next");
  } else if (btnPrincipal.innerText === "CONTINUAR") {
    currentStep++;
    if (currentStep < quizData.length) {
      loadQuiz();
    } else {
      finishQuiz();
    }
  } else {
    location.reload();
  }
};

/**
 * Evento para alternar la reproducción del audio de la pregunta.
 * @listens click
 */
btnAudio.addEventListener("click", () => {
  if (audio.paused) {
    audio.play();
  } else {
    audio.pause();
  }
});

/**
 * Muestra la pantalla de éxito final y actualiza el progreso al máximo.
 */
function finishQuiz() {
  progBar.style.width = "100%";
  pTexto.innerText = "¡Nivel Completado!";

  oContenedor.innerHTML = `
    <div class="text-center">
      <img
        src="https://cdn-icons-png.flaticon.com/512/190/190411.png"
        width="100"
        alt="Completado"
      />
    </div>
  `;

  btnPrincipal.innerText = "FINALIZAR";
  btnPrincipal.classList.remove("btn-next");
}

// Inicialización de la aplicación
loadQuiz();
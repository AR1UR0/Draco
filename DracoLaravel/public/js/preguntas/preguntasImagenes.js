/**
 * @fileoverview Lógica para el sistema de trivia basado en imágenes.
 * Gestiona la renderización de opciones visuales, validación de respuestas
 * y el flujo de navegación entre preguntas.
 * @author Thais/Draco Team
 * @version 1.1.0
 */

/**
 * Banco de datos de la trivia con rutas de imágenes.
 * @type {Array<{q: string, options: string[], correct: number}>}
 */
const quizData = [
  {
    q: "¿Señala quién es Frodo?",
    options: [
      "../media/imgs/personajes/frodo.jpeg",
      "../media/imgs/personajes/g.jpeg",
      "../media/imgs/personajes/s.jpeg",
    ],
    correct: 0,
  },
];

/** @type {number} Índice del progreso actual */
let currentStep = 0;

/** @type {number|null} Índice de la tarjeta seleccionada */
let selectedIdx = null;

// --- ELEMENTOS DEL DOM ---

/** @type {HTMLElement} Texto de la pregunta */
const pTexto = document.getElementById("preguntaTexto");

/** @type {HTMLElement} Contenedor de las tarjetas de opciones (imágenes) */
const oContenedor = document.getElementById("opcionesContenedor");

/** @type {HTMLElement} Botón de acción principal */
const btnPrincipal = document.getElementById("btnPrincipal");

/** @type {HTMLElement} Barra de progreso */
const progBar = document.getElementById("progressBar");

/**
 * Renderiza la pregunta actual y genera dinámicamente las tarjetas de imágenes.
 * Reinicia los estados de navegación y actualiza la barra de progreso.
 */
function loadQuiz() {
  const data = quizData[currentStep];
  pTexto.innerText = data.q;
  oContenedor.innerHTML = "";
  selectedIdx = null;

  btnPrincipal.innerText = "COMPROBAR";
  btnPrincipal.disabled = true;
  btnPrincipal.classList.remove("btn-next");

  // Actualización visual del progreso
  progBar.style.width = ((currentStep + 1) / quizData.length) * 100 + "%";

  data.options.forEach((imgUrl, i) => {
    const div = document.createElement("div");
    div.className = "option-card";
    div.innerHTML = `<img src="${imgUrl}" alt="opcion">`;
    
    /**
     * Maneja la selección de la tarjeta de imagen.
     * Solo permite selección si el estado actual es 'COMPROBAR'.
     */
    div.onclick = () => {
      if (btnPrincipal.innerText === "COMPROBAR") {
        document
          .querySelectorAll(".option-card")
          .forEach((c) => c.classList.remove("active"));
        div.classList.add("active");
        selectedIdx = i;
        btnPrincipal.disabled = false;
      }
    };
    oContenedor.appendChild(div);
  });
}

/**
 * Controlador de eventos para el botón principal.
 * Alterna entre la validación de la respuesta (feedback visual)
 * y el avance hacia la siguiente pregunta o reinicio.
 * @listens click
 */
btnPrincipal.onclick = () => {
  if (btnPrincipal.innerText === "COMPROBAR") {
    const cards = document.querySelectorAll(".option-card");
    const correctIdx = quizData[currentStep].correct;

    // Validación y feedback visual
    if (selectedIdx === correctIdx) {
      cards[selectedIdx].classList.add("is-correct");
    } else {
      cards[selectedIdx].classList.add("is-wrong");
      cards[correctIdx].classList.add("is-correct"); // Muestra la respuesta correcta
    }

    btnPrincipal.innerText = "CONTINUAR";
    btnPrincipal.classList.add("btn-next");
  } else {
    currentStep++;
    if (currentStep < quizData.length) {
      loadQuiz();
    } else {
      // Finalización del flujo (Uso de alerta informativa )
      alert("¡Trivia completada!");
      location.reload();
    }
  }
};

// Inicialización de la aplicación
loadQuiz();
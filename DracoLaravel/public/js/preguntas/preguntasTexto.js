/**
 * @fileoverview Lógica para el sistema de cuestionarios (Quiz).
 * Gestiona la carga de preguntas, validación de respuestas,
 * actualización de la barra de progreso y estados finales.
 * @author Thais/Draco Team
 * @version 1.0.0
 */

/**
 * Banco de preguntas y opciones del cuestionario.
 * @type {Array<{q: string, options: string[], correct: number}>}
 */
const quizData = [
  {
    q: "¿Quién es el portador del anillo único?",
    options: ["Gandalf", "Sauron", "Frodo", "Denethor"],
    correct: 2,
  },
  {
    q: "¿En qué lugar fue forjado el anillo?",
    options: ["Rivendel", "Monte del Destino", "La Comarca", "Isengard"],
    correct: 1,
  },
  {
    q: "¿Cuántos anillos recibieron los hombres?",
    options: ["Tres", "Siete", "Uno", "Nueve"],
    correct: 3,
  },
];

/** @type {number} Índice del paso o pregunta actual */
let currentStep = 0;

/** @type {number|null} Índice de la opción seleccionada por el usuario */
let selectedIdx = null;

// --- ELEMENTOS DEL INTERFAZ DE USUARIO ---

/** @type {HTMLElement} Elemento de texto de la pregunta */
const pTexto = document.getElementById("preguntaTexto");

/** @type {HTMLElement} Contenedor para los botones de opciones */
const oContenedor = document.getElementById("opcionesContenedor");

/** @type {HTMLElement} Botón de acción principal (Comprobar/Continuar/Finalizar) */
const btnPrincipal = document.getElementById("btnPrincipal");

/** @type {HTMLElement} Barra de progreso visual */
const progBar = document.getElementById("progressBar");

/**
 * Carga los datos de la pregunta actual y actualiza la interfaz.
 * Reinicia los estados de selección y ajusta la barra de progreso.
 */
function loadQuiz() {
  const currentQuiz = quizData[currentStep];
  pTexto.innerText = currentQuiz.q;
  oContenedor.innerHTML = "";
  selectedIdx = null;
  btnPrincipal.innerText = "COMPROBAR";
  btnPrincipal.disabled = true;

  // Actualizar barra
  const percent = (currentStep / quizData.length) * 100 + 10;
  progBar.style.width = percent + "%";

  currentQuiz.options.forEach((opt, i) => {
    const button = document.createElement("button");
    button.className = "option-btn";
    button.innerText = opt;
    button.onclick = () => selectOption(i, button);
    oContenedor.appendChild(button);
  });
}

/**
 * Gestiona la selección visual y lógica de una opción.
 * @param {number} idx - Índice de la opción elegida.
 * @param {HTMLElement} el - Elemento del DOM del botón pulsado.
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
 * Controlador de eventos para el botón principal.
 * Gestiona el flujo de validación, avance de nivel y reinicio.
 * @listens click
 */
btnPrincipal.onclick = () => {
  if (btnPrincipal.innerText === "COMPROBAR") {
    const data = quizData[currentStep];
    const botones = document.querySelectorAll(".option-btn");

    // Validar respuesta
    if (selectedIdx === data.correct) {
      // CORRECTO: Verde
      botones[selectedIdx].classList.add("is-correct");
    } else {
      // INCORRECTO: Rojo
      botones[selectedIdx].classList.add("is-wrong");
      // Opcional: mostrar cuál era la correcta en verde
      botones[data.correct].classList.add("is-correct");
    }

    // Bloquear otros botones para que no sigan marcando
    botones.forEach((btn) => (btn.style.pointerEvents = "none"));

    btnPrincipal.innerText = "CONTINUAR";
    btnPrincipal.classList.add("btn-next"); // Cambia color del botón principal
  } else if (btnPrincipal.innerText === "CONTINUAR") {
    currentStep++;
    if (currentStep < quizData.length) {
      loadQuiz();
      btnPrincipal.classList.remove("btn-next");
    } else {
      finishQuiz();
    }
  } else {
    location.reload();
  }
};

/**
 * Finaliza el cuestionario mostrando una vista de éxito
 * y actualizando la barra de progreso al máximo.
 */
function finishQuiz() {
  progBar.style.width = "100%";
  pTexto.innerText = "¡Nivel Completado!";
  oContenedor.innerHTML =
    '<div class="text-center"><img src="https://cdn-icons-png.flaticon.com/512/190/190411.png" width="100"></div>';
  btnPrincipal.innerText = "FINALIZAR";
  btnPrincipal.classList.remove("btn-next");
}

// Inicialización de la aplicación
loadQuiz();
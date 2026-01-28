const quizData = [
  {
    q: "¿A qué territorio pertenece esta canción?",
    options: ["Comarca", "Edoras", "Mordor", "Rivendel"],
    correct: 0,
    audio: "../media/Audio/The Shire.mp3",
  },
  // ... más preguntas
];

// Tu código JS que ya tenías
let currentStep = 0;
let selectedIdx = null;

const pTexto = document.getElementById("preguntaTexto");
const oContenedor = document.getElementById("opcionesContenedor");
const btnPrincipal = document.getElementById("btnPrincipal");
const progBar = document.getElementById("progressBar");

const audio = document.getElementById("audioPregunta");
const btnAudio = document.getElementById("btnAudio");

function loadQuiz() {
  const currentQuiz = quizData[currentStep];

  // Texto pregunta
  pTexto.innerText = currentQuiz.q;

  // Audio
  if (currentQuiz.audio) {
    audio.src = currentQuiz.audio;
    audio.load();
  }

  // Reset estado
  oContenedor.innerHTML = "";
  selectedIdx = null;
  btnPrincipal.innerText = "COMPROBAR";
  btnPrincipal.disabled = true;
  btnPrincipal.classList.remove("btn-next");

  // Barra de progreso
  const percent = (currentStep / quizData.length) * 100 + 10;
  progBar.style.width = percent + "%";

  // Opciones
  currentQuiz.options.forEach((opt, i) => {
    const button = document.createElement("button");
    button.className = "option-btn";
    button.innerText = opt;
    button.onclick = () => selectOption(i, button);
    oContenedor.appendChild(button);
  });
}

function selectOption(idx, el) {
  document
    .querySelectorAll(".option-btn")
    .forEach((b) => b.classList.remove("active"));

  el.classList.add("active");
  selectedIdx = idx;
  btnPrincipal.disabled = false;
}

btnPrincipal.onclick = () => {
  if (btnPrincipal.innerText === "COMPROBAR") {
    const data = quizData[currentStep];
    const botones = document.querySelectorAll(".option-btn");

    // Parar audio al comprobar
    audio.pause();
    audio.currentTime = 0;

    if (selectedIdx === data.correct) {
      botones[selectedIdx].classList.add("is-correct");
    } else {
      botones[selectedIdx].classList.add("is-wrong");
      botones[data.correct].classList.add("is-correct");
    }

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

// Botón de reproducir audio
btnAudio.addEventListener("click", () => {
  if (audio.paused) {
    audio.play();
  } else {
    audio.pause();
  }
});
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

// Carga inicial
loadQuiz();

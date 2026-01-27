const quizData = [
  {
    q: "¿Quién es el portador del anillo único?",
    options: ["Gandalf", "Sauron", "Frodo", "Denethor"],
    correct: 2
  },
  {
    q: "¿En qué lugar fue forjado el anillo?",
    options: ["Rivendel", "Monte del Destino", "La Comarca", "Isengard"],
    correct: 1
  },
  {
    q: "¿Cuántos anillos recibieron los hombres?",
    options: ["Tres", "Siete", "Uno", "Nueve"],
    correct: 3
  }
];

let currentStep = 0;
let selectedIdx = null;

const pTexto = document.getElementById('preguntaTexto');
const oContenedor = document.getElementById('opcionesContenedor');
const btnPrincipal = document.getElementById('btnPrincipal');
const progBar = document.getElementById('progressBar');

function loadQuiz() {
  const currentQuiz = quizData[currentStep];
  pTexto.innerText = currentQuiz.q;
  oContenedor.innerHTML = '';
  selectedIdx = null;
  btnPrincipal.innerText = "COMPROBAR";
  btnPrincipal.disabled = true;

  // Actualizar barra
  const percent = ((currentStep) / quizData.length) * 100 + 10;
  progBar.style.width = percent + "%";

  currentQuiz.options.forEach((opt, i) => {
    const button = document.createElement('button');
    button.className = 'option-btn';
    button.innerText = opt;
    button.onclick = () => selectOption(i, button);
    oContenedor.appendChild(button);
  });
}

function selectOption(idx, el) {
  document.querySelectorAll('.option-btn').forEach(b => b.classList.remove('active'));
  el.classList.add('active');
  selectedIdx = idx;
  btnPrincipal.disabled = false;
}

btnPrincipal.onclick = () => {
  if (btnPrincipal.innerText === "COMPROBAR") {
    const data = quizData[currentStep];
    const botones = document.querySelectorAll('.option-btn');
    
    // Validar respuesta
    if (selectedIdx === data.correct) {
      // CORRECTO: Verde
      botones[selectedIdx].classList.add('is-correct');
    } else {
      // INCORRECTO: Rojo
      botones[selectedIdx].classList.add('is-wrong');
      // Opcional: mostrar cuál era la correcta en verde
      botones[data.correct].classList.add('is-correct');
    }

    // Bloquear otros botones para que no sigan marcando
    botones.forEach(btn => btn.style.pointerEvents = 'none');
    
    btnPrincipal.innerText = "CONTINUAR";
    btnPrincipal.classList.add('btn-next'); // Cambia color del botón principal
  } else if (btnPrincipal.innerText === "CONTINUAR") {
    currentStep++;
    if (currentStep < quizData.length) {
      loadQuiz();
      btnPrincipal.classList.remove('btn-next');
    } else {
      finishQuiz();
    }
  } else {
    location.reload();
  }
};

function finishQuiz() {
  progBar.style.width = "100%";
  pTexto.innerText = "¡Nivel Completado!";
  oContenedor.innerHTML = '<div class="text-center"><img src="https://cdn-icons-png.flaticon.com/512/190/190411.png" width="100"></div>';
  btnPrincipal.innerText = "FINALIZAR";
  btnPrincipal.classList.remove('btn-next');
}

// Carga inicial
loadQuiz();

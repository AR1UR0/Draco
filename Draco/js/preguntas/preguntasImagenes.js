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

let currentStep = 0;
let selectedIdx = null;

const pTexto = document.getElementById("preguntaTexto");
const oContenedor = document.getElementById("opcionesContenedor");
const btnPrincipal = document.getElementById("btnPrincipal");
const progBar = document.getElementById("progressBar");

function loadQuiz() {
  const data = quizData[currentStep];
  pTexto.innerText = data.q;
  oContenedor.innerHTML = "";
  selectedIdx = null;

  btnPrincipal.innerText = "COMPROBAR";
  btnPrincipal.disabled = true;
  btnPrincipal.classList.remove("btn-next");

  // Progreso
  progBar.style.width = ((currentStep + 1) / quizData.length) * 100 + "%";

  data.options.forEach((imgUrl, i) => {
    const div = document.createElement("div");
    div.className = "option-card";
    div.innerHTML = `<img src="${imgUrl}" alt="opcion">`;
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

btnPrincipal.onclick = () => {
  if (btnPrincipal.innerText === "COMPROBAR") {
    const cards = document.querySelectorAll(".option-card");
    const correctIdx = quizData[currentStep].correct;

    if (selectedIdx === correctIdx) {
      cards[selectedIdx].classList.add("is-correct");
    } else {
      cards[selectedIdx].classList.add("is-wrong");
      cards[correctIdx].classList.add("is-correct"); // Mostrar la correcta
    }

    btnPrincipal.innerText = "CONTINUAR";
    btnPrincipal.classList.add("btn-next");
  } else {
    currentStep++;
    if (currentStep < quizData.length) {
      loadQuiz();
    } else {
      alert("¡Trivia completada!");
      location.reload();
    }
  }
};

loadQuiz();

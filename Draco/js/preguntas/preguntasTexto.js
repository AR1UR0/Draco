const progressBar = document.getElementById("progressBar");

let totalQuestions = 5;  // Por ejemplo, 10 preguntas
let currentQuestion = 1;

function updateProgress() {
  const progressPercent = (currentQuestion / totalQuestions) * 100;
  progressBar.style.width = progressPercent + "%";
}

// Simulación de avance de preguntas:
document.getElementById("checkBtn").addEventListener("click", () => {
  if(currentQuestion < totalQuestions){
    currentQuestion++;
    updateProgress();
    // Aquí puedes cambiar la pregunta y opciones
  }
});

updateProgress();

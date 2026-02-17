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

const urlParams = new URLSearchParams(window.location.search);
// http://127.0.0.1:8000/pregunta-texto?tematica=1&pregunta=1
const idPregunta = urlParams.get("pregunta");
const idTematica = urlParams.get("tematica");

if (isNaN(idPregunta) || idPregunta === null) {
    alert("La pregunta es inválida");
}
if (isNaN(idTematica) || idTematica === null) {
    alert("La temática es inválida");
}

const contenedorTexto = document.getElementById("contenedorTexto");
const contenedorAudio = document.getElementById("contenedorAudio");
const contenedorImagenes = document.getElementById("contenedorImagenes");
const opcionesContenedor = document.getElementById("opcionesContenedor");
const audioSource = document.getElementById("audioSource");
const audioPregunta = document.getElementById("audioPregunta");

document.getElementById("btnAudio").addEventListener("click", function () {
    audioPregunta.play();
});

async function pedirPreguntas() {
    const testsPromise = await fetch(
        `/api/tests?tematica_id=${idTematica}&order=${idPregunta}`,
    );
    const tests = await testsPromise.json();

    // console.log("tests", tests);

    if (tests.length == 0) {
        alert("No existe el test");
        return;
    }

    const preguntas = (
        await Promise.all(
            tests.map(async function (test) {
                const preguntasPromise = await fetch(
                    `/api/preguntas?test_id=${test.id}`,
                );
                return await preguntasPromise.json();
            }),
        )
    ).flat();

    // console.log("preguntas", preguntas);

    const respuestas = await Promise.all(
        preguntas.map(async function (pregunta) {
            const respuestasPromise = await fetch(
                `/api/respuestas?pregunta_id=${pregunta.id}`,
            );
            return (await respuestasPromise.json())
                .map((value) => ({ value, sort: Math.random() }))
                .sort((a, b) => a.sort - b.sort)
                .map(({ value }) => value);
        }),
    );

    // console.log("respuestas", respuestas);

    quizData = preguntas.map(function (pregunta, index) {
        const respuesta = respuestas[index];
        return {
            q: pregunta.enunciado,
            options: respuesta.map(function (res) {
                return {
                    text: res.opcion,
                    audio: res.audio,
                    imagen: res.image,
                };
            }),
            correct: respuesta.findIndex(function (res) {
                return res.is_correct == 1;
            }),
            audio: pregunta.audio,
        };
    });

    console.log("quizData", quizData);
    loadQuiz(quizData[currentStep]);
}

/** @type {number} Índice del paso o pregunta actual */
let currentStep = 0;

/** @type {number|null} Índice de la opción seleccionada por el usuario */
let selectedIdx = null;

// --- ELEMENTOS DEL INTERFAZ DE USUARIO ---
var quizData = null;
pedirPreguntas();

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
function loadQuizText(currentQuiz) {
    contenedorImagenes.classList.add("d-none");
    contenedorAudio.classList.add("d-none");
    contenedorTexto.classList.remove("d-none");
    opcionesContenedor.classList.remove("options-grid-images");

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
        button.innerText = opt.text;
        button.onclick = () => selectOption(i, button);
        oContenedor.appendChild(button);
    });
}

function loadQuizImage(currentQuiz) {
    contenedorImagenes.classList.remove("d-none");
    contenedorAudio.classList.add("d-none");
    contenedorTexto.classList.add("d-none");
    opcionesContenedor.classList.add("options-grid-images");

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
        const img = document.createElement("img");
        button.className = "option-btn";
        img.setAttribute("src", opt.imagen);
        img.style.maxWidth = "300px";
        img.style.height = "auto";
        button.appendChild(img);
        button.onclick = () => selectOption(i, button);
        oContenedor.appendChild(button);
        console.log("opt,", opt);
    });
}

function loadQuizAudio(currentQuiz) {
    contenedorImagenes.classList.add("d-none");
    contenedorAudio.classList.remove("d-none");
    contenedorTexto.classList.add("d-none");
    opcionesContenedor.classList.remove("options-grid-images");

    pTexto.innerText = currentQuiz.q;
    audioSource.setAttribute("src", currentQuiz.audio);
    audioPregunta.load();
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
        button.onclick = () => selectOption(i, button);
        button.innerText = opt.text;
        oContenedor.appendChild(button);
        console.log("opt,", opt);
    });
}

function loadQuiz(currentQuiz) {
    let hasAudio = currentQuiz.audio != null && currentQuiz.audio != undefined;
    let hasImage = false;
    console.log("currentquiz", currentQuiz);
    for (let i = 0; i < currentQuiz.options.length; i++) {
        if (
            currentQuiz.options[i].audio != null &&
            currentQuiz.options[i].audio != undefined
        ) {
            hasAudio = true;
        } else if (
            currentQuiz.options[i].imagen != undefined &&
            currentQuiz.options[i].imagen != null
        ) {
            hasImage = true;
        }
    }

    if (hasAudio === true) {
        console.log("la pregunta te audio");
        loadQuizAudio(currentQuiz);
    } else if (hasImage === true) {
        console.log("la pregunta te imagen");
        loadQuizImage(currentQuiz);
    } else {
        console.log("La pregunta no te ni audio ni res");
        loadQuizText(currentQuiz);
    }
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
        audioPregunta.pause();
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
            loadQuiz(quizData[currentStep]);
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

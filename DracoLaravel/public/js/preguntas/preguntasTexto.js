/**
 * @fileoverview Logic for the questionnaire system (Quiz).
 * Manages question loading, answer validation,
 * progress bar updates, and final states.
 * @author Thais/Draco Team
 * @version 1.4.0
 */

/**
 * Configuration parameters extracted from the URL to identify the current test.
 */
const urlParams = new URLSearchParams(window.location.search);
// http://127.0.0.1:8000/pregunta-texto?tematica=1&pregunta=1
const idPregunta = urlParams.get("pregunta");
const idTematica = urlParams.get("tematica");

/**
 * Initial integrity validations of mandatory parameters.
 */
if (isNaN(idPregunta) || idPregunta === null) {
    alert("La pregunta és invàlida");
}
if (isNaN(idTematica) || idTematica === null) {
    alert("La temàtica és invàlida");
}

/** * Current state of the user's response.
 * Values: "no confirmado", "confirmado", "final", "game_over".
 */
var estadoPregunta = "no confirmado";

// --- CONTAINER AND MULTIMEDIA SELECTORS ---
const contenedorTexto = document.getElementById("contenedorTexto");
const contenedorAudio = document.getElementById("contenedorAudio");
const contenedorImagenes = document.getElementById("contenedorImagenes");
const opcionesContenedor = document.getElementById("opcionesContenedor");
const audioSource = document.getElementById("audioSource");
const audioPregunta = document.getElementById("audioPregunta");

/**
 * Handler for manual playback of the question audio.
 */
document.getElementById("btnAudio").addEventListener("click", function () {
    audioPregunta.play();
});

/**
 * Retrieves and structures quiz data from the API.
 * Performs chained requests for test, questions, and answers,
 * processing and shuffling options randomly.
 * @async
 */
async function pedirPreguntas() {
    const testsPromise = await fetch(
        `/api/tests?tematica_id=${idTematica}&order=${idPregunta}`,
    );
    const tests = await testsPromise.json();

    // console.log("tests", tests);

    if (tests.length == 0) {
        alert("No existeix el test");
        return;
    }

    /** Mapping of questions associated with the found tests */
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

    /** Retrieval and shuffling of answers for each question */
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

    /** Data transformation to internal Quiz format */
    quizData = preguntas.map(function (pregunta, index) {
        const respuesta = respuestas[index];
        return {
            q: pregunta.enunciado,
            options: respuesta.map(function (res) {
                return {
                    text: res.opcion,
                    id: res.id,
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

/** @type {number} Navigation index of the current question */
let currentStep = 0;

/** @type {number|null} Stores the selected option before confirming */
let selectedIdx = null;

// --- DATA INITIALIZATION ---
var quizData = null;
pedirPreguntas();

/** @type {HTMLElement} Reference to the question statement */
const pTexto = document.getElementById("preguntaTexto");

/** @type {HTMLElement} Container where options are injected */
const oContenedor = document.getElementById("opcionesContenedor");

/** @type {HTMLElement} Button that controls the application flow */
const btnPrincipal = document.getElementById("btnPrincipal");

/** @type {HTMLElement} Visual progress indicator */
const progBar = document.getElementById("progressBar");

/**
 * Prepares the interface for a text-type question.
 * @param {Object} currentQuiz - Object containing question data.
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

    // Update progress bar
    const percent = (currentStep / quizData.length) * 100 + 10;
    progBar.style.width = percent + "%";

    currentQuiz.options.forEach((opt, i) => {
        const button = document.createElement("button");
        button.className = "option-btn";
        button.innerText = opt.text;
        button.onclick = () => {
            selectOption(i, button);
        };
        oContenedor.appendChild(button);
    });
}

/**
 * Prepares the interface for an image-type question with a specific grid.
 * @param {Object} currentQuiz - Object containing question data.
 */
function loadQuizImage(currentQuiz) {
    contenedorAudio.classList.add("d-none");
    contenedorTexto.classList.add("d-none");
    contenedorImagenes.classList.remove("d-none");
    opcionesContenedor.classList.add("options-grid-images");

    pTexto.innerText = currentQuiz.q;
    oContenedor.innerHTML = "";
    selectedIdx = null;
    btnPrincipal.innerText = "COMPROBAR";
    btnPrincipal.disabled = true;

    // Update progress bar
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
        button.onclick = () => {
            selectOption(i, button);
        };
        oContenedor.appendChild(button);
        console.log("opt,", opt);
    });
}

/**
 * Prepares the interface and loads the audio resource for the question.
 * @param {Object} currentQuiz - Object containing question data.
 */
function loadQuizAudio(currentQuiz) {
    contenedorImagenes.classList.add("d-none");
    contenedorTexto.classList.add("d-none");
    contenedorAudio.classList.remove("d-none");

    pTexto.innerText = currentQuiz.q;

    if (currentQuiz.audio) {
        audioSource.setAttribute("src", currentQuiz.audio);
        audioPregunta.load();
    } else {
        contenedorAudio.classList.add("d-none");
    }
    oContenedor.innerHTML = "";
    selectedIdx = null;
    btnPrincipal.innerText = "COMPROBAR";
    btnPrincipal.disabled = true;

    // Update progress bar
    const percent = (currentStep / quizData.length) * 100 + 10;
    progBar.style.width = percent + "%";

    currentQuiz.options.forEach((opt, i) => {
        const button = document.createElement("button");
        button.className = "option-btn";
        button.onclick = () => {
            selectOption(i, button);
        };
        button.innerText = opt.text;
        oContenedor.appendChild(button);
        console.log("opt,", opt);
    });
}

/**
 * Acts as an orchestrator to determine the type of visual load
 * based on the metadata present in the question (Audio, Image, or Text).
 * @param {Object} currentQuiz - Object containing question data.
 */
function loadQuiz(currentQuiz) {
    // Helper function to validate if a resource truly exists
    const isValid = (res) =>
        res !== null &&
        res !== undefined &&
        res.toString().trim() !== "" &&
        res !== "null";

    // We initialize based on the main question audio
    let hasAudio = isValid(currentQuiz.audio);
    let hasImage = false;

    console.log("Cargando pregunta. ¿Tiene audio inicial?:", hasAudio);

    // We check the options to see if any have multimedia
    for (let i = 0; i < currentQuiz.options.length; i++) {
        if (isValid(currentQuiz.options[i].audio)) {
            hasAudio = true;
        }
        if (isValid(currentQuiz.options[i].imagen)) {
            hasImage = true;
        }
    }

    // Loading priority
    if (hasAudio) {
        console.log("Modo: AUDIO");
        loadQuizAudio(currentQuiz);
    } else if (hasImage) {
        console.log("Modo: IMAGEN");
        loadQuizImage(currentQuiz);
    } else {
        console.log("Modo: TEXTO");
        loadQuizText(currentQuiz);
    }
}

/**
 * Manages button selection, updating CSS classes and choice index.
 * @param {number} idx - Index of the option.
 * @param {HTMLElement} el - Clicked element.
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
 * Central control of the Quiz flow.
 * Processes answer validation, server communication (Fetch POST),
 * user lives management, and game state navigation.
 * @author Thais
 * @listens click
 */
btnPrincipal.onclick = () => {
    console.log("estadoPregunta", estadoPregunta);
    if (estadoPregunta === "no confirmado") {
        console.log("pause");
        audioPregunta.pause();
        const data = quizData[currentStep];
        const botones = document.querySelectorAll(".option-btn");

        // Validate response
        if (selectedIdx === data.correct) {
            // CORRECT: Green
            botones[selectedIdx].classList.add("is-correct");
            const idRespuestaCorrecta = data.options[selectedIdx].id;

            fetch("/test/validar", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                body: JSON.stringify({ id_respuesta: idRespuestaCorrecta }),
            });
            /**
             * Error logic and life penalty management.
             * Implements "Draco Plus Protection" to bypass penalties.
             * @author Marta
             */
        } else {
            // INCORRECT: RED
            botones[selectedIdx].classList.add("is-wrong");
            // SHOW WHICH ONE IS CORRECT IN GREEN
            botones[data.correct].classList.add("is-correct");

            // --- DRACO PLUS PROTECTION ---
            if (!window.isUserPlus) {
                /** * Immediate visual update.
                 * Subtracts one DOM element to provide instant user feedback.
                 */
                const contador = document.getElementById("contadorVidas");
                let vidasFinales = 0;
                if (contador) {
                    vidasFinales = parseInt(contador.innerText) - 1;
                    contador.innerText = vidasFinales > 0 ? vidasFinales : 0;
                }

                /**
                 * Database persistence.
                 * Sends an asynchronous request to the server to decrement the lifetime in the backend.
                 * Sends response_id: -1 to force failure logic in the controller.
                 * @author Marta
                 */
                fetch("/test/validar", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                    },
                    body: JSON.stringify({ id_respuesta: -1 }),
                });

                /**
                 * 'Game Over' status control.
                 * If the user runs out of lives, progress is blocked and the exit is prepared.
                 * @author Marta
                 */
                if (vidasFinales <= 0) {
                    estadoPregunta = "game_over";
                    btnPrincipal.innerText = "VOLVER AL MENÚ";
                    btnPrincipal.classList.add("btn-danger");
                    btnPrincipal.disabled = false;
                    return;
                }
            }
        }

        // Interaction block: prevents changing the answer once confirmed
        botones.forEach((btn) => (btn.style.pointerEvents = "none"));
        // Preparation for the transition to the next phase
        btnPrincipal.innerText = "CONTINUAR";
        estadoPregunta = "confirmado";
        btnPrincipal.classList.add("btn-next");
    } else if (estadoPregunta === "confirmado") {
        currentStep++;
        if (currentStep < quizData.length) {
            estadoPregunta = "no confirmado";
            loadQuiz(quizData[currentStep]);
            btnPrincipal.classList.remove("btn-next");
        } else {
            finishQuiz();
        }
    } else if (estadoPregunta === "final") {
        window.location.href = "/pagPrincipal?tematica=" + idTematica; // Direct redirection
    } else if (estadoPregunta === "game_over") {
        alert(
            "T'has quedat sense vides. Seràs redirigit a la pàgina principal.",
        );
        window.location.href = "/pagPrincipal";
    }
};

/**
 * Clears the interface of trivia elements and shows the success screen.
 * Updates the state to "final" to allow redirection.
 * @author Thais
 */
function finishQuiz() {
    contenedorImagenes.classList.add("d-none");
    contenedorAudio.classList.add("d-none");
    contenedorTexto.classList.add("d-none");

    progBar.style.width = "100%";
    pTexto.innerText = "¡Nivel Completado!";
    oContenedor.innerHTML =
        '<div class="text-center"><img src="https://cdn-icons-png.flaticon.com/512/190/190411.png" width="100"></div>';
    btnPrincipal.innerText = "FINALIZAR";
    estadoPregunta = "final";
    btnPrincipal.classList.remove("btn-next");
}

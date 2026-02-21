/**
 * @fileoverview Lògica per al sistema de qüestionaris (Quiz).
 * Gestiona la càrrega de preguntes, validació de respostes,
 * actualització de la barra de progrés i estats finals.
 * @author Thais/Draco Team
 * @version 1.4.0
 */

/**
 * Paràmetres de configuració extrets de la URL per a identificar el test actual.
 */
const urlParams = new URLSearchParams(window.location.search);
// http://127.0.0.1:8000/pregunta-texto?tematica=1&pregunta=1
const idPregunta = urlParams.get("pregunta");
const idTematica = urlParams.get("tematica");

/**
 * Validacions inicials d'integritat dels paràmetres obligatoris.
 */
if (isNaN(idPregunta) || idPregunta === null) {
    alert("La pregunta és invàlida");
}
if (isNaN(idTematica) || idTematica === null) {
    alert("La temàtica és invàlida");
}

/** * Estat actual de la resposta de l'usuari.
 * Valors: "no confirmado", "confirmado", "final", "game_over".
 */
var estadoPregunta = "no confirmado";

// --- SELECTORS DE CONTENIDORS I MULTIMÈDIA ---
const contenedorTexto = document.getElementById("contenedorTexto");
const contenedorAudio = document.getElementById("contenedorAudio");
const contenedorImagenes = document.getElementById("contenedorImagenes");
const opcionesContenedor = document.getElementById("opcionesContenedor");
const audioSource = document.getElementById("audioSource");
const audioPregunta = document.getElementById("audioPregunta");

/**
 * Manegador per a la reproducció manual de l'àudio de la pregunta.
 */
document.getElementById("btnAudio").addEventListener("click", function () {
    audioPregunta.play();
});

/**
 * Obté i estructura les dades del quiz des de l'API.
 * Realitza peticions encadenades per a test, preguntes i respostes,
 * processant i barrejant les opcions aleatòriament.
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

    /** Mapeig de preguntes associades als tests trobats */
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

    /** Obtenció i barreja de respostes per a cada pregunta */
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

    /** Transformació de dades al format intern del Quiz */
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

/** @type {number} Índex de navegació de la pregunta actual */
let currentStep = 0;

/** @type {number|null} Emmagatzema l'opció seleccionada abans de confirmar */
let selectedIdx = null;

// --- INICIALITZACIÓ DE DADES ---
var quizData = null;
pedirPreguntas();

/** @type {HTMLElement} Referència a l'enunciat de la pregunta */
const pTexto = document.getElementById("preguntaTexto");

/** @type {HTMLElement} Contenidor on s'injecten les opcions */
const oContenedor = document.getElementById("opcionesContenedor");

/** @type {HTMLElement} Botó que controla el flux de l'aplicació */
const btnPrincipal = document.getElementById("btnPrincipal");

/** @type {HTMLElement} Indicador visual d'avanç */
const progBar = document.getElementById("progressBar");

/**
 * Prepara la interfície per a una pregunta de tipus text.
 * @param {Object} currentQuiz - Objecte amb dades de la pregunta.
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

    // Actualitzar barra
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
 * Prepara la interfície per a una pregunta de tipus imatge amb grid específic.
 * @param {Object} currentQuiz - Objecte amb dades de la pregunta.
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

    // Actualitzar barra
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
 * Prepara la interfície i carrega el recurs d'àudio per a la pregunta.
 * @param {Object} currentQuiz - Objecte amb dades de la pregunta.
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

    // Actualitzar barra
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
 * Actua com a orquestrador per a determinar el tipus de càrrega visual
 * segons les metadades presents en la pregunta (Àudio, Imatge o Text).
 * @param {Object} currentQuiz - Objecte amb dades de la pregunta.
 */
function loadQuiz(currentQuiz) {
    // Función auxiliar para validar si un recurso existe de verdad
    const isValid = (res) => res !== null && res !== undefined && res.toString().trim() !== "" && res !== "null";

    // Inicializamos basándonos en el audio de la pregunta principal
    let hasAudio = isValid(currentQuiz.audio);
    let hasImage = false;
    
    console.log("Cargando pregunta. ¿Tiene audio inicial?:", hasAudio);

    // Revisamos las opciones para ver si alguna tiene multimedia
    for (let i = 0; i < currentQuiz.options.length; i++) {
        if (isValid(currentQuiz.options[i].audio)) {
            hasAudio = true;
        } 
        if (isValid(currentQuiz.options[i].imagen)) {
            hasImage = true;
        }
    }

    // Prioridad de carga
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
 * Gestiona la selecció de botons, actualitzant classes CSS i l'índex d'elecció.
 * @param {number} idx - Índex de l'opció.
 * @param {HTMLElement} el - Element polsat.
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
 * Control central del flux del Quiz.
 * Processa la validació de respostes, comunicació amb el servidor (Fetch POST),
 * gestió de vides de l'usuari i navegació entre estats del joc.
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

        // Validar resposta
        if (selectedIdx === data.correct) {
            // CORRECTE: Verd
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
            * Gestión de la lógica de error y penalización de vidas.
            * Implementa la "Protección Draco Plus" para omitir penalizaciones.
            * * @author Marta 
            */
        } else {
            // INCORRECTO: ROJO
            botones[selectedIdx].classList.add("is-wrong");
            // MUESTRA CUAL ES CORRECTA EN VERDE
            botones[data.correct].classList.add("is-correct");

            // --- PROTECCIÓN DRACO PLUS ---
            if (!window.isUserPlus) {
                /** * Actualización visual inmediata.
                * Resta una vida del DOM para dar feedback instantáneo al usuario.
                */
                const contador = document.getElementById("contadorVidas");
                let vidasFinales = 0;
                if (contador) {
                    vidasFinales = parseInt(contador.innerText) - 1;
                    contador.innerText = vidasFinales > 0 ? vidasFinales : 0;
                }

            /**
            * Persistencia en Base de Datos.
            * Envía una petición asíncrona al servidor para decrementar la vida en el backend.
            * Se envía id_respuesta: -1 para forzar la lógica de fallo en el controlador.
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
                body: JSON.stringify({ id_respuesta: -1 }), // Enviem un ID que sabem que no existeix perquè el controlador reste vida
            });

            /**
            * Control de Estado 'Game Over'.
            * Si el usuario agota sus vidas, se bloquea el progreso y se prepara la salida.
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

        // Bloqueo de interacción: impide cambiar la respuesta una vez confirmada
        botones.forEach((btn) => (btn.style.pointerEvents = "none"));
        // Preparación de la transición a la siguiente fase
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
        window.location.href = "/pagPrincipal?tematica=" + idTematica; // Redirecció directa
    } else if (estadoPregunta === "game_over") {
        alert(
            "T'has quedat sense vides. Seràs redirigit a la pàgina principal.",
        );
        window.location.href = "/pagPrincipal";
    }
};

/**
 * Neteja la interfície d'elements de trivia i mostra la pantalla d'èxit.
 * Actualitza l'estat a "final" per a permetre la redirecció.
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

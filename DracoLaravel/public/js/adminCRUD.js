/**
 * @fileoverview Lògica de control per al panell d'administració.
 * Gestiona la navegació entre temàtiques i tests, així com les
 * operacions CRUD (Crear, Llegir, Actualitzar, Borrar) de preguntes.
 * @author Thais/Draco Team
 * @version 1.0.0
 */

/** * Estat global per a rastrejar la selecció actual de l'administrador.
 * S'utilitza per a saber en quin context (temàtica/test) s'estan realitzant les operacions.
 * @type {Object}
 * @property {number|null} tematicaId - Identificador de la temàtica activa.
 * @property {number|null} testId - Identificador del test actiu.
 */
window.adminState = {
    tematicaId: null,
    testId: null,
};

/**
 * Configuració inicial dels listeners d'esdeveniments un colp carregat el DOM.
 * Centralitza la captura de botons principals i la gestió de la vista inicial.
 */
document.addEventListener("DOMContentLoaded", () => {
    // Referències als contenidors i botons de l'estructura base
    const contentArea = document.querySelector(".admin-content-area");
    const btnCargarTematicas = document.getElementById("btn-cargar-tematicas");
    const btnAñadirPregunta = document.getElementById("btn-añadir-pregunta");

    // Selecció per índex dels botons d'administració lateral segons l'ordre de l'HTML
    const botonesAdmin = document.querySelectorAll(".btnAdmin");
    const btnModificar = botonesAdmin[2];
    const btnEliminar = botonesAdmin[3];

    // --- 1. ESDEVENIMENT TEMÀTICA ---
    // En polsar el botó de càrrega, s'obtenen totes les categories disponibles
    if (btnCargarTematicas) {
        btnCargarTematicas.addEventListener("click", async () => {
            // Feedback visual de càrrega per a l'usuari
            contentArea.innerHTML =
                '<div class="text-center p-5"><div class="spinner-border text-primary"></div><p class="mt-2">Cargando temáticas...</p></div>';
            try {
                // Petició asíncrona a la llista de temàtiques
                const response = await fetch("/api/tematicas");
                const tematicas = await response.json();

                // Neteja i preparació del grid visual
                contentArea.innerHTML = `<div class="p-4"><h3 class="text-dark mb-4 text-center">Selecciona una Temática</h3><div class="row g-3" id="grid-tematicas"></div></div>`;
                const grid = document.getElementById("grid-tematicas");

                // Generació dinàmica de botons per a cada temàtica trobada
                tematicas.forEach((t) => {
                    const col = document.createElement("div");
                    col.className = "col-6 col-md-4";
                    col.innerHTML = `<button class="btn btn-outline-dark w-100 py-3 fw-bold border-2" onclick="seleccionarTematica(${t.id}, '${t.name}')" style="border-color: #d4e157; color: #98b705;">${t.name}</button>`;
                    grid.appendChild(col);
                });
            } catch (error) {
                console.error("Error carregant temàtiques:", error);
            }
        });
    }

    // --- 2. ESDEVENIMENT AFEGIR ---
    // Comprova que hi haja un test seleccionat abans de mostrar el formulari de creació
    if (btnAñadirPregunta) {
        btnAñadirPregunta.addEventListener("click", () => {
            if (!window.adminState.testId)
                return alert("Selecciona primero una Temática y un Test.");
            mostrarFormularioPregunta(); // Mostra el formulari buit per a inserció
        });
    }

    // --- 3. ESDEVENIMENT MODIFICAR ---
    // Permet llistar les preguntes existents per a entrar en mode edició
    if (btnModificar) {
        btnModificar.addEventListener("click", () => {
            if (!window.adminState.testId)
                return alert("Selecciona primero una Temática y un Test.");
            listarPreguntasParaEditar();
        });
    }

    // --- 4. ESDEVENIMENT ELIMINAR ---
    // Permet llistar les preguntes per a la seua esborradura permanent
    if (btnEliminar) {
        btnEliminar.addEventListener("click", () => {
            if (!window.adminState.testId)
                return alert("Selecciona primero una Temática y un Test.");
            listarPreguntasParaEliminar();
        });
    }
});

/** * SECCIÓ: NAVEGACIÓ (TEMÀTIQUES I TESTS)
 */

/**
 * Estableix la temàtica activa, actualitza l'estat i llança la càrrega dels tests associats.
 * @param {number} id - ID únic de la temàtica.
 * @param {string} nombre - Etiqueta textual de la temàtica.
 */
async function seleccionarTematica(id, nombre) {
    window.adminState.tematicaId = id;
    const contentArea = document.querySelector(".admin-content-area");
    // Inclou un botó de retorn per a facilitar la navegació a l'usuari
    contentArea.innerHTML = `<div class="p-4"><button class="btn btn-sm btn-secondary mb-3" onclick="document.getElementById('btn-cargar-tematicas').click()">← Volver</button><h3 class="text-dark mb-4 text-center">Tests en: ${nombre}</h3><div class="row g-3" id="grid-tests"></div></div>`;
    await cargarTests(id);
}

/**
 * Obté els tests que pertanyen a una temàtica concreta filtrant els resultats de l'API.
 * @param {number} tematicaId - ID de referència per a filtrar la llista.
 */
async function cargarTests(tematicaId) {
    const grid = document.getElementById("grid-tests");
    try {
        const response = await fetch(`/api/tematicas`);
        const tematicas = await response.json();

        // Busquem en l'array de temàtiques la que coincideix amb la seleccionada
        const tematicaActual = tematicas.find((t) => t.id === tematicaId);
        grid.innerHTML = "";

        // Iterem sobre la propietat 'tests' de l'objecte temàtica
        tematicaActual.tests.forEach((test) => {
            const col = document.createElement("div");
            col.className = "col-12";
            col.innerHTML = `<button class="btn w-100 py-2 d-flex justify-content-between align-items-center shadow-sm mb-2" onclick="fijarTest(${test.id}, '${test.title}')" style="background-color: #f8f9fa; border: 2px solid #ff4081; color: #333;"><span class="fw-bold">${test.title}</span><span class="badge bg-dark">ID: ${test.id}</span></button>`;
            grid.appendChild(col);
        });
    } catch (e) {
        console.error("Error en carregar tests:", e);
    }
}

/**
 * Bloqueja el test actiu en l'estat global i mostra un missatge de confirmació.
 * Prepara l'entorn per a realitzar accions de CRUD.
 * @param {number} id - ID del test.
 * @param {string} titulo - Títol del test per al feedback visual.
 */
function fijarTest(id, titulo) {
    window.adminState.testId = id;
    document.querySelector(".admin-content-area").innerHTML =
        `<div class="text-center p-5"><h4 class="text-primary fw-bold text-black">Test Seleccionado:</h4><h2 style="color: black;">${titulo}</h2><div class="alert alert-success mt-4">¡Listo! Ahora elige una acción a la izquierda.</div></div>`;
}

/** * SECCIÓ: FORMULARI ÚNIC (CREAR / EDITAR)
 */

/**
 * Inyecta el codi HTML del formulari dinàmic en l'àrea de contingut.
 * Utilitza un bucle map per a generar els camps de les 4 opcions de resposta.
 */
function mostrarFormularioPregunta() {
    document.querySelector(".admin-content-area").innerHTML = `
        <div class="p-4">
            <h3 class="mb-4" style="color: black;">Nueva Pregunta</h3>
            <div class="mb-3">
                <label class="form-label fw-bold" style="color: black;">Enunciado:</label>
                <textarea id="enunciado" class="form-control" rows="2" placeholder="Escribe la pregunta..."></textarea>
            </div>
            <div class="row g-2 mb-3">
                ${[1, 2, 3, 4]
                    .map(
                        (i) => `
                    <div class="col-8"><input type="text" class="form-control" id="opt${i}" placeholder="Opción ${i}"></div>
                    <div class="col-4 d-flex align-items-center"><input type="radio" name="correcta" value="${i - 1}"> Correcta</div>
                `,
                    )
                    .join("")}
            </div>
            <button class="btn btn-success w-100" id="btnGuardarAccion" onclick="guardarPregunta()">GUARDAR EN BASE DE DATOS</button>
        </div>`;
}

/** * SECCIÓ: OPERACIONS CRUD (AFEGIR, MODIFICAR, ELIMINAR)
 */

/**
 * Recull les dades del formulari i crea una nova pregunta mitjançant POST.
 * Inclou validació de camps buits i gestió del token CSRF per a la seguretat.
 * @async
 */
async function guardarPregunta() {
    const enunciado = document.getElementById("enunciado").value;

    // Recollida d'opcions en un array mitjançant mapeig d'IDs
    const opciones = [1, 2, 3, 4].map(
        (i) => document.getElementById(`opt${i}`).value,
    );

    // Identificació de l'índex de la resposta correcta seleccionada
    const indexCorrecta = Array.from(
        document.getElementsByName("correcta"),
    ).findIndex((r) => r.checked);

    // Validació bàsica per a evitar enviaments incomplets
    if (!enunciado || opciones.some((o) => !o.trim()) || indexCorrecta === -1)
        return alert("Por favor, rellena todo.");

    // Estructuració de l'objecte JSON segons el format de l'API
    const datos = {
        enunciado,
        test_id: window.adminState.testId,
        respuestas: opciones.map((o, i) => ({
            opcion: o,
            is_correct: i === indexCorrecta,
        })),
    };

    const res = await fetch("/api/preguntas", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                ?.content,
        },
        body: JSON.stringify(datos),
    });

    if (res.ok) {
        alert("Pregunta creada!");
        // Refresca la vista
        fijarTest(window.adminState.testId, "Pregunta Guardada");
    }
}

/**
 * Recupera totes les preguntes vinculades al test actual per a permetre l'edició.
 * Genera una llista interactiva de tipus "list-group".
 * @async
 */
async function listarPreguntasParaEditar() {
    const res = await fetch(`/api/tests/${window.adminState.testId}/preguntas`);
    const preguntas = await res.json();

    let html = `<div class="p-4"><h3 class="text-center mb-4" style="color: black;">Modificar Preguntas</h3><ul class="list-group">`;

    preguntas.forEach((p) => {
        html += `<li class="list-group-item d-flex justify-content-between align-items-center">${p.enunciado}<button class="btn btn-warning btn-sm" style="background-color: #f70071; border-color: #f70071; color: white;" onclick="cargarDatosEnFormulario(${p.id})">EDITAR</button></li>`;
    });

    document.querySelector(".admin-content-area").innerHTML =
        html + `</ul></div>`;
}

/**
 * Carrega els detalls d'una pregunta específica en el formulari per a la seua modificació.
 * Transforma el botó de "Guardar" en un botó d'"Actualitzar".
 * @param {number} id - ID de la pregunta a recuperar.
 * @async
 */
async function cargarDatosEnFormulario(id) {
    const res = await fetch(`/api/preguntas/${id}`);
    const pregunta = await res.json();
    mostrarFormularioPregunta(); // Reutilitzem la creació del formulari base

    // Modificació de la capçalera i el botó per al mode edició
    document.querySelector("h3").innerText = "Editando Pregunta #" + id;
    const btn = document.getElementById("btnGuardarAccion");
    btn.innerText = "ACTUALIZAR CAMBIOS";
    btn.className = "btn btn-warning w-100";
    btn.setAttribute("onclick", `actualizarPregunta(${id})`);

    // Emplenat dels camps amb la informació recuperada
    document.getElementById("enunciado").value = pregunta.enunciado;
    pregunta.respuestas.forEach((r, i) => {
        document.getElementById(`opt${i + 1}`).value = r.opcion;
        if (r.is_correct)
            document.getElementsByName("correcta")[i].checked = true;
    });
}

/**
 * Envia les actualitzacions d'una pregunta existent mitjançant una petició PUT.
 * @param {number} id - ID de la pregunta que s'està actualitzant.
 * @async
 */
async function actualizarPregunta(id) {
    const enunciado = document.getElementById("enunciado").value;
    const opciones = [1, 2, 3, 4].map(
        (i) => document.getElementById(`opt${i}`).value,
    );
    const indexCorrecta = Array.from(
        document.getElementsByName("correcta"),
    ).findIndex((r) => r.checked);

    const datos = {
        enunciado,
        respuestas: opciones.map((o, i) => ({
            opcion: o,
            is_correct: i === indexCorrecta,
        })),
    };

    const res = await fetch(`/api/preguntas/${id}`, {
        method: "PUT",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                ?.content,
        },
        body: JSON.stringify(datos),
    });

    if (res.ok) {
        alert("Actualizado!");
        // Torna a la llista per a seguir editant si es desitja
        listarPreguntasParaEditar();
    }
}

/**
 * Mostra una llista de preguntes amb opció de borrat directe per a cada element.
 * @async
 */
async function listarPreguntasParaEliminar() {
    const res = await fetch(`/api/tests/${window.adminState.testId}/preguntas`);
    const preguntas = await res.json();

    let html = `<div class="p-4"><h3 class="text-danger mb-4">Eliminar Preguntas</h3><ul class="list-group">`;

    preguntas.forEach((p) => {
        html += `<li class="list-group-item d-flex justify-content-between align-items-center">${p.enunciado}<button class="btn btn-danger btn-sm" onclick="borrarPregunta(${p.id})">ELIMINAR</button></li>`;
    });

    document.querySelector(".admin-content-area").innerHTML =
        html + `</ul></div>`;
}

/**
 * Gestiona l'eliminació física d'una pregunta de la base de dades mitjançant DELETE.
 * Inclou una finestra de confirmació per a evitar pèrdues accidentals.
 * @param {number} id - ID de la pregunta a eliminar.
 * @async
 */
async function borrarPregunta(id) {
    if (!confirm("¿Seguro que quieres borrar la pregunta?")) return;

    const res = await fetch(`/api/preguntas/${id}`, {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                ?.content,
        },
    });

    if (res.ok) {
        alert("Eliminada");
        // Actualitza la llista per a reflectir els canvis
        listarPreguntasParaEliminar();
    } else {
        alert("Error al eliminar");
    }
}

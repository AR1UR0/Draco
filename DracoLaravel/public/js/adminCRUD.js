/**
 * @fileoverview Control logic for the administration panel.
 * Manages navigation between themes and tests, as well as
 * CRUD operations (Create, Read, Update, Delete) for questions.
 * @author Thais/Draco Team
 * @version 1.0.0
 */

/** * Global state to track the administrator's current selection.
 * Used to identify the context (theme/test) where operations are being performed.
 * @type {Object}
 * @property {number|null} tematicaId - Identifier for the active theme.
 * @property {number|null} testId - Identifier for the active test.
 */
window.adminState = {
    tematicaId: null,
    testId: null,
};

/**
 * Initial configuration of event listeners once the DOM is loaded.
 * Centralizes the capture of main buttons and initial view management.
 */
document.addEventListener("DOMContentLoaded", () => {
    // References to containers and buttons in the base structure
    const contentArea = document.querySelector(".admin-content-area");
    const btnCargarTematicas = document.getElementById("btn-cargar-tematicas");
    const btnAñadirPregunta = document.getElementById("btn-añadir-pregunta");

    // Selection by index of side administration buttons based on HTML order
    const botonesAdmin = document.querySelectorAll(".btnAdmin");
    const btnModificar = botonesAdmin[2];
    const btnEliminar = botonesAdmin[3];

    // --- 1. THEME EVENT ---
    // When the load button is pressed, all available categories are retrieved
    if (btnCargarTematicas) {
        btnCargarTematicas.addEventListener("click", async () => {
            // Visual loading feedback for the user
            contentArea.innerHTML =
                '<div class="text-center p-5"><div class="spinner-border text-primary"></div><p class="mt-2">Loading themes...</p></div>';
            try {
                // Asynchronous request to the themes list
                const response = await fetch("/api/tematicas");
                const tematicas = await response.json();

                // Clean and prepare the visual grid
                contentArea.innerHTML = `<div class="p-4"><h3 class="text-dark mb-4 text-center">Select a Theme</h3><div class="row g-3" id="grid-tematicas"></div></div>`;
                const grid = document.getElementById("grid-tematicas");

                // Dynamic generation of buttons for each theme found
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

    // --- 2. ADD EVENT ---
    // Verifies that a test is selected before displaying the creation form
    if (btnAñadirPregunta) {
        btnAñadirPregunta.addEventListener("click", () => {
            if (!window.adminState.testId)
                return alert("Please select a Theme and a Test first.");
            mostrarFormularioPregunta(); // Shows the empty form for insertion
        });
    }

    // --- 3. MODIFY EVENT ---
    // Allows listing existing questions to enter edit mode
    if (btnModificar) {
        btnModificar.addEventListener("click", () => {
            if (!window.adminState.testId)
                return alert("Please select a Theme and a Test first.");
            listarPreguntasParaEditar();
        });
    }

    // --- 4. DELETE EVENT ---
    // Allows listing questions for permanent deletion
    if (btnEliminar) {
        btnEliminar.addEventListener("click", () => {
            if (!window.adminState.testId)
                return alert("Please select a Theme and a Test first.");
            listarPreguntasParaEliminar();
        });
    }
});

/** * SECTION: NAVIGATION (THEMES AND TESTS)
 */

/**
 * Sets the active theme, updates the state, and triggers the loading of associated tests.
 * @param {number} id - Unique ID of the theme.
 * @param {string} nombre - Text label of the theme.
 */
async function seleccionarTematica(id, nombre) {
    window.adminState.tematicaId = id;
    const contentArea = document.querySelector(".admin-content-area");
    // Includes a back button to facilitate user navigation
    contentArea.innerHTML = `<div class="p-4"><button class="btn btn-sm btn-secondary mb-3" onclick="document.getElementById('btn-cargar-tematicas').click()">← Back</button><h3 class="text-dark mb-4 text-center">Tests in: ${nombre}</h3><div class="row g-3" id="grid-tests"></div></div>`;
    await cargarTests(id);
}

/**
 * Retrieves tests belonging to a specific theme by filtering API results.
 * @param {number} tematicaId - Reference ID to filter the list.
 */
async function cargarTests(tematicaId) {
    const grid = document.getElementById("grid-tests");
    try {
        const response = await fetch(`/api/tematicas`);
        const tematicas = await response.json();

        // Find the theme matching the selection within the themes array
        const tematicaActual = tematicas.find((t) => t.id === tematicaId);
        grid.innerHTML = "";

        // Iterate over the 'tests' property of the theme object
        tematicaActual.tests.forEach((test) => {
            const col = document.createElement("div");
            col.className = "col-12";
            col.innerHTML = `<button class="btn w-100 py-2 d-flex justify-content-between align-items-center shadow-sm mb-2" onclick="fijarTest(${test.id}, '${test.title}')" style="background-color: #f8f9fa; border: 2px solid #ff4081; color: #333;"><span class="fw-bold">${test.title}</span><span class="badge bg-dark">ID: ${test.id}</span></button>`;
            grid.appendChild(col);
        });
    } catch (e) {
        console.error("Error loading tests:", e);
    }
}

/**
 * Locks the active test in the global state and displays a confirmation message.
 * Prepares the environment for CRUD actions.
 * @param {number} id - Test ID.
 * @param {string} titulo - Test title for visual feedback.
 */
function fijarTest(id, titulo) {
    window.adminState.testId = id;
    document.querySelector(".admin-content-area").innerHTML =
        `<div class="text-center p-5"><h4 class="text-primary fw-bold text-black">Selected Test:</h4><h2 style="color: black;">${titulo}</h2><div class="alert alert-success mt-4">Ready! Now choose an action on the left.</div></div>`;
}

/** * SECTION: SINGLE FORM (CREATE / EDIT)
 */

/**
 * Injects the dynamic form HTML code into the content area.
 * Uses a map loop to generate fields for the 4 answer options.
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
                    <div class="col-8"><input type="text" class="form-control" id="opt${i}" placeholder="Option ${i}"></div>
                    <div class="col-4 d-flex align-items-center"><input type="radio" name="correcta" value="${i - 1}"> Correct</div>
                `,
                    )
                    .join("")}
            </div>
            <button class="btn btn-success w-100" id="btnGuardarAccion" onclick="guardarPregunta()">GUARDAR EN BASE DE DATOS</button>
        </div>`;
}

/** * SECTION: CRUD OPERATIONS (ADD, MODIFY, DELETE)
 */

/**
 * Collects form data and creates a new question via POST.
 * Includes empty field validation and CSRF token management for security.
 * @async
 */
async function guardarPregunta() {
    const enunciado = document.getElementById("enunciado").value;

    // Collect options into an array using ID mapping
    const opciones = [1, 2, 3, 4].map(
        (i) => document.getElementById(`opt${i}`).value,
    );

    // Identify the index of the selected correct answer
    const indexCorrecta = Array.from(
        document.getElementsByName("correcta"),
    ).findIndex((r) => r.checked);

    // Basic validation to prevent incomplete submissions
    if (!enunciado || opciones.some((o) => !o.trim()) || indexCorrecta === -1)
        return alert("Por favor, rellena todo.");

    // Structure the JSON object according to the API format
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
 * Retrieves all questions linked to the current test to allow editing.
 * Generates an interactive "list-group" style list.
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
 * Loads specific question details into the form for modification.
 * Transforms the "Save" button into an "Update" button.
 * @param {number} id - ID of the question to retrieve.
 * @async
 */
async function cargarDatosEnFormulario(id) {
    const res = await fetch(`/api/preguntas/${id}`);
    const pregunta = await res.json();
    mostrarFormularioPregunta(); // Reusing the base form creation

    // Modify header and button for edit mode
    document.querySelector("h3").innerText = "Editing Question #" + id;
    const btn = document.getElementById("btnGuardarAccion");
    btn.innerText = "UPDATE CHANGES";
    btn.className = "btn btn-warning w-100";
    btn.setAttribute("onclick", `actualizarPregunta(${id})`);

    // Populate fields with retrieved information
    document.getElementById("enunciado").value = pregunta.enunciado;
    pregunta.respuestas.forEach((r, i) => {
        document.getElementById(`opt${i + 1}`).value = r.opcion;
        if (r.is_correct)
            document.getElementsByName("correcta")[i].checked = true;
    });
}

/**
 * Sends updates for an existing question via a PUT request.
 * @param {number} id - ID of the question being updated.
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
 * Displays a list of questions with a direct delete option for each element.
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
 * Manages the physical deletion of a question from the database via DELETE.
 * Includes a confirmation window to prevent accidental loss.
 * @param {number} id - ID of the question to delete.
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
        // Update the list to reflect changes
        listarPreguntasParaEliminar();
    } else {
        alert("Error al eliminar");
    }
}

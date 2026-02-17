// Variable global para rastrear el estado del panel
window.adminState = {
    tematicaId: null,
    testId: null,
};

document.addEventListener("DOMContentLoaded", () => {
    // Referencias a elementos del DOM
    const contentArea = document.querySelector(".admin-content-area");
    const btnCargarTematicas = document.getElementById("btn-cargar-tematicas");
    const btnAñadirPregunta = document.getElementById("btn-añadir-pregunta");

    // Selectores para botones de Modificar y Eliminar (según el orden de tu HTML)
    const botonesAdmin = document.querySelectorAll(".btnAdmin");
    const btnModificar = botonesAdmin[2];
    const btnEliminar = botonesAdmin[3];

    // --- 1. EVENTO TEMÁTICA ---
    if (btnCargarTematicas) {
        btnCargarTematicas.addEventListener("click", async () => {
            contentArea.innerHTML =
                '<div class="text-center p-5"><div class="spinner-border text-primary"></div><p class="mt-2">Cargando temáticas...</p></div>';
            try {
                const response = await fetch("/api/tematicas");
                const tematicas = await response.json();
                contentArea.innerHTML = `<div class="p-4"><h3 class="text-dark mb-4 text-center">Selecciona una Temática</h3><div class="row g-3" id="grid-tematicas"></div></div>`;
                const grid = document.getElementById("grid-tematicas");
                tematicas.forEach((t) => {
                    const col = document.createElement("div");
                    col.className = "col-6 col-md-4";
                    col.innerHTML = `<button class="btn btn-outline-dark w-100 py-3 fw-bold border-2" onclick="seleccionarTematica(${t.id}, '${t.name}')" style="border-color: #d4e157; color: #98b705;">${t.name}</button>`;
                    grid.appendChild(col);
                });
            } catch (error) {
                console.error("Error cargando temáticas:", error);
            }
        });
    }

    // --- 2. EVENTO AÑADIR ---
    if (btnAñadirPregunta) {
        btnAñadirPregunta.addEventListener("click", () => {
            if (!window.adminState.testId)
                return alert("⚠️ Selecciona primero una Temática y un Test.");
            mostrarFormularioPregunta(); // Formulario limpio para añadir
        });
    }

    // --- 3. EVENTO MODIFICAR ---
    if (btnModificar) {
        btnModificar.addEventListener("click", () => {
            if (!window.adminState.testId)
                return alert("⚠️ Selecciona primero una Temática y un Test.");
            listarPreguntasParaEditar();
        });
    }

    // --- 4. EVENTO ELIMINAR ---
    if (btnEliminar) {
        btnEliminar.addEventListener("click", () => {
            if (!window.adminState.testId)
                return alert("⚠️ Selecciona primero una Temática y un Test.");
            listarPreguntasParaEliminar();
        });
    }
});

/** * SECCIÓN: NAVEGACIÓN (TEMÁTICAS Y TESTS)
 */

async function seleccionarTematica(id, nombre) {
    window.adminState.tematicaId = id;
    const contentArea = document.querySelector(".admin-content-area");
    contentArea.innerHTML = `<div class="p-4"><button class="btn btn-sm btn-secondary mb-3" onclick="document.getElementById('btn-cargar-tematicas').click()">← Volver</button><h3 class="text-dark mb-4 text-center">Tests en: ${nombre}</h3><div class="row g-3" id="grid-tests"></div></div>`;
    await cargarTests(id);
}

async function cargarTests(tematicaId) {
    const grid = document.getElementById("grid-tests");
    try {
        const response = await fetch(`/api/tematicas`);
        const tematicas = await response.json();
        const tematicaActual = tematicas.find((t) => t.id === tematicaId);
        grid.innerHTML = "";
        tematicaActual.tests.forEach((test) => {
            const col = document.createElement("div");
            col.className = "col-12";
            col.innerHTML = `<button class="btn w-100 py-2 d-flex justify-content-between align-items-center shadow-sm mb-2" onclick="fijarTest(${test.id}, '${test.title}')" style="background-color: #f8f9fa; border: 2px solid #ff4081; color: #333;"><span class="fw-bold">${test.title}</span><span class="badge bg-dark">ID: ${test.id}</span></button>`;
            grid.appendChild(col);
        });
    } catch (e) {
        console.error(e);
    }
}

function fijarTest(id, titulo) {
    window.adminState.testId = id;
    document.querySelector(".admin-content-area").innerHTML =
        `<div class="text-center p-5"><h4 class="text-primary fw-bold text-black">Test Seleccionado:</h4><h2 style="color: black;">${titulo}</h2><div class="alert alert-success mt-4">¡Listo! Ahora elige una acción a la izquierda.</div></div>`;
}

/** * SECCIÓN: FORMULARIO ÚNICO (CREAR / EDITAR)
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

/** * SECCIÓN: OPERACIONES CRUD (AÑADIR, MODIFICAR, ELIMINAR)
 */

// --- CREATE ---
async function guardarPregunta() {
    const enunciado = document.getElementById("enunciado").value;
    const opciones = [1, 2, 3, 4].map(
        (i) => document.getElementById(`opt${i}`).value,
    );
    const indexCorrecta = Array.from(
        document.getElementsByName("correcta"),
    ).findIndex((r) => r.checked);

    if (!enunciado || opciones.some((o) => !o.trim()) || indexCorrecta === -1)
        return alert("Por favor, rellena todo.");

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
        alert("✅ Pregunta creada!");
        fijarTest(window.adminState.testId, "Pregunta Guardada");
    }
}

// --- UPDATE (Listar y Cargar) ---
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

async function cargarDatosEnFormulario(id) {
    const res = await fetch(`/api/preguntas/${id}`);
    const pregunta = await res.json();
    mostrarFormularioPregunta();

    document.querySelector("h3").innerText = "Editando Pregunta #" + id;
    const btn = document.getElementById("btnGuardarAccion");
    btn.innerText = "ACTUALIZAR CAMBIOS";
    btn.className = "btn btn-warning w-100";
    btn.setAttribute("onclick", `actualizarPregunta(${id})`);

    document.getElementById("enunciado").value = pregunta.enunciado;
    pregunta.respuestas.forEach((r, i) => {
        document.getElementById(`opt${i + 1}`).value = r.opcion;
        if (r.is_correct)
            document.getElementsByName("correcta")[i].checked = true;
    });
}

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
        alert("✅ Actualizado!");
        listarPreguntasParaEditar();
    }
}

// --- DELETE (Listar y Borrar) ---
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
        alert("🗑️ Eliminada");
        listarPreguntasParaEliminar();
    } else {
        alert("❌ Error al eliminar");
    }
}

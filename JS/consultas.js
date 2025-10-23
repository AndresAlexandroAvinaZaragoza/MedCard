

// === Inicializacion de la base de datos ===
function initDB() {
  return new Promise((resolve, reject) => {
    const request = indexedDB.open("ConsultasDB", 1);

    request.onupgradeneeded = (event) => {
      const db = event.target.result;
      if (!db.objectStoreNames.contains("consultas")) {
        db.createObjectStore("consultas", { keyPath: "id", autoIncrement: true });
      }
    };

    request.onsuccess = (event) => {
      db = event.target.result;
      resolve();
    };

    request.onerror = (event) => {
      console.error("Error al abrir IndexedDB:", event);
      reject(event);
    };
  });
}

// === Guardar o actualizar una consulta ===
function guardarConsulta(consulta) {
  return new Promise((resolve, reject) => {
    const tx = db.transaction("consultas", "readwrite");
    const store = tx.objectStore("consultas");
    store.put(consulta);
    tx.oncomplete = () => resolve();
    tx.onerror = (e) => reject(e);
  });
}

// === Cargar todas las consultas ===
function cargarConsultas() {
  return new Promise((resolve, reject) => {
    const tx = db.transaction("consultas", "readonly");
    const store = tx.objectStore("consultas");
    const request = store.getAll();

    request.onsuccess = () => resolve(request.result);
    request.onerror = (e) => reject(e);
  });
}

// === Eliminar una consulta por ID ===
function eliminarConsulta(id) {
  return new Promise((resolve, reject) => {
    const tx = db.transaction("consultas", "readwrite");
    const store = tx.objectStore("consultas");
    store.delete(id);
    tx.oncomplete = () => resolve();
    tx.onerror = (e) => reject(e);
  });
}

// === Mostrar todas las consultas en pantalla ===
async function mostrarConsultas(filtro = null) {
  const lista = document.querySelector(".consultas-lista");
  let consultas = await cargarConsultas();

  // Aplicar filtro si se selecciona una especialidad
  if (filtro && filtro !== "Todas") {
    consultas = consultas.filter(c => c.especialidad === filtro);
  }

  lista.innerHTML = "";

  // Si no hay consultas registradas
  if (consultas.length === 0) {
    lista.innerHTML = `<p>No hay consultas registradas aun.</p>`;
    return;
  }

  // Crear elementos HTML para cada consulta
  consultas.forEach(c => {
    const div = document.createElement("div");
    div.className = "consulta-item";
    div.innerHTML = `
      <h3>${c.medico}</h3>
      <p><strong>Fecha:</strong> ${c.fecha}</p>
      <p><strong>Especialidad:</strong> ${c.especialidad}</p>
      <p><strong>Diagnostico:</strong> ${c.diagnostico || "No especificado"}</p>
      <p><strong>Tratamiento:</strong> ${c.tratamiento || "No especificado"}</p>
      <p><strong>Notas:</strong> ${c.notas || "Sin notas"}</p>
      <div class="acciones">
        <button class="btn-editar" data-id="${c.id}">✏️ Editar</button>
        <button class="btn-eliminar" data-id="${c.id}">🗑️ Eliminar</button>
      </div>
    `;
    lista.appendChild(div);
  });

  // --- Accion: eliminar consulta ---
  document.querySelectorAll(".btn-eliminar").forEach(btn => {
    btn.addEventListener("click", async (e) => {
      const id = Number(e.target.dataset.id);
      if (confirm("Deseas eliminar esta consulta?")) {
        await eliminarConsulta(id);
        mostrarConsultas();
      }
    });
  });

  // --- Accion: editar consulta ---
  document.querySelectorAll(".btn-editar").forEach(btn => {
    btn.addEventListener("click", async (e) => {
      const id = Number(e.target.dataset.id);
      const consultas = await cargarConsultas();
      const consulta = consultas.find(c => c.id === id);
      abrirModal(consulta);
    });
  });
}

// === Filtrar consultas por especialidad ===
document.getElementById("especialidad").addEventListener("change", (e) => {
  mostrarConsultas(e.target.value);
});

// === Manejo del modal ===
const modal = document.getElementById("modalConsulta");
const btnAbrir = document.querySelector(".btn-agregar");
const btnCerrar = document.querySelector(".cerrar");

btnAbrir.onclick = () => abrirModal();
btnCerrar.onclick = () => cerrarModal();
window.onclick = (e) => { if (e.target === modal) cerrarModal(); };

// Abre el modal, opcionalmente con datos existentes
function abrirModal(consulta = null) {
  const form = modal.querySelector("form");
  modal.style.display = "flex";
  form.reset();

  if (consulta) {
    form.dataset.id = consulta.id;
    form.querySelector("input[type='date']").value = consulta.fecha;
    form.querySelector("input[placeholder='Dr. Juan Perez']").value = consulta.medico;
    form.querySelector("select").value = consulta.especialidad;
    form.querySelector("input[placeholder='Descripcion del diagnostico']").value = consulta.diagnostico;
    form.querySelector("input[placeholder='Descripcion del tratamiento']").value = consulta.tratamiento;
    form.querySelector("textarea").value = consulta.notas;
  } else {
    delete form.dataset.id;
  }
}

// Cierra el modal
function cerrarModal() {
  modal.style.display = "none";
}

// === Guardar o actualizar una consulta desde el formulario ===
document.querySelector("#modalConsulta form").addEventListener("submit", async (e) => {
  e.preventDefault();
  const form = e.target;

  const fecha = form.querySelector("input[type='date']").value;
  const medico = form.querySelector("input[placeholder='Dr. Juan Perez']").value.trim();
  const especialidad = form.querySelector("select").value;
  const diagnostico = form.querySelector("input[placeholder='Descripcion del diagnostico']").value;
  const tratamiento = form.querySelector("input[placeholder='Descripcion del tratamiento']").value;
  const notas = form.querySelector("textarea").value;

  // Validar campos requeridos
  if (!fecha || !medico || !especialidad) {
    alert("Por favor completa los campos obligatorios.");
    return;
  }

  const nuevaConsulta = {
    id: form.dataset.id ? Number(form.dataset.id) : undefined,
    fecha,
    medico,
    especialidad,
    diagnostico,
    tratamiento,
    notas
  };

  await guardarConsulta(nuevaConsulta);
  cerrarModal();
  mostrarConsultas();
});

// === Inicializacion al cargar la pagina ===
document.addEventListener("DOMContentLoaded", async () => {
  await initDB();
  mostrarConsultas();
});

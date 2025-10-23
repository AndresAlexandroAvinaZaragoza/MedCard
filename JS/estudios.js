// estudios.js — version mejorada con IndexedDB, filtro y edicion

let db;

// === Inicializa la base de datos ===
function initDB() {
  return new Promise((resolve, reject) => {
    const request = indexedDB.open("EstudiosDB", 1);

    request.onupgradeneeded = (event) => {
      const db = event.target.result;
      if (!db.objectStoreNames.contains("estudios")) {
        db.createObjectStore("estudios", { keyPath: "id", autoIncrement: true });
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

// === Guardar o actualizar un estudio ===
function guardarEstudio(estudio) {
  return new Promise((resolve, reject) => {
    const tx = db.transaction("estudios", "readwrite");
    const store = tx.objectStore("estudios");
    store.put(estudio);
    tx.oncomplete = () => resolve();
    tx.onerror = (e) => reject(e);
  });
}

// === Cargar todos los estudios ===
function cargarEstudios() {
  return new Promise((resolve, reject) => {
    const tx = db.transaction("estudios", "readonly");
    const store = tx.objectStore("estudios");
    const request = store.getAll();
    request.onsuccess = () => resolve(request.result);
    request.onerror = (e) => reject(e);
  });
}

// === Eliminar estudio ===
function eliminarEstudio(id) {
  return new Promise((resolve, reject) => {
    const tx = db.transaction("estudios", "readwrite");
    const store = tx.objectStore("estudios");
    store.delete(id);
    tx.oncomplete = () => resolve();
    tx.onerror = (e) => reject(e);
  });
}

// === Mostrar lista de estudios ===
async function mostrarEstudios(filtro = null) {
  const content = document.querySelector(".content");
  let estudios = await cargarEstudios();

  if (filtro && filtro !== "Todos los tipos") {
    estudios = estudios.filter(e => e.tipo === filtro);
  }

  // Elimina la lista anterior si existe
  let lista = document.querySelector(".estudios-lista");
  if (lista) lista.remove();

  lista = document.createElement("div");
  lista.className = "estudios-lista";
  content.appendChild(lista);

  if (estudios.length === 0) {
    lista.innerHTML = "<p>No hay estudios registrados aun.</p>";
    return;
  }

  // Crear las tarjetas
  estudios.forEach(e => {
    const div = document.createElement("div");
    div.className = "estudio-item";
    div.innerHTML = `
      <h3>${e.nombre}</h3>
      <p><strong>Tipo:</strong> ${e.tipo}</p>
      <p><strong>Fecha:</strong> ${e.fecha}</p>
      <p><strong>Archivo:</strong> <a href="${e.archivo}" target="_blank">${e.archivoNombre}</a></p>
      <p><strong>Notas:</strong> ${e.notas || "Sin notas"}</p>
      <div class="acciones">
        <button class="btn-editar" data-id="${e.id}">✏️ Editar</button>
        <button class="btn-eliminar" data-id="${e.id}">🗑️ Eliminar</button>
      </div>
    `;
    lista.appendChild(div);
  });

  // Botones de eliminar
  document.querySelectorAll(".btn-eliminar").forEach(btn => {
    btn.addEventListener("click", async (ev) => {
      const id = Number(ev.target.dataset.id);
      if (confirm("Deseas eliminar este estudio?")) {
        await eliminarEstudio(id);
        mostrarEstudios();
      }
    });
  });

  // Botones de editar
  document.querySelectorAll(".btn-editar").forEach(btn => {
    btn.addEventListener("click", async (ev) => {
      const id = Number(ev.target.dataset.id);
      const estudios = await cargarEstudios();
      const estudio = estudios.find(e => e.id === id);
      abrirModal(estudio);
    });
  });
}

// === Filtrar estudios por tipo ===
document.getElementById("tipoEstudio").addEventListener("change", (e) => {
  mostrarEstudios(e.target.value);
});

// === Modal ===
const modal = document.getElementById("modalEstudio");
const btnAbrir = document.querySelector(".btn-upload");
const btnCerrar = document.querySelector(".cerrar");
const btnMovil = document.querySelector(".btn-movil");

btnAbrir.onclick = () => abrirModal();
btnMovil.onclick = () => abrirModal();
btnCerrar.onclick = () => cerrarModal();
window.onclick = (e) => { if (e.target === modal) cerrarModal(); };

function abrirModal(estudio = null) {
  const form = modal.querySelector("form");
  modal.style.display = "flex";
  form.reset();

  if (estudio) {
    form.dataset.id = estudio.id;
    form.querySelector("input[type='text']").value = estudio.nombre;
    form.querySelector("select").value = estudio.tipo;
    form.querySelector("input[type='date']").value = estudio.fecha;
    form.querySelector("textarea").value = estudio.notas;
  } else {
    delete form.dataset.id;
  }
}

function cerrarModal() {
  modal.style.display = "none";
}

// === Convertir archivo a base64 ===
function leerArchivo(archivo) {
  return new Promise((resolve, reject) => {
    const lector = new FileReader();
    lector.onload = () => resolve(lector.result);
    lector.onerror = (e) => reject(e);
    lector.readAsDataURL(archivo);
  });
}

// === Guardar estudio desde el formulario ===
document.querySelector("#modalEstudio form").addEventListener("submit", async (e) => {
  e.preventDefault();
  const form = e.target;

  const nombre = form.querySelector("input[type='text']").value.trim();
  const tipo = form.querySelector("select").value;
  const fecha = form.querySelector("input[type='date']").value;
  const archivoInput = form.querySelector("input[type='file']");
  const notas = form.querySelector("textarea").value.trim();

  // Validacion
  if (!nombre || !tipo || !fecha) {
    alert("Por favor completa los campos obligatorios.");
    return;
  }

  let archivoBase64 = null;
  let archivoNombre = null;

  if (archivoInput.files.length > 0) {
    const archivo = archivoInput.files[0];
    archivoBase64 = await leerArchivo(archivo);
    archivoNombre = archivo.name;
  } else if (form.dataset.id) {
    // Mantener archivo anterior si se edita sin subir nuevo
    const estudios = await cargarEstudios();
    const anterior = estudios.find(e => e.id === Number(form.dataset.id));
    archivoBase64 = anterior.archivo;
    archivoNombre = anterior.archivoNombre;
  } else {
    alert("Debes subir un archivo.");
    return;
  }

  const nuevoEstudio = {
    id: form.dataset.id ? Number(form.dataset.id) : undefined,
    nombre,
    tipo,
    fecha,
    archivo: archivoBase64,
    archivoNombre,
    notas
  };

  await guardarEstudio(nuevoEstudio);
  cerrarModal();
  mostrarEstudios();
});

// === Inicializar al cargar la pagina ===
document.addEventListener("DOMContentLoaded", async () => {
  await initDB();
  mostrarEstudios();
});

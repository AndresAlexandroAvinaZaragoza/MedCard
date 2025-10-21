// =============================
// Datos simulados iniciales
// =============================
const datosIniciales = {
  nombre: "",
  email: "",
  fechaNacimiento: "",
  telefono: "",
  tipoSangre: "",
  alergias: ""
};

// =============================
// Funciones principales
// =============================

// Cargar los datos en la vista principal
function cargarDatos() {
  const info = document.querySelector('.info-datos');
  info.innerHTML = `
    <p><strong>Nombre Completo:</strong> ${datosIniciales.nombre}</p>
    <p><strong>Correo Electrónico:</strong> ${datosIniciales.email}</p>
    <p><strong>Fecha de Nacimiento:</strong> ${datosIniciales.fechaNacimiento}</p>
    <p><strong>Teléfono:</strong> ${datosIniciales.telefono}</p>
    <p><strong>Tipo de Sangre:</strong> ${datosIniciales.tipoSangre}</p>
    <p><strong>Alergias:</strong> ${datosIniciales.alergias}</p>
  `;
}

// =============================
// Modal Editar Perfil
// =============================
const modal = document.getElementById("modalPerfil");
const btnEditar = document.querySelector(".editar");
const btnCerrar = document.querySelector(".cerrar");

btnEditar.addEventListener("click", () => {
  // Llenar campos con datos actuales
  document.getElementById("nombre").value = datosIniciales.nombre;
  document.getElementById("email").value = datosIniciales.email;
  document.getElementById("fechaNacimiento").value = datosIniciales.fechaNacimiento;
  document.getElementById("telefono").value = datosIniciales.telefono;
  document.getElementById("tipoSangre").value = datosIniciales.tipoSangre;
  document.getElementById("alergias").value = datosIniciales.alergias;

  modal.style.display = "flex"; // Mostrar el modal
});

btnCerrar.addEventListener("click", () => {
  modal.style.display = "none"; // Cerrar el modal
});

window.addEventListener("click", (e) => {
  if (e.target === modal) modal.style.display = "none";
});

// =============================
// Guardar Cambios
// =============================
document.getElementById("formPerfil").addEventListener("submit", (e) => {
  e.preventDefault();

  const nuevosDatos = {
    nombre: document.getElementById("nombre").value,
    email: document.getElementById("email").value,
    fechaNacimiento: document.getElementById("fechaNacimiento").value,
    telefono: document.getElementById("telefono").value,
    tipoSangre: document.getElementById("tipoSangre").value,
    alergias: document.getElementById("alergias").value
  };

  // Validación básica
  if (!nuevosDatos.nombre || !nuevosDatos.email) {
    alert("Nombre y correo son obligatorios.");
    return;
  }

  Object.assign(datosIniciales, nuevosDatos);
  localStorage.setItem("perfilSalud", JSON.stringify(datosIniciales));

  cargarDatos();
  modal.style.display = "none";
  alert("Perfil actualizado exitosamente.");
});

// =============================
// Inicializar
// =============================
document.addEventListener("DOMContentLoaded", () => {
  const guardados = localStorage.getItem("perfilSalud");
  if (guardados) Object.assign(datosIniciales, JSON.parse(guardados));
  cargarDatos();
});

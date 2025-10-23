// Referencias a elementos del DOM
const menuBtn = document.getElementById("menu-btn");
const sidebar = document.getElementById("sidebar");
const filtroVacuna = document.getElementById("vacuna");
const btnRegistrar = document.querySelector(".btn.blue");
const btnRecordatorio = document.querySelector(".btn.green");

// Funcion para mostrar/ocultar sidebar en movil
menuBtn.addEventListener("click", () => {
  sidebar.classList.toggle("active");
});

// Cerrar sidebar al hacer clic en algun enlace
document.querySelectorAll(".sidebar a").forEach(link => {
  link.addEventListener("click", () => sidebar.classList.remove("active"));
});

// Funcion para filtrar vacunas (aqui podrias conectar con tus datos reales)
filtroVacuna.addEventListener("change", () => {
  const valorFiltro = filtroVacuna.value;
  // Por ahora solo mostramos alerta con el filtro seleccionado
  alert(`Filtro aplicado: ${valorFiltro}`);
  // Aqui podrias actualizar la lista de vacunas en la pagina segun el filtro
});

// Evento para boton "Registrar Vacuna"
btnRegistrar.addEventListener("click", () => {
  // Aqui podrias abrir un modal o formulario para registrar vacuna
  alert("Funcion para registrar vacuna - implementar formulario");
});

// Evento para boton "Crear Recordatorio"
btnRecordatorio.addEventListener("click", () => {
  // Aqui podrias abrir un modal o formulario para crear recordatorio
  alert("Funcion para crear recordatorio - implementar formulario");
});

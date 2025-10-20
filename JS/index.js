// Datos simulados para consultas y estudios (se cargarán dinámicamente)
let consultas = [];
let estudios = [];

// Función para cargar listas dinámicas en la página
function cargarListas() {
  const consultasSection = document.querySelector('.section:nth-child(1) .section-header');
  const estudiosSection = document.querySelector('.section:nth-child(2) .section-header');

  // Agregar lista de consultas
  let consultasHTML = '<ul class="consultas-list">';
  consultas.forEach((consulta, index) => {
    consultasHTML += `<li>${consulta.fecha} - ${consulta.medico}: ${consulta.notas} <button class="btn btn-small" onclick="eliminarConsulta(${index})">Eliminar</button></li>`;
  });
  consultasHTML += '</ul>';
  consultasSection.insertAdjacentHTML('afterend', consultasHTML);

  // Agregar lista de estudios
  let estudiosHTML = '<ul class="estudios-list">';
  estudios.forEach((estudio, index) => {
    estudiosHTML += `<li>${estudio.fecha} - ${estudio.tipo}: ${estudio.resultado} <button class="btn btn-small" onclick="eliminarEstudio(${index})">Eliminar</button></li>`;
  });
  estudiosHTML += '</ul>';
  estudiosSection.insertAdjacentHTML('afterend', estudiosHTML);
}

// Función para mostrar modal de consulta
function mostrarModalConsulta() {
  const modal = document.getElementById('modal-consulta');
  modal.style.display = 'block';
  document.getElementById('form-consulta').addEventListener('submit', (e) => {
    e.preventDefault();
    const nuevaConsulta = {
      fecha: document.getElementById('consulta-fecha').value,
      medico: document.getElementById('consulta-medico').value,
      notas: document.getElementById('consulta-notas').value
    };
    if (validarConsulta(nuevaConsulta)) {
      consultas.push(nuevaConsulta);
      localStorage.setItem('consultas', JSON.stringify(consultas));
      modal.style.display = 'none';
      location.reload(); // Recargar para actualizar listas
    }
  });
  document.querySelector('#modal-consulta .close').addEventListener('click', () => modal.style.display = 'none');
}

// Función para mostrar modal de estudio
function mostrarModalEstudio() {
  const modal = document.getElementById('modal-estudio');
  modal.style.display = 'block';
  document.getElementById('form-estudio').addEventListener('submit', (e) => {
    e.preventDefault();
    const nuevoEstudio = {
      fecha: document.getElementById('estudio-fecha').value,
      tipo: document.getElementById('estudio-tipo').value,
      resultado: document.getElementById('estudio-resultado').value
    };
    if (validarEstudio(nuevoEstudio)) {
      estudios.push(nuevoEstudio);
      localStorage.setItem('estudios', JSON.stringify(estudios));
      modal.style.display = 'none';
      location.reload(); // Recargar para actualizar listas
    }
  });
  document.querySelector('#modal-estudio .close').addEventListener('click', () => modal.style.display = 'none');
}

// Función para eliminar consulta
function eliminarConsulta(index) {
  consultas.splice(index, 1);
  localStorage.setItem('consultas', JSON.stringify(consultas));
  location.reload();
}

// Función para eliminar estudio
function eliminarEstudio(index) {
  estudios.splice(index, 1);
  localStorage.setItem('estudios', JSON.stringify(estudios));
  location.reload();
}

// Validaciones mejoradas
function validarConsulta(consulta) {
  if (!consulta.fecha) {
    alert('Fecha es obligatoria.');
    return false;
  }
  if (!consulta.medico.trim()) {
    alert('Médico es obligatorio.');
    return false;
  }
  return true;
}

function validarEstudio(estudio) {
  if (!estudio.fecha) {
    alert('Fecha es obligatoria.');
    return false;
  }
  if (!estudio.tipo.trim()) {
    alert('Tipo de estudio es obligatorio.');
    return false;
  }
  return true;
}

// Interacciones en menú y cards (alineadas con tu CSS)
function agregarInteracciones() {
  // Hover en menú (usa colores de tu CSS)
  const menuItems = document.querySelectorAll('.navbar a');
  menuItems.forEach(item => {
    item.addEventListener('mouseenter', () => item.style.color = '#0082a8'); // Color de hover en tu CSS
    item.addEventListener('mouseleave', () => item.style.color = '#333'); // Color base
  });

  // Hover en cards de acciones (complementa tu CSS)
  const cards = document.querySelectorAll('.acciones-grid .card');
  cards.forEach(card => {
    card.addEventListener('mouseenter', () => {
      card.style.transform = 'scale(1.05)';
      card.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
      card.style.backgroundColor = '#d8e9eb'; // Color de hover en tu CSS
    });
    card.addEventListener('mouseleave', () => {
      card.style.transform = 'scale(1)';
      card.style.boxShadow = 'none';
      card.style.backgroundColor = '#eef3f4'; // Color base
    });
  });
}

// Cargar datos desde localStorage
function cargarDesdeLocalStorage() {
  const consultasGuardadas = localStorage.getItem('consultas');
  const estudiosGuardados = localStorage.getItem('estudios');
  if (consultasGuardadas) consultas = JSON.parse(consultasGuardadas);
  if (estudiosGuardados) estudios = JSON.parse(estudiosGuardados);
}

// Inicializar al cargar la página
document.addEventListener('DOMContentLoaded', () => {
  cargarDesdeLocalStorage();
  cargarListas();
  agregarInteracciones();

  // Eventos para botones (usa selectores precisos)
  document.querySelector('.hero-buttons .btn-primary').addEventListener('click', mostrarModalConsulta); // Registrar Consulta
  document.querySelector('.hero-buttons .btn-secondary').addEventListener('click', mostrarModalEstudio); // Subir Estudio
  document.querySelector('.section:nth-child(1) .btn-small').addEventListener('click', mostrarModalConsulta); // + Nueva Consulta
  document.querySelector('.section:nth-child(2) .btn-small').addEventListener('click', mostrarModalEstudio); // + Subir Estudio
});

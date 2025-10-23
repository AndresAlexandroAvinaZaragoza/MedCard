// Variables DOM
const btnAgregar = document.getElementById('btnAgregarRecordatorio');
const modal = document.getElementById('modalRecordatorio');
const cerrarModalBtn = document.getElementById('cerrarModal');
const form = document.getElementById('formRecordatorio');
const lista = document.getElementById('listaRecordatorios');

const filtroVacuna = document.getElementById('vacuna');
const filtroEstado = document.getElementById('estado');

// Abrir modal
btnAgregar.addEventListener('click', () => {
  modal.style.display = 'flex';
});

// Cerrar modal
cerrarModalBtn.addEventListener('click', () => {
  modal.style.display = 'none';
});

// Cerrar modal clic fuera contenido
window.addEventListener('click', (e) => {
  if(e.target === modal) {
    modal.style.display = 'none';
  }
});

// Obtener recordatorios de localStorage
function obtenerRecordatorios() {
  const data = localStorage.getItem('recordatorios');
  return data ? JSON.parse(data) : [];
}

// Guardar recordatorios en localStorage
function guardarRecordatorios(recordatorios) {
  localStorage.setItem('recordatorios', JSON.stringify(recordatorios));
}

// Mostrar recordatorios en pantalla con filtros aplicados
function mostrarRecordatorios() {
  let recordatorios = obtenerRecordatorios();

  // Filtros
  const vacunaFiltro = filtroVacuna.value;
  const estadoFiltro = filtroEstado.value;

  if (vacunaFiltro !== 'Todas las Vacunas') {
    recordatorios = recordatorios.filter(r => r.vacuna === vacunaFiltro);
  }
  if (estadoFiltro !== 'Todos los Estados') {
    recordatorios = recordatorios.filter(r => r.estado === estadoFiltro);
  }

  // Limpiar lista
  lista.innerHTML = '';

  if (recordatorios.length === 0) {
    lista.innerHTML = '<p style="text-align:center; color:#555; margin-top:2rem;">No hay recordatorios que mostrar.</p>';
    return;
  }

  // Crear elementos para cada recordatorio
  recordatorios.forEach((rec, i) => {
    const div = document.createElement('div');
    div.style = "background:#e1f0fb; padding:1rem; margin-bottom:1rem; border-radius:10px; display:flex; justify-content:space-between; align-items:center;";

    div.innerHTML = `
      <div>
        <strong>Vacuna:</strong> ${rec.vacuna} <br>
        <strong>Fecha:</strong> ${rec.fecha} <br>
        <strong>Estado:</strong> ${rec.estado}
      </div>
      <button data-index="${i}" style="background:#e14c4c; color:white; border:none; border-radius:6px; padding:0.3rem 0.7rem; cursor:pointer;">Eliminar</button>
    `;

    // Botón eliminar
    div.querySelector('button').addEventListener('click', () => {
      eliminarRecordatorio(i);
    });

    lista.appendChild(div);
  });
}

// Agregar nuevo recordatorio desde formulario
form.addEventListener('submit', (e) => {
  e.preventDefault();

  const vacuna = document.getElementById('vacunaInput').value;
  const fecha = document.getElementById('fechaInput').value;
  const estado = document.getElementById('estadoInput').value;

  if (!vacuna || !fecha || !estado) {
    alert('Por favor completa todos los campos');
    return;
  }

  const recordatorios = obtenerRecordatorios();

  recordatorios.push({ vacuna, fecha, estado });

  guardarRecordatorios(recordatorios);

  form.reset();
  modal.style.display = 'none';
  mostrarRecordatorios();
});

// Eliminar recordatorio
function eliminarRecordatorio(index) {
  const recordatorios = obtenerRecordatorios();
  recordatorios.splice(index, 1);
  guardarRecordatorios(recordatorios);
  mostrarRecordatorios();
}

// Detectar cambios en filtros para refrescar la lista
filtroVacuna.addEventListener('change', mostrarRecordatorios);
filtroEstado.addEventListener('change', mostrarRecordatorios);

// Mostrar recordatorios al cargar la página
mostrarRecordatorios();

// script.js - JavaScript para la página de Estudios y Resultados Médicos

// Función para cargar estudios desde localStorage
function cargarEstudios() {
    const estudios = JSON.parse(localStorage.getItem('estudios')) || [];
    return estudios;
}

// Función para guardar estudios en localStorage
function guardarEstudios(estudios) {
    localStorage.setItem('estudios', JSON.stringify(estudios));
}

// Función para mostrar estudios en la lista
function mostrarEstudios(estudiosFiltrados = null) {
    const content = document.querySelector('.content');
    const estudios = estudiosFiltrados || cargarEstudios();
    
    // Limpiar contenido existente después del filter-box
    const filterBox = document.querySelector('.filter-box');
    let estudiosLista = document.querySelector('.estudios-lista');
    if (!estudiosLista) {
        estudiosLista = document.createElement('div');
        estudiosLista.className = 'estudios-lista';
        content.appendChild(estudiosLista);
    } else {
        estudiosLista.innerHTML = '';
    }
    
    if (estudios.length === 0) {
        estudiosLista.innerHTML = '<p>No hay estudios registrados aún.</p>';
        return;
    }
    
    estudios.forEach((estudio, index) => {
        const divEstudio = document.createElement('div');
        divEstudio.className = 'estudio-item';
        divEstudio.innerHTML = `
            <h3>${estudio.nombre}</h3>
            <p><strong>Tipo:</strong> ${estudio.tipo}</p>
            <p><strong>Fecha:</strong> ${estudio.fecha}</p>
            <p><strong>Archivo:</strong> <a href="${estudio.archivo}" target="_blank">${estudio.archivoNombre}</a></p>
            <p><strong>Notas:</strong> ${estudio.notas || 'Ninguna'}</p>
            <button class="btn-eliminar" data-index="${index}">Eliminar</button>
        `;
        estudiosLista.appendChild(divEstudio);
    });
    
    // Agregar event listeners a los botones de eliminar
    document.querySelectorAll('.btn-eliminar').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const index = e.target.getAttribute('data-index');
            eliminarEstudio(index);
        });
    });
}

// Función para eliminar un estudio
function eliminarEstudio(index) {
    const estudios = cargarEstudios();
    estudios.splice(index, 1);
    guardarEstudios(estudios);
    mostrarEstudios();
}

// Función para filtrar estudios por tipo
function filtrarEstudios() {
    const tipoSeleccionado = document.getElementById('tipoEstudio').value;
    const estudios = cargarEstudios();
    
    if (tipoSeleccionado === 'Todos los tipos') {
        mostrarEstudios(estudios);
    } else {
        const filtrados = estudios.filter(estudio => estudio.tipo === tipoSeleccionado);
        mostrarEstudios(filtrados);
    }
}

// Event listener para el filtro
document.getElementById('tipoEstudio').addEventListener('change', filtrarEstudios);

// Event listener para el formulario del modal
document.querySelector('#modalEstudio form').addEventListener('submit', (e) => {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    const archivo = formData.get('archivo');
    
    // Simular subida de archivo (en un entorno real, subirías a un servidor)
    // Aquí guardamos una URL simulada o el nombre del archivo
    const archivoURL = URL.createObjectURL(archivo); // Para archivos locales, crea una URL temporal
    const archivoNombre = archivo.name;
    
    const nuevoEstudio = {
        nombre: formData.get('nombre'),
        tipo: formData.get('tipo'),
        fecha: formData.get('fecha'),
        archivo: archivoURL,
        archivoNombre: archivoNombre,
        notas: formData.get('notas')
    };
    
    const estudios = cargarEstudios();
    estudios.push(nuevoEstudio);
    guardarEstudios(estudios);
    
    // Cerrar modal
    document.getElementById('modalEstudio').style.display = 'none';
    
    // Limpiar formulario
    e.target.reset();
    
    // Actualizar lista
    mostrarEstudios();
});

// Event listeners para los botones de abrir modal (tanto desktop como móvil)
document.querySelector('.btn-upload').addEventListener('click', () => {
    document.getElementById('modalEstudio').style.display = 'flex';
});

document.querySelector('.btn-movil').addEventListener('click', () => {
    document.getElementById('modalEstudio').style.display = 'flex';
});

// Inicializar la página
document.addEventListener('DOMContentLoaded', () => {
    // Mostrar estudios al cargar
    mostrarEstudios();
});

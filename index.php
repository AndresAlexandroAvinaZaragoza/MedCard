<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Salud y Cuidados</title>
  <link rel="stylesheet" href="vistaIndex.css" />
  <link href="fonts/fuente1.css" rel="Fontes" />
</head>
<body>
  <header class="navbar">
    <div class="logo">
      <img src="img/logo 1.avif" alt="logo" />
      <h1>Salud y Cuidados</h1>
    </div>
    <nav>
      <ul class="menu">
        <li><a href="#">Inicio</a></li>
        <li><a href="#">Consultas</a></li>
        <li><a href="#">Estudios</a></li>
        <li><a href="#">Vacunación</a></li>
        <li><a href="#">Recordatorios</a></li>
        <li><a href="#">Perfil</a></li>
      </ul>
    </nav>
  </header>

  <section class="hero">
    <h2>Bienvenido a tu Registro de Salud Personal</h2>
    <p>Gestiona tus consultas médicas, estudios y vacunación de manera organizada y segura</p>
    <div class="hero-buttons">
      <button class="btn btn-primary">Registrar Consulta</button>
      <button class="btn btn-secondary">Subir Estudio</button>
    </div>
  </section>

  <main class="content">
    <section class="section">
      <div class="section-header">
        <h3>Consultas Médicas Recientes</h3>
        <button class="btn btn-small">+ Nueva Consulta</button>
      </div>
    </section>

    <section class="section">
      <div class="section-header">
        <h3>Estudios y Resultados Recientes</h3>
        <button class="btn btn-small">+ Subir Estudio</button>
      </div>
    </section>

    <section class="section acciones">
      <h2>Acciones Rápidas</h2>
      <div class="acciones-grid">
        <div class="card">Ver Todas las Consultas</div>
        <div class="card">Gestionar Estudios</div>
        <div class="card">Registro de Vacunación</div>
        <div class="card">Mis Recordatorios</div>
      </div>
    </section>
  </main>

  <footer>
    <p>© 2025 Salud y Cuidados — Proyecto en desarrollo</p>
  </footer>

  <!-- MODAL: Agregar Nueva Consulta -->
  <div id="modalConsulta" class="modal">
    <div class="modal-contenido">
      <span class="cerrar cerrar-consulta">&times;</span>
      <h2>Agregar Nueva Consulta</h2>

      <form>
        <label>Fecha de Consulta</label>
        <input type="date" required>

        <label>Nombre del Médico</label>
        <input type="text" placeholder="Dr. Juan Pérez" required>

        <label>Especialidad</label>
        <select required>
          <option value="">Seleccionar especialidad</option>
          <option>Medicina General</option>
          <option>Pediatría</option>
          <option>Cardiología</option>
          <option>Dermatología</option>
        </select>

        <label>Diagnóstico</label>
        <input type="text" placeholder="Descripción del diagnóstico">

        <label>Tratamiento</label>
        <input type="text" placeholder="Descripción del tratamiento">

        <label>Notas Adicionales</label>
        <textarea placeholder="Notas opcionales"></textarea>

        <button type="submit" class="btn-guardar">Guardar Consulta</button>
      </form>
    </div>
  </div>

  <!-- MODAL: Subir Estudio -->
  <div id="modalEstudio" class="modal">
    <div class="modal-contenido">
      <span class="cerrar cerrar-estudio">&times;</span>
      <h2>Subir Nuevo Estudio</h2>

      <form>
        <label>Nombre del Estudio</label>
        <input type="text" placeholder="Ej. Hemograma completo" required>

        <label>Tipo de Estudio</label>
        <select required>
          <option value="">Seleccionar tipo</option>
          <option>Análisis de sangre</option>
          <option>Rayos X</option>
          <option>Resonancia magnética</option>
          <option>Ultrasonido</option>
        </select>

        <label>Fecha del Estudio</label>
        <input type="date" required>

        <label>Archivo (PDF o Imagen)</label>
        <input type="file" accept=".pdf, .jpg, .png, .jpeg" required>

        <label>Notas Adicionales</label>
        <textarea placeholder="Información relevante sobre el estudio (opcional)"></textarea>

        <button type="submit" class="btn-guardar">Guardar Estudio</button>
      </form>
    </div>
  </div>

  <!-- SCRIPT PRINCIPAL -->
  <script>
    // --- MODAL CONSULTA ---
    const modalConsulta = document.getElementById("modalConsulta");
    const btnAbrirConsulta = document.querySelector(".btn-primary");
    const btnCerrarConsulta = document.querySelector(".cerrar-consulta");

    btnAbrirConsulta.onclick = () => {
      modalConsulta.style.display = "flex";
    };

    btnCerrarConsulta.onclick = () => {
      modalConsulta.style.display = "none";
    };

    // --- MODAL ESTUDIO ---
    const modalEstudio = document.getElementById("modalEstudio");
    const btnAbrirEstudio = document.querySelector(".btn-secondary");
    const btnCerrarEstudio = document.querySelector(".cerrar-estudio");

    btnAbrirEstudio.onclick = () => {
      modalEstudio.style.display = "flex";
    };

    btnCerrarEstudio.onclick = () => {
      modalEstudio.style.display = "none";
    };

    // --- CERRAR AL HACER CLICK FUERA ---
    window.onclick = (event) => {
      if (event.target === modalConsulta) modalConsulta.style.display = "none";
      if (event.target === modalEstudio) modalEstudio.style.display = "none";
    };
  </script>
</body>
</html>

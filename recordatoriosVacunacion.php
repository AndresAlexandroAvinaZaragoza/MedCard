<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Salud y Cuidados - Recordatorios</title>
  <link rel="stylesheet" href="vistaRecordatoriosVacunacion.css">
  <link href="fonts/fuente1.css" rel="stylesheet">
</head>
<body>

  <!-- NAVBAR -->
  <header class="navbar">
    <div class="logo">
      <img src="img/logo 1.avif" alt="Logo" class="logo-img">
      <span>Salud y Cuidados</span>
    </div>
    <button class="menu-btn" id="menu-btn">☰</button>
    <nav class="nav-links">
      <a href="sesionIniciada.php">Inicio</a>
      <a href="consultas.php">Consultas</a>
      <a href="estudios.php">Estudios</a>
      <a href="vacunacion.php">Vacunación</a>
      <a href="recordatoriosVacunacion.php">Recordatorios</a>
      <a href="perfil.php">Perfil</a>
    </nav>
  </header>

  <aside class="sidebar" id="sidebar">
    <ul class="menu">
      <li><a href="sesionIniciada.php">Inicio</a></li>
      <li><a href="consultas.php">Consultas</a></li>
      <li><a href="estudios.php">Estudios</a></li>
      <li><a href="vacunacion.php">Vacunación</a></li>
      <li><a href="recordatoriosVacunacion.php">Recordatorios</a></li>
      <li><a href="perfil.php">Perfil</a></li>
    </ul>
  </aside>

  <script>
    const menuBtn = document.getElementById("menu-btn");
    const sidebar = document.getElementById("sidebar");
    menuBtn.addEventListener("click", () => sidebar.classList.toggle("active"));
    document.querySelectorAll(".sidebar a").forEach(link => link.addEventListener("click", () => sidebar.classList.remove("active")));
  </script>

  <!-- HERO -->
  <section class="hero">
    <h1>Recordatorios de Vacunación</h1>
    <p>Gestiona y revisa tus próximas citas y recordatorios — la app te avisará antes de la cita según lo configures.</p>
  </section>

  <!-- MAIN -->
  <main class="content">
    <div class="filters">
      <div class="filter-box">
        <label for="vacuna">Filtrar por Vacuna</label>
        <select id="vacuna">
          <option>Todas las Vacunas</option>
          <option>COVID-19</option>
          <option>Influenza</option>
          <option>Tétanos</option>
          <option>Hepatitis B</option>
        </select>
      </div>

      <div class="filter-box">
        <label for="estado">Filtrar por Estado</label>
        <select id="estado">
          <option>Todos los Estados</option>
          <option>Pendiente</option>
          <option>Completado</option>
          <option>Retrasado</option>
        </select>
      </div>
    </div>

    <h2 class="subtitle">Tus Recordatorios</h2>

    <div style="display:flex; gap:8px; justify-content:center; margin:1rem 0; flex-wrap:wrap;">
      <button id="btnAgregarRecordatorio" class="primary-btn">+ Agregar Recordatorio</button>
      <button id="btnPedirPermiso" class="primary-btn">Pedir permiso notificación</button>
      <button id="btnExportar" class="primary-btn">Exportar</button>
      <button id="btnImportar" class="primary-btn">Importar</button>
      <input type="file" id="fileImport" accept="application/json" style="display:none;">
    </div>

    <div id="listaRecordatorios" style="margin-top:1rem;"></div>
  </main>

  <!-- Modal para crear/editar (incluye campo "Avisar X min antes") -->
  <div id="modalRecordatorio" class="modal" style="display:none;">
    <div class="modal-content">
      <button id="cerrarModal" class="close-btn">&times;</button>
      <h3 id="modalTitle">Nuevo Recordatorio</h3>
      <form id="formRecordatorio">
        <label for="vacunaInput">Vacuna</label>
        <select id="vacunaInput" required>
          <option value="">Selecciona</option>
          <option>COVID-19</option>
          <option>Influenza</option>
          <option>Tétanos</option>
          <option>Hepatitis B</option>
        </select>

        <label for="fechaInput">Fecha y hora</label>
        <input id="fechaInput" type="datetime-local" required>

        <label for="avisarInput">Avisar antes (minutos)</label>
        <select id="avisarInput" required>
          <option value="0">Al momento</option>
          <option value="5">5 minutos antes</option>
          <option value="15">15 minutos antes</option>
          <option value="30">30 minutos antes</option>
          <option value="60">1 hora antes</option>
          <option value="1440">1 día antes</option>
        </select>

        <label for="estadoInput">Estado</label>
        <select id="estadoInput" required>
          <option value="">Selecciona</option>
          <option>Pendiente</option>
          <option>Completado</option>
          <option>Retrasado</option>
        </select>

        <div style="margin-top:12px; display:flex; gap:8px; justify-content:flex-end;">
          <button type="button" id="cerrarModalBtn2">Cancelar</button>
          <button type="submit" class="primary-btn">Guardar</button>
        </div>
      </form>
    </div>
  </div>

  <div id="toast" class="toast" style="display:none;"></div>

  <script src="JS/recordatorioVacunacon.js"></script>
</body>
</html>

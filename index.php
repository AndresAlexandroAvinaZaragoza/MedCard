<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>MedCard — Registro de Salud</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>
  <header class="site-header">
    <div class="container header-inner">
      <div class="brand">
        <img src="logo-placeholder.png" alt="MedCard" class="logo" />
        <h1>MedCard</h1>
      </div>
      <nav class="nav">
        <a href="#">Inicio</a>
        <a href="#">Consultas</a>
        <a href="#">Estudios</a>
        <a href="#">Vacunación</a>
        <a href="#">Recordatorios</a>
        <a href="#">Perfil</a>
      </nav>
    </div>
  </header>

  <main>
    <section class="hero">
      <div class="container hero-inner">
        <h2>Bienvenido a tu Registro de Salud Personal</h2>
        <p>Gestiona tus consultas médicas, estudios y vacunación de manera organizada y segura</p>
        <div class="hero-actions">
          <button id="openConsultaBtn" class="btn primary">Registrar Consulta</button>
          <button id="openEstudioBtn" class="btn outline">Subir Estudio</button>
        </div>
      </div>
    </section>

    <section class="container dashboard">
      <div class="section-head">
        <h3>Consultas Médicas Recientes</h3>
        <button id="openConsultaBtnTop" class="btn small">+ Nueva Consulta</button>
      </div>

      <div class="cards-grid" id="consultasGrid">
        <!-- Ejemplo de tarjeta -->
        <article class="card">
          <h4>Cardiología</h4>
          <p class="med">Dr. María Rodríguez</p>
          <p class="date">15 de enero, 2025</p>
          <p class="note">Hipertensión controlada</p>
          <button class="btn full ver-detalles">Ver Detalles</button>
        </article>
        <!-- más tarjetas vendrán dinámicamente -->
      </div>

      <div class="section-head mt-lg">
        <h3>Estudios y Resultados Recientes</h3>
        <button id="openEstudioBtnTop" class="btn small outline">+ Subir Estudio</button>
      </div>

      <div class="cards-grid" id="estudiosGrid">
        <article class="card">
          <h4>Análisis de Sangre Completo</h4>
          <p class="med">Laboratorio</p>
          <p class="date">10 de enero, 2025</p>
          <button class="btn full ver-doc">Ver Documento</button>
        </article>
      </div>

      <div class="quick-actions">
        <h4>Acciones Rápidas</h4>
        <div class="quick-grid">
          <button class="box">Ver Todas las Consultas</button>
          <button class="box">Gestionar Estudios</button>
          <button class="box">Registro de Vacunación</button>
          <button class="box">Mis Recordatorios</button>
        </div>
      </div>
    </section>
  </main>

  <!-- MODAL Registrar Consulta -->
  <div class="modal" id="modalConsulta" aria-hidden="true">
    <div class="modal-content">
      <button class="modal-close" data-close>&times;</button>
      <h3>Registrar Consulta</h3>
      <form id="formConsulta">
        <label>Especialidad
          <input name="especialidad" required />
        </label>
        <label>Médico
          <input name="medico" required />
        </label>
        <label>Fecha
          <input type="date" name="fecha" required />
        </label>
        <label>Observaciones
          <textarea name="observaciones" rows="4"></textarea>
        </label>
        <div class="modal-actions">
          <button type="submit" class="btn primary">Guardar</button>
          <button type="button" class="btn outline" data-close>Cancelar</button>
        </div>
      </form>
    </div>
  </div>

  <!-- MODAL Subir Estudio -->
  <div class="modal" id="modalEstudio" aria-hidden="true">
    <div class="modal-content">
      <button class="modal-close" data-close>&times;</button>
      <h3>Subir Estudio / Resultado</h3>
      <form id="formEstudio" enctype="multipart/form-data">
        <label>Título
          <input name="titulo" required />
        </label>
        <label>Institución
          <input name="institucion" />
        </label>
        <label>Fecha
          <input type="date" name="fecha" required />
        </label>
        <label>Archivo (PDF/Imagen)
          <input type="file" name="archivo" accept=".pdf,image/*" />
        </label>
        <div class="modal-actions">
          <button type="submit" class="btn primary">Subir</button>
          <button type="button" class="btn outline" data-close>Cancelar</button>
        </div>
      </form>
    </div>
  </div>

  <script src="app.js"></script>
</body>
</html>

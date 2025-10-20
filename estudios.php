<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Salud y Cuidados - Estudios</title>
  <link rel="stylesheet" href="vistaEstudios.css">
  <link href="fonts/fuente1.css" rel="Fontes" />
</head>
<body>
  <header class="navbar">
    <div class="logo">
      <img src="img/logo 1.avif" alt="Logo" class="logo-img">
      <span>Salud y Cuidados</span>
    </div>
    <nav class="menu">
      <a href="#">Inicio</a>
      <a href="#">Consultas</a>
      <a href="#" class="active">Estudios</a>
      <a href="#">Vacunación</a>
      <a href="#">Recordatorios</a>
      <a href="#">Perfil</a>
    </nav>
  </header>

  <section class="hero">
    <h1>Estudios y Resultados Médicos</h1>
    <p>Gestiona y revisa todos tus documentos médicos, resultados de laboratorio y estudios en un solo lugar seguro</p>
  </section>

  <main class="content">
    <div class="content-header">
      <h2>Mis Estudios</h2>
      <button class="btn-upload">
        <i class="icon">📤</i>   Subir Nuevo Estudio
      </button>
    </div>
    <p class="subtext">Organiza y accede a tus documentos médicos cuando los necesites</p>

    <div class="filter-box">
      <label for="tipoEstudio">Filtrar por Tipo de Estudio</label>
      <select id="tipoEstudio">
        <option>Todos los tipos</option>
        <option>Análisis de sangre</option>
        <option>Rayos X</option>
        <option>Resonancia magnética</option>
        <option>Ultrasonido</option>
      </select>
    </div>
  </main>

  
  <!-- MODAL Para subir Estudios-->
  <div id="modalEstudio" class="modal">
    <div class="modal-contenido">
      <span class="cerrar">&times;</span>
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

  <!-- SCRIPT -->
  <script>
    const modal = document.getElementById("modalEstudio");
    const btnAbrir = document.querySelector(".btn-upload");
    const btnCerrar = document.querySelector(".cerrar");

    btnAbrir.onclick = () => {
      modal.style.display = "flex";
    };

    btnCerrar.onclick = () => {
      modal.style.display = "none";
    };

    window.onclick = (event) => {
      if (event.target === modal) {
        modal.style.display = "none";
      }
    };
  </script>
</body>
</html>


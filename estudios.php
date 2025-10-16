<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Salud y Cuidados - Estudios</title>
  <link rel="stylesheet" href="vistaEstudios.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
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
        <i class="icon">📤</i> Subir Nuevo Estudio
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
</body>
</html>


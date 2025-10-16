<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Mi Perfil de Salud</title>
  <link rel="stylesheet" href="vistaPerfil.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
  <header class="navbar">
    <div class="logo">
      <img src="img/logo 1.avif" alt="logo">
      <span>Salud y Cuidados</span>
    </div>
    <nav>
      <a href="http://localhost/CardMed/index.php#">Inicio</a>
      <a href="#">Consultas</a>
      <a href="#">Estudios</a>
      <a href="#">Vacunación</a>
      <a href="#">Recordatorios</a>
      <a href="#" class="active">Perfil</a>
    </nav>
  </header>

  <section class="perfil-header">
    <div class="perfil-img">
      <img src="https://cdn.pixabay.com/photo/2017/08/06/22/01/doctor-2593809_960_720.jpg" alt="foto perfil">
    </div>
    <h1>Mi Perfil de Salud</h1>
    <p>Gestiona tu información personal y datos de salud</p>
  </section>

  <main class="perfil-contenido">
    <section class="info-personal">
      <div class="info-header">
        <h2>Información Personal</h2>
        <button class="editar">Editar Perfil</button>
      </div>

      <div class="info-datos">
        <p><strong>Nombre Completo:</strong></p>
        <p><strong>Correo Electrónico:</strong></p>
        <p><strong>Fecha de Nacimiento:</strong></p>
        <p><strong>Teléfono:</strong></p>
        <p><strong>Tipo de Sangre:</strong></p>
        <p><strong>Alergias:</strong></p>
      </div>
    </section>

    <section class="resumen-salud">
      <h2>Resumen de Salud</h2>
      <div class="resumen-cards">
        <div class="card">
          <i class="fas fa-stethoscope"></i>
          <h3>12</h3>
          <p>Consultas</p>
        </div>
        <div class="card">
          <i class="fas fa-file-medical"></i>
          <h3>8</h3>
          <p>Estudios</p>
        </div>
        <div class="card">
          <i class="fas fa-syringe"></i>
          <h3>15</h3>
          <p>Vacunas</p>
        </div>
      </div>
    </section>
  </main>

  <footer>
    <p>© 2025 Salud y Cuidados</p>
  </footer>

  <script src="https://kit.fontawesome.com/a2d9a67e54.js" crossorigin="anonymous"></script>
</body>
</html>

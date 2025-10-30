<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <!-- Botón hamburguesa (solo visible en móvil) -->
    <button class="menu-btn" id="menu-btn">☰</button>

    <!-- Menú de navegación normal (visible en PC) -->
    <nav class="nav-links">
      <a href="sesionIniciada.php">Inicio</a>
      <a href="consultas.php">Consultas</a>
      <a href="estudios.php">Estudios</a>
      <a href="vacunacion.php">Vacunación</a>
      <a href="recordatoriosVacunacion.php">Recordatorios</a>
      <a href="perfil.php">Perfil</a>
    </nav>
  </header>

  <!-- Sidebar (solo visible en móvil cuando se abre) -->
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

    menuBtn.addEventListener("click", () => {
      sidebar.classList.toggle("active");
    });

    // Cierra el menú al hacer clic en un enlace (en móvil)
    document.querySelectorAll(".sidebar a").forEach(link => {
      link.addEventListener("click", () => sidebar.classList.remove("active"));
    });
  </script>


  <!-- HERO -->
  <section class="hero">
    <h1>Recordatorios de Vacunación</h1>
    <p>Gestiona y revisa tus próximos recordatorios de vacunación para mantener tu esquema actualizado.</p>
  </section>

  <!-- MAIN CONTENT -->
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
  </main>
  
  <script src="JS/recordatorioVacunacon.js"></script>

</body>
</html>

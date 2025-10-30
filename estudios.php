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


  <section class="hero">
    <h1>Estudios y Resultados Médicos</h1>
    <p>Gestiona y revisa todos tus documentos médicos, resultados de laboratorio y estudios en un solo lugar seguro</p>
  </section>

  <main class="content">
    <div class="content-header">
      <h2>Mis Estudios</h2>
      <button class="btn-upload"><i class="icon">📤</i>   Subir Nuevo Estudio</button>
    </div>
    <p class="subtext">Organiza y accede a tus documentos médicos cuando los necesites</p>
    
    <!--Boton Para Movil-->
    <button class="btn-movil"><i class="icon">📤</i>   Subir Nuevo Estudio</button>

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

  <footer>
    <p>© 2025 Salud y Cuidados — Proyecto en desarrollo</p>
  </footer>

  <!-- MODAL Para subir Estudios-->
  <div id="modalEstudio" class="modal">
    <div class="modal-contenido">
      <span class="cerrar">&times;</span>
      <h2>Subir Nuevo Estudio</h2>

      <form>
        <label>Nombre del Estudio</label>
        <input type="text" id="nombre-estudio" name="nombre-estudio" placeholder="Ej. Hemograma completo" required>

        <label>Tipo de Estudio</label>
        <select id="tipo-estudio" name="tipo-estudio" required>
          <option value="">Seleccionar tipo</option>
          <option>Análisis de sangre</option>
          <option>Rayos X</option>
          <option>Resonancia magnética</option>
          <option>Ultrasonido</option>
        </select>

        <label>Fecha del Estudio</label>
        <input type="date" id="fecha-estudio" name="fecha-estudio" required>

        <label>Archivo (PDF o Imagen)</label>
        <input type="file" accept=".pdf, .jpg, .png, .jpeg" id="archivo" name="archivo" required>

        <label>Notas Adicionales</label>
        <textarea id="notas-adicionales" name="notas-adicionales"  placeholder="Información relevante sobre el estudio (opcional)"></textarea>

        <button type="submit" class="btn-guardar" name="btnEstudio">Guardar Estudio</button>
      </form>
    </div>
  </div>

  
  <?php
    include 'conectar.php';
    if(isset($_POST['btnEstudio'])){
        $nombre_estudio = $_POST['nombre-estudio'];
        $tipo_estudio = $_POST['tipo-estudio'];
        $fecha_estudio = $_POST['fecha-estudio'];

        //NOMBRE Y RUTA DEL ARCHIVO SUBIDO
        $nombre_archivo = $_FILES['archivo']['name'];
        $ruta_archivo = $_FILES['archivo']['tmp_name'];
        
        $destino = "../archivo/" . $nombre_archivo;
        $base_datos = "archivo/" . $nombre_archivo;
        move_uploaded_file($ruta_archivo, $destino);

        $notas_adicionales = $_POST['notas-adicionales'];

        try {
            $sql = "INSERT INTO estudios (nombre_estudio, tipo_estudio, 
                                fecha_estudio, notas_adicionales, direccion_archivo) 
                    VALUES (:nombre_estudio, :tipo_estudio, 
                              :fecha_estudio, :notas_adicionales, :base_datos)";
            $stmt = $consulta->prepare($sql);
            $stmt->execute([
                ':nombre_estudio' => $nombre_estudio,
                ':tipo_estudio' => $tipo_estudio,
                ':fecha_estudio' => $fecha_estudio,
                ':notas_adicionales' => $notas_adicionales,
                ':base_datos' => $base_datos
            ]);
            echo "<script>alert('Estudio subido exitosamente.');</script>";
        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
        }
    }
  ?>

  <!-- SCRIPT -->
  <script>
    const modal = document.getElementById("modalEstudio");
    const btnAbrir = document.querySelectorAll(".btn-upload, .btn-movil");
    const btnCerrar = document.querySelector(".cerrar");

  // Abre el modal desde cualquiera de los dos botones
  btnAbrir.forEach(boton => {
    boton.addEventListener("click", () => {
      modal.style.display = "flex";
    });
  });

  // Cerrar modal al presionar la X
  btnCerrar.onclick = () => {
    modal.style.display = "none";
  };

  // Cerrar modal al hacer clic fuera
  window.onclick = (event) => {
    if (event.target === modal) {
      modal.style.display = "none";
    }
  };
  </script>
  <script src="JS/estudios.js"></script>
</body>
</html>


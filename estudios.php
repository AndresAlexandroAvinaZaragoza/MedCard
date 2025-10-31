<?php
  if (session_status() === PHP_SESSION_NONE) {
      session_start();
  }
?>


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

    <section class="consultas-lista">
      <?php
       // Conexión a la base de datos para obtener Y mostrar los estudios
        include 'conectar.php';

        try {
            $correo_usuario = $_SESSION['email']; // Obtener el correo del usuario logueado

            $sql = "SELECT * FROM estudios WHERE id_usuario = :id_usuario ORDER BY fecha_estudio DESC";
            $stmt = $consulta->prepare($sql);
            $stmt->execute([':id_usuario' => $correo_usuario]);

            if ($stmt->rowCount() > 0) {
                echo '<div class="estudios-grid">';
                while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '
                    <div class="tarjeta-estudio"
                        data-id="' . htmlspecialchars($fila["id_estudio"]) . '"
                        data-nombre="' . htmlspecialchars($fila["nombre_estudio"]) . '"
                        data-tipo="' . htmlspecialchars($fila["tipo_estudio"]) . '"
                        data-fecha="' . htmlspecialchars($fila["fecha_estudio"]) . '"
                        data-notas="' . htmlspecialchars($fila["notas_adicionales"]) . '"
                        data-archivo="' . htmlspecialchars($fila["direccion_archivo"]) . '">
                        
                        <div class="tarjeta-header">
                            <h4>' . htmlspecialchars($fila["tipo_estudio"]) . '</h4>
                            <span class="icono">📎</span>
                        </div>
                        <p><strong>Nombre:</strong> ' . htmlspecialchars($fila["nombre_estudio"]) . '</p>
                        <p><strong>Fecha:</strong> ' . date("M d, Y", strtotime($fila["fecha_estudio"])) . '</p>
                        <button class="btn-detalles-estudio">Ver Detalles</button>
                    </div>';
                }
                echo '</div>';
            } else {
                echo "<p>No hay estudios registrados aún.</p>";
            }
        } catch (PDOException $e) {
            echo "Error al cargar estudios: " . $e->getMessage();
        }
      ?>
    </section>

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

    <!-- MODAL DETALLES ESTUDIO -->
    <div id="modalDetallesEstudio" class="modal">
      <div class="modal-contenido">
        <span class="cerrar cerrar-detalle-estudio">&times;</span>
        <h2>Detalles del Estudio</h2>

        <p><strong>Nombre:</strong> <span id="est-nombre"></span></p>
        <p><strong>Tipo:</strong> <span id="est-tipo"></span></p>
        <p><strong>Fecha:</strong> <span id="est-fecha"></span></p>
        <p><strong>Notas:</strong> <span id="est-notas"></span></p>
        <p><strong>Archivo:</strong> 
          <a id="est-archivo" href="#" target="_blank">Ver archivo adjunto</a>
        </p>
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
        $correo_usuario = $_SESSION['email']; // ✅ Obtener el correo del usuario desde la sesión
        
        try {
            $sql = "INSERT INTO estudios (id_usuario, nombre_estudio, tipo_estudio, 
                                fecha_estudio, notas_adicionales, direccion_archivo) 
                    VALUES (:id_usuario, :nombre_estudio, :tipo_estudio, 
                              :fecha_estudio, :notas_adicionales, :base_datos)";
            $stmt = $consulta->prepare($sql);
            $stmt->execute([
                ':id_usuario' => $correo_usuario, // ✅ Usar el correo del usuario para relacionar el estudio
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

  <script>
    // SCRIPT MODAL DETALLES ESTUDIO
    const modalDetallesEstudio = document.getElementById("modalDetallesEstudio");
    const cerrarDetalleEstudio = document.querySelector(".cerrar-detalle-estudio");

    document.addEventListener("click", function (e) {
      if (e.target.classList.contains("btn-detalles-estudio")) {
        const card = e.target.closest(".tarjeta-estudio");

        // Llenar los datos del modal
        document.getElementById("est-nombre").textContent = card.dataset.nombre;
        document.getElementById("est-tipo").textContent = card.dataset.tipo;
        document.getElementById("est-fecha").textContent = card.dataset.fecha;
        document.getElementById("est-notas").textContent = card.dataset.notas || "—";

        // Enlace del archivo
        const linkArchivo = document.getElementById("est-archivo");
        linkArchivo.href = card.dataset.archivo;
        linkArchivo.textContent = "Ver archivo";

        modalDetallesEstudio.style.display = "flex";
      }
    });

    cerrarDetalleEstudio.onclick = () => {
      modalDetallesEstudio.style.display = "none";
    };

    window.onclick = (event) => {
      if (event.target === modalDetallesEstudio)
        modalDetallesEstudio.style.display = "none";
    };
  </script>

  <script src="JS/estudios.js"></script>
</body>
</html>


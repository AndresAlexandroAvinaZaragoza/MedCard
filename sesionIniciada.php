<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Salud y Cuidados</title>
  <link rel="stylesheet" href="vistaSesionIniciada.css" />
  <link href="fonts/fuente1.css" rel="Fontes" />
</head>
<body>
  <!-- Navbar superior -->
  <header class="navbar">
    <div class="logo">
      <img src="img/logo 1.avif" alt="logo" />
      <h1>Salud y Cuidados</h1>
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

      <?php
      // Conexión a la base de datos para obtener Y mostrar las consultas
        include 'conectar.php';

        try {
            $sql = "SELECT * FROM consultas ORDER BY fecha_consulta DESC";
            $stmt = $consulta->query($sql);

            if ($stmt->rowCount() > 0) {
                echo '<div class="consultas-grid">';
                while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '
                    <div class="tarjeta-consulta" 
                        data-id="' . htmlspecialchars($fila["id_consulta"]) . '"
                        data-especialidad="' . htmlspecialchars($fila["especialidad"]) . '"
                        data-medico="' . htmlspecialchars($fila["nombre_medico"]) . '"
                        data-fecha="' . htmlspecialchars($fila["fecha_consulta"]) . '"
                        data-diagnostico="' . htmlspecialchars($fila["diagnostico"]) . '"
                        data-tratamiento="' . htmlspecialchars($fila["tratamiento"]) . '"
                        data-notas="' . htmlspecialchars($fila["notas_adicionales"]) . '">
                        
                        <div class="tarjeta-header">
                            <h4>' . htmlspecialchars($fila["especialidad"]) . '</h4>
                            <span class="icono">♡</span>
                        </div>
                        <p><strong>Dr.</strong> ' . htmlspecialchars($fila["nombre_medico"]) . '</p>
                        <p><strong>Fecha:</strong> ' . date("M d, Y h:i a", strtotime($fila["fecha_consulta"])) . '</p>
                        <p><strong>Diagnóstico:</strong> ' . htmlspecialchars($fila["diagnostico"]) . '</p>
                        <button class="btn-detalles">Ver Detalles</button>
                    </div>';
                }
                echo '</div>';
            } else {
                echo "<p>No hay consultas registradas aún.</p>";
            }
        } catch (PDOException $e) {
            echo "Error al cargar consultas: " . $e->getMessage();
        }
      ?>
    </section>

    <section class="section">
      <div class="section-header">
        <h3>Estudios y Resultados Recientes</h3>
        <button class="btn btn-small">+ Subir Estudio</button>
      </div>

      <?php
       // Conexión a la base de datos para obtener Y mostrar los estudios
        include 'conectar.php';

        try {
            $sql = "SELECT * FROM estudios ORDER BY fecha_estudio DESC";
            $stmt = $consulta->query($sql);

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
        <input type="date" id="fecha-consulta" name="fecha-consulta" required>

        <label>Nombre del Médico</label>
        <input type="text" id="nombre-medico" name="nombre-medico" placeholder="Dr. Juan Pérez" required>

        <label>Especialidad</label>
        <select id="especialidad" name="especialidad"  required>
          <option value="">Seleccionar especialidad</option>
          <option>Medicina General</option>
          <option>Pediatría</option>
          <option>Cardiología</option>
          <option>Dermatología</option>
        </select>

        <label>Diagnóstico</label>
        <input type="text" id="diagnostico" name="diagnostico" placeholder="Descripción del diagnóstico">

        <label>Tratamiento</label>
        <input type="text" id="tratamiento" name="tratamiento"  placeholder="Descripción del tratamiento">

        <label>Notas Adicionales</label>
        <textarea id="notas-adicionales" name="notas-adicionales"  placeholder="Notas opcionales"></textarea>

        <button type="submit" class="btn-guardar" name="btnConsulta">Guardar Consulta</button>
      </form>
    </div>
  </div>

    <?php
      include 'conectar.php';
      if(isset($_POST['btnConsulta'])){
          $fecha_consulta = $_POST['fecha-consulta'];
          $nombre_medico = $_POST['nombre-medico'];
          $especialidad = $_POST['especialidad'];
          $diagnostico = $_POST['diagnostico'];
          $tratamiento = $_POST['tratamiento'];
          $notas_adicionales = $_POST['notas-adicionales'];

          try {
              $sql = "INSERT INTO consultas (fecha_consulta, nombre_medico, especialidad, diagnostico, tratamiento, notas_adicionales) 
                      VALUES (:fecha_consulta, :nombre_medico, :especialidad, :diagnostico, :tratamiento, :notas_adicionales)";
              $stmt = $consulta->prepare($sql);
              $stmt->execute([
                  ':fecha_consulta' => $fecha_consulta,
                  ':nombre_medico' => $nombre_medico,
                  ':especialidad' => $especialidad,
                  ':diagnostico' => $diagnostico,
                  ':tratamiento' => $tratamiento,
                  ':notas_adicionales' => $notas_adicionales
              ]);
              echo "<script>alert('Consulta registrada exitosamente.');</script>";
          } catch (PDOException $e) {
              echo "ERROR: " . $e->getMessage();
          }
      }
    
    ?>



  <!-- MODAL: Subir Estudio -->
  <div id="modalEstudio" class="modal">
    <div class="modal-contenido">
      <span class="cerrar cerrar-estudio">&times;</span>
      <h2>Subir Nuevo Estudio</h2>

      <form>
        <label>Nombre del Estudio</label>
        <input type="text" id="nombre-estudio" name="nombre-estudio" placeholder="Ej. Hemograma completo" required>

        <label>Tipo de Estudio</label>
        <select id="tipo-estudio" name="tipo-estudio"  required>
          <option value="">Seleccionar tipo</option>
          <option>Análisis de sangre</option>
          <option>Rayos X</option>
          <option>Resonancia magnética</option>
          <option>Ultrasonido</option>
        </select>

        <label>Fecha del Estudio</label>
        <input type="date" id="fecha-estudio" name="fecha-estudio"  required>

        <label>Archivo (PDF o Imagen)</label>
        <input type="file" accept=".pdf, .jpg, .png, .jpeg" id="archivo" name="archivo" required>

        <label>Notas Adicionales</label>
        <textarea id="notas-adicionales" name="notas-adicionales" placeholder="Información relevante sobre el estudio (opcional)"></textarea>

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

        <!-- MODAL DETALLES CONSULTA -->
    <div id="modalDetalles" class="modal">
      <div class="modal-contenido">
        <span class="cerrar cerrar-detalles">&times;</span>
        <h2>Detalles de la Consulta</h2>

        <p><strong>Especialidad:</strong> <span id="det-especialidad"></span></p>
        <p><strong>Médico:</strong> <span id="det-medico"></span></p>
        <p><strong>Fecha:</strong> <span id="det-fecha"></span></p>
        <p><strong>Diagnóstico:</strong> <span id="det-diagnostico"></span></p>
        <p><strong>Tratamiento:</strong> <span id="det-tratamiento"></span></p>
        <p><strong>Notas:</strong> <span id="det-notas"></span></p>
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

  <script>
    // SCRIPT MODAL DETALLES DE CONSULTA
    const modalDetalles = document.getElementById("modalDetalles");
    const cerrarDetalles = document.querySelector(".cerrar-detalles");

    document.addEventListener("click", function (e) {
      if (e.target.classList.contains("btn-detalles")) {
        const card = e.target.closest(".tarjeta-consulta");

        // Tomar los valores del data-atributo
        document.getElementById("det-especialidad").textContent = card.dataset.especialidad;
        document.getElementById("det-medico").textContent = card.dataset.medico;
        document.getElementById("det-fecha").textContent = card.dataset.fecha;
        document.getElementById("det-diagnostico").textContent = card.dataset.diagnostico || "—";
        document.getElementById("det-tratamiento").textContent = card.dataset.tratamiento || "—";
        document.getElementById("det-notas").textContent = card.dataset.notas || "—";

        modalDetalles.style.display = "flex";
      }
    });

    cerrarDetalles.onclick = () => {
      modalDetalles.style.display = "none";
    };

    window.onclick = (event) => {
      if (event.target === modalDetalles) modalDetalles.style.display = "none";
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


</body>
</html>

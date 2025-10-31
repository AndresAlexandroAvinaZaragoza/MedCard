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
  <title>Salud y Cuidados - Vacunación</title>
  <link rel="stylesheet" href="vistaVacunacion.css">
  <link href="fonts/fuente1.css" rel="stylesheet">
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
    <h1>Control de Vacunación</h1>
    <p>Mantén actualizado tu esquema de vacunación y nunca pierdas una dosis importante</p>
  </section>

  <main class="content">
    <div class="content-top">
      <div class="filter-box">
        <label for="vacuna">Filtrar por vacuna</label>
        <select id="vacuna">
          <option>Todas las vacunas</option>
          <option>COVID-19</option>
          <option>Influenza</option>
          <option>Hepatitis B</option>
          <option>Tétanos</option>
        </select>
      </div>

      <div class="buttons">
        <button class="btn blue btn-agregarVacuna">
          💉 Registrar Vacuna
        </button>
        <button class="btn green btn-agregarRecordatorio">
          🔔 Crear Recordatorio
        </button>
      </div>
    </div>

    <!-- ✅ Sección de tarjetas -->
    <section class="consultas-lista grid-vacunas">
      <?php
        include 'conectar.php';
        $correo_usuario = $_SESSION['email']; // Obtener el correo del usuario logueado

        try{
          // Filtrar vacunas por el usuario logueado
          $sql = "SELECT * FROM vacunas WHERE id_usuario = :id_usuario ORDER BY fecha_administracion DESC";
          $stmt = $consulta->prepare($sql);
          $stmt->execute([':id_usuario' => $correo_usuario]);

          if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              echo "
                <div class='card'>
                  <div class='card-content'>
                    <h3>{$row['nombre_vacuna']}</h3>
                    <p><strong>Fecha:</strong> {$row['fecha_administracion']}</p>
                    <p><strong>Proveedor:</strong> {$row['proveedor_salud']}</p>
                    <button class='btn-ver' onclick=\"verDetalles('{$row['nombre_vacuna']}', '{$row['fecha_administracion']}', '{$row['numero_lote']}', '{$row['proveedor_salud']}', '{$row['notas_adicionales']}')\">Ver detalles</button>
                  </div>
                </div>
              ";
            }
          }else {
            echo "<p class='no-vacunas'>No hay vacunas registradas.</p>";
          }          
        }catch (PDOException $e) {
            echo "Error al cargar estudios: " . $e->getMessage();
        }
      ?>
    </section>

  </main>

  <!-- Modal: Agregar Nueva Vacuna -->
  <div id="modalVacuna" class="modal">
    <div class="modal-contenido">
      <span class="cerrar cerrarVacuna">&times;</span>
      <h2>Registrar Vacuna</h2>

      <form method="POST">
        <label for="vacuna">Nombre de la Vacuna</label>
        <input list="listaVacunas" id="vacuna" name="vacuna" placeholder="Seleccione o escriba una vacuna" required />
        <datalist id="listaVacunas">
          <option value="COVID-19">
          <option value="Influenza">
          <option value="Hepatitis B">
          <option value="Tétanos">
          <option value="Sarampión">
        </datalist>

        <label>Fecha de administración</label>
        <input type="date" id="fehca-vacuna-administrada" name="fehca-vacuna-administrada"  required>

        <label>Número de lote</label>
        <input type="text" id="lote-vacuna" name="lote-vacuna" placeholder="LOT-2025-A123">

        <label>Proveedor de salud</label>
        <input type="text" id="provedor" name="provedor" placeholder="Hospital, Farmacia, clínica">

        <label>Notas Adicionales</label>
        <textarea id="notas-adicioanales" name="notas-adicionales" placeholder="Notas opcionales"></textarea>

        <button type="submit" class="btn-guardar" name="btnGuardarVacuna">Guardar Vacuna</button>
      </form>
    </div>
  </div>

  <!-- ✅ Modal de detalles PARA LAS VACUNAS-->
  <div id="modalDetalles" class="modal">
    <div class="modal-contenido">
      <span class="cerrar cerrarDetalles">&times;</span>
      <h2>Detalles de la Vacuna</h2>
      <p><strong>Nombre:</strong> <span id="detalleNombre"></span></p>
      <p><strong>Fecha:</strong> <span id="detalleFecha"></span></p>
      <p><strong>Número de lote:</strong> <span id="detalleLote"></span></p>
      <p><strong>Proveedor:</strong> <span id="detalleProveedor"></span></p>
      <p><strong>Notas:</strong></p>
      <p id="detalleNotas"></p>
    </div>
  </div>

    <?php
    include 'conectar.php';
    if(isset($_POST['btnGuardarVacuna'])){
        $nombreVacuna = $_POST['vacuna'];
        $fechaAdministracion = $_POST['fecha-vacuna-administrada'];
        $numeroLote = $_POST['lote-vacuna'];
        $proveedorSalud = $_POST['provedor'];
        $notasAdicionales = $_POST['notas-adicioanales'];
        $correo_usuario = $_SESSION['email']; // Obtener el correo del usuario desde la sesión
        try {
            $sql = "INSERT INTO vacunas (id_usuario, nombre_vacuna, fecha_administracion, numero_lote, proveedor_salud, notas_adicionales) 
                    VALUES (:id_usuario, :nombreVacuna, :fechaAdministracion, :numeroLote, :proveedorSalud, :notasAdicionales)";
            $stmt = $consulta->prepare($sql);
            $stmt->execute([
                ':id_usuario' => $correo_usuario,
                ':nombreVacuna' => $nombreVacuna,
                ':fechaAdministracion' => $fechaAdministracion,
                ':numeroLote' => $numeroLote,
                ':proveedorSalud' => $proveedorSalud,
                ':notasAdicionales' => $notasAdicionales
            ]);
            echo "<script>alert('Vacuna registrada exitosamente.');</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Error al registrar la vacuna: " . $e->getMessage() . "');</script>";
          }
      }
    ?>


  <!-- Modal: Agregar Nuevo Recordatorio -->
  <div id="modalRecordatorio" class="modal">
    <div class="modal-contenido">
      <span class="cerrar cerrarRecordatorio">&times;</span>
      <h2>Crear Recordatorio</h2>

      <form method="POST">
        <label for="recordatorio">Nombre de la Vacuna</label>
        <input list="listaVacunasRecordatorio" id="recordatorio" name="recordatorio" placeholder="Seleccione o escriba una vacuna" required />
        <datalist id="listaVacunasRecordatorio">
          <option value="COVID-19">
          <option value="Influenza">
          <option value="Hepatitis B">
          <option value="Tétanos">
          <option value="Sarampión">
        </datalist>

        <label>Fecha del recordatorio</label>
        <input type="date" id="fecha-recordatorio" name="fecha-recordatorio" required>

        <label>Notas</label>
        <textarea id="notas-adicionales" name="notas-adicionales" placeholder="Detalles adicionales del recordatorio"></textarea>

        <button type="submit" class="btn-guardar" name="btnGuardarRecordatorio" >Guardar Recordatorio</button>
      </form>
    </div>
  </div>

  <?php
    if(isset($_POST['btnGuardarRecordatorio'])){
        $nombreVacuna = $_POST['recordatorio'];
        $fechaRecordatorio = $_POST['fecha-recordatorio'];
        $notas = $_POST['notas-adicionales'];
        session_start(); // Iniciar la sesión
        $correo_usuario = $_SESSION['email']; // Obtener el correo del usuario desde la sesión
        try {
            $sql = "INSERT INTO recordatorios (id_usuario, nombre_vacuna, fecha_recordatorio, notas) 
                    VALUES (:id_usuario, :nombreVacuna, :fechaRecordatorio, :notas)";
            $stmt = $consulta->prepare($sql);
            $stmt->execute([
                ':id_usuario' => $correo_usuario,
                ':nombreVacuna' => $nombreVacuna,
                ':fechaRecordatorio' => $fechaRecordatorio,
                ':notas' => $notas
            ]);
            echo "<script>alert('Recordatorio creado exitosamente.');</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Error al crear el recordatorio: " . $e->getMessage() . "');</script>";
          }
      }
    ?>





  <!-- Script Agregar Vacuna -->
  <script>
    const modalVacuna = document.getElementById("modalVacuna");
    const btnAbrirVacuna = document.querySelector(".btn-agregarVacuna");
    const btnCerrarVacuna = document.querySelector(".cerrarVacuna");

    // Abrir modal vacuna
    btnAbrirVacuna.onclick = () => {
      modalVacuna.style.display = "flex";
    };

    // Cerrar modal vacuna
    btnCerrarVacuna.onclick = () => {
      modalVacuna.style.display = "none";
    };

    // Cerrar al hacer clic fuera del contenido
    window.addEventListener("click", (event) => {
      if (event.target === modalVacuna) {
        modalVacuna.style.display = "none";
      }
    });
  </script>

  <!-- Script Agregar Recordatorio -->
  <script>
    const modalRecordatorio = document.getElementById("modalRecordatorio");
    const btnAbrirRecordatorio = document.querySelector(".btn-agregarRecordatorio");
    const btnCerrarRecordatorio = document.querySelector(".cerrarRecordatorio");

    // Abrir modal recordatorio
    btnAbrirRecordatorio.onclick = () => {
      modalRecordatorio.style.display = "flex";
    };

    // Cerrar modal recordatorio
    btnCerrarRecordatorio.onclick = () => {
      modalRecordatorio.style.display = "none";
    };

    // Cerrar al hacer clic fuera del contenido
    window.addEventListener("click", (event) => {
      if (event.target === modalRecordatorio) {
        modalRecordatorio.style.display = "none";
      }
    });
  </script>


    
  <script>
    //sCRIPT PARA EL MENU RESPONSIVE Y EL MODAL DE DETALLES DE VACUNAS
    // Menú responsive
    const menuBtn = document.getElementById("menu-btn");
    const sidebar = document.getElementById("sidebar");
    menuBtn.addEventListener("click", () => sidebar.classList.toggle("active"));

    document.querySelectorAll(".sidebar a").forEach(link => {
      link.addEventListener("click", () => sidebar.classList.remove("active"));
    });

    // Modal detalles
    const modalDetalles = document.getElementById("modalDetalles");
    const cerrarDetalles = document.querySelector(".cerrarDetalles");

    function verDetalles(nombre, fecha, lote, proveedor, notas) {
      document.getElementById("detalleNombre").textContent = nombre;
      document.getElementById("detalleFecha").textContent = fecha;
      document.getElementById("detalleLote").textContent = lote;
      document.getElementById("detalleProveedor").textContent = proveedor;
      document.getElementById("detalleNotas").textContent = notas || "Sin notas adicionales";
      modalDetalles.style.display = "flex";
    }

    cerrarDetalles.onclick = () => modalDetalles.style.display = "none";
    window.onclick = e => { if (e.target === modalDetalles) modalDetalles.style.display = "none"; }
  </script>

</body>

<script src="JS/vacunacion.js"></script>

</html>

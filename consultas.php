<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Consultas Médicas</title>
    <link rel="stylesheet" href="vistaConsulta.css">
    <link href="fonts/fuente1.css" rel="Fontes" />
</head>
<body>
    <!-- Barra de navegación -->
    <header class="navbar">
        <div class="logo">
            <img src="img/logo 1.avif" alt="Logo Salud y Cuidados">
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


    <!-- Encabezado principal -->
    <section class="hero">
        <h2>Historial de Consultas Médicas</h2>
        <p>Revisa y gestiona todas tus consultas médicas en un solo lugar</p>
    </section>

    <!-- Filtro y botón -->
    <section class="filtro-consultas">

        
        <div class="filtro">
            <label for="especialidad">Filtrar por Especialidad</label>
            <select id="especialidad">
                <option>Medicina General</option>
                <option>Pediatría</option>
                <option>Cardiología</option>
                <option>Dermatología</option>
            </select>
        </div>

        <button class="btn-agregar">+ Agregar Consulta</button>
    </section>

    <!-- Aquí podrían listarse las consultas -->
    <section class="consultas-lista">
        <p>No hay consultas registradas aún.</p>
    </section>

    <footer>
        <p>© 2025 Salud y Cuidados — Proyecto en desarrollo</p>
    </footer>
    
    <!-- Modal: Agregar Nueva Consulta -->
    <div id="modalConsulta" class="modal">
        <div class="modal-contenido">
            <span class="cerrar">&times;</span>
            <h2>Agregar Nueva Consulta</h2>

            <form>
                <label>Fecha de Consulta</label>
                <input type="date" id="fecha-consulta" name="fecha-consulta" required>

                <label>Nombre del Médico</label>
                <input type="text" id="nombre-medico" name="nombre-medico" placeholder="Dr. Juan Pérez" required>

                <label>Especialidad</label>
                <select id="especialidad" name="especialidad" required>
                    <option value="">Seleccionar especialidad</option>
                    <option>Medicina General</option>
                    <option>Pediatría</option>
                    <option>Cardiología</option>
                    <option>Dermatología</option>
                </select>

                <label>Diagnóstico</label>
                <input type="text" id="diagnostico" name="diagnostico" placeholder="Descripción del diagnóstico">

                <label>Tratamiento</label>
                <input type="text" id="tratamiento" name="tratamiento" placeholder="Descripción del tratamiento">

                <label>Notas Adicionales</label>
                <textarea id="notas-adicionales" name="notas-adicionales" placeholder="Notas opcionales"></textarea>

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


    <!-- Script -->
    <script>
        const modal = document.getElementById("modalConsulta");
        const btnAbrir = document.querySelector(".btn-agregar");
        const btnCerrar = document.querySelector(".cerrar");

        // Abrir modal
        btnAbrir.onclick = () => {
            modal.style.display = "flex"; // usamos flex para centrar
        };

        // Cerrar modal
        btnCerrar.onclick = () => {
            modal.style.display = "none";
        };

        // Cerrar al hacer clic fuera del contenido
        window.onclick = (event) => {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        };
    </script>
    <script src="JS/consultas.js"></script
</body>
</html>
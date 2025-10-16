<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Consultas Médicas</title>
    <link rel="stylesheet" href="vistaConsulta.css">
</head>
<body>
    <!-- Barra de navegación -->
    <header class="navbar">
        <div class="logo">
            <img src="img/logo 1.avif" alt="Logo Salud y Cuidados">
            <h1>Salud y Cuidados</h1>
        </div>
        <nav>
            <a href="#">Inicio</a>
            <a href="#">Consultas</a>
            <a href="#">Estudios</a>
            <a href="#">Vacunación</a>
            <a href="#">Recordatorios</a>
            <a href="#">Perfil</a>
        </nav>
    </header>

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
                <option>Todas las Especialidades</option>
                <option>Medicina General</option>
                <option>Pediatría</option>
                <option>Cardiología</option>
                <option>Dermatología</option>
            </select>
        </div>

        <button class="btn-agregar">
            + Agregar Consulta
        </button>
    </section>

    <!-- Aquí podrían listarse las consultas -->
    <section class="consultas-lista">
        <p>No hay consultas registradas aún.</p>
    </section>

</body>
</html>

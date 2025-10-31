<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Inicio de Sesión - MedCard</title>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
  <link rel="stylesheet" href="vistaInicioSesion.css" />
</head>

<body>
  <main class="login-container">
    <div class="login-card">
      <div class="login-header">
        <div class="logo">
          <span class="material-symbols-outlined icon">health_and_safety</span>
          <h1>MedCard</h1>
        </div>
        <h2>Inicia sesión en tu cuenta</h2>
        <p>Bienvenido de nuevo, te hemos echado de menos.</p>
      </div>

      <div class="form-box">
        <form action="#" method="POST" class="form">
          <div class="form-group">
            <label for="email">Correo electrónico</label>
            <input type="email" id="email" name="email" placeholder="tu@correo.com" required />
          </div>

          <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" placeholder="••••••••" required />
            
          </div>

          <div class="options">
            <a href="#" class="forgot">¿Olvidé mi contraseña?</a>
          </div>
          <button type="submit" class="btn-primary" name="btnIniciarSesion">Iniciar sesion</button>
        </form>
      </div>

      <div class="register-text">
        <p>¿No tienes una cuenta? <a href="crearCuenta.php">Crear cuenta</a></p>
      </div>
    </div>
  </main>

  <?php
  // Incluimos el archivo de conexión
  include 'conectar.php';

  if (isset($_POST['btnIniciarSesion'])) {
      $email = $_POST['email'];
      $password = $_POST['password'];

      try {
          // Consulta: buscar el usuario por email
          $sql = "SELECT * FROM usuario WHERE email = :email";
          $stmt = $consulta->prepare($sql);
          $stmt->execute([':email' => $email]);
          $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

          if ($usuario) {
              // Validar contraseña (puedes usar password_verify si la guardas cifrada)
              if ($usuario['password'] === $password) {
                  session_start();
                  $_SESSION['id_usuario'] = $usuario['id_usuario'];
                  $_SESSION['nombre'] = $usuario['nombre'];
                   $_SESSION['email'] = $usuario['email']; // ✅ Guarda el correo del usuario
                  echo "<script>
                    alert('Inicio de sesión exitoso. ¡Bienvenido, " . $usuario['nombre'] . "!');
                    window.location.href = 'sesionIniciada.php';
                  </script>";
              } else {
                  echo "<script>alert('Contraseña incorrecta.');</script>";
              }
          } else {
              echo "<script>alert('No existe una cuenta con ese correo.');</script>";
          }
      } catch (PDOException $e) {
          echo "Error: " . $e->getMessage();
      }
  }
  ?>

</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Inicio de Sesión y Registro</title>
  <link rel="stylesheet" href="codigos/css/estilos.css" />
</head>
<body>
  <!-- Fondo animado -->
  <div id="background"></div>

  <!-- Cuadro deslizante con logo y formularios -->
  <div class="form-slider">
    <div class="container">
      <!-- Logo y Título dentro del cuadro -->
      <div class="gym-header">
        <img src="../assets/images/icons/Icono-Pag-Gym_login.png" alt="Logo Body Athletics" class="gym-logo">
      </div>

      <!-- Formulario de login -->
      <div id="login-form">
        <h2>Iniciar Sesión</h2>
        <?php include('mensajes_login.php'); ?>
        <form action="validar.php" method="POST">
          <label for="login-email">Usuario</label>
          <input type="text" name="usuario" id="login-email" required />

          <label for="login-password">Contraseña</label>
          <input type="password" name="contraseña" id="login-password" required />

          <button type="submit">Iniciar Sesión</button>
        </form>
        <p class="toggle-link" onclick="toggleForms()">¿No tienes cuenta? Regístrate</p>
      </div>

      <!-- Formulario de registro -->
      <div id="register-form" style="display: none;">
        <h2>Registrarse</h2>
        <?php include('mensajes_registro.php'); ?>
        <form action="registrar.php" method="POST">
          <label for="register-username">Usuario</label>
          <input type="text" name="usuario" id="register-username" required />

          <label for="register-cedula">Cédula</label>
          <input type="text" name="cedula" id="register-cedula" required />

          <label for="register-telefono">Teléfono</label>
          <input type="text" name="telefono" id="register-telefono" required />

          <label for="register-password">Contraseña</label>
          <input type="password" name="contraseña" id="register-password" required />

          <button type="submit">Registrarse</button>
        </form>
        <p class="toggle-link" onclick="toggleForms()">¿Ya tienes cuenta? Inicia Sesión</p>
      </div>
    </div>
  </div>

  <script src="codigos/js/script.js"></script>
  <script>
    // Mostrar el formulario de registro si el mensaje de registro está en la URL
    const urlParams = new URLSearchParams(window.location.search);
    const registroStatus = urlParams.get('registro');
    if (registroStatus) {
      document.getElementById('login-form').style.display = 'none';
      document.getElementById('register-form').style.display = 'block';
    }
  </script>
</body>
</html>
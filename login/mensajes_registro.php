<?php
if (isset($_GET['registro'])) {
    if ($_GET['registro'] == 'usuario_existe') {
        echo "<div class='error-box'>
                <p>⚠️ Error: El usuario o la cédula ya están registrados.</p>
              </div>";
    } elseif ($_GET['registro'] == 'exitoso') {
        echo "<div class='success-box'>
                <p>✅ ¡Registro exitoso! Ahora puedes iniciar sesión.</p>
              </div>";
    } elseif ($_GET['registro'] == 'campos_vacios') {
        echo "<div class='error-box'>
                <p>⚠️ Debes llenar todos los campos para registrarte.</p>
              </div>";
    } elseif ($_GET['registro'] == 'error_insercion') {
        echo "<div class='error-box'>
                <p>⚠️ Error al registrar usuario. Intenta nuevamente.</p>
              </div>";
    }
}
?>

<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    $_SESSION['usuario'] = 'Invitado';
}

$usuario = $_SESSION['usuario'];

if (isset($_GET['logout'])) {
    session_destroy();
    echo "<script>window.top.location.href='../../login/index.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Header Animado</title>
  <style>
    /* 1. Keyframes de entrada */
    @keyframes fadeInDown {
      0%   { opacity: 0; transform: translateY(-30px); }
      100% { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInLeft {
      0%   { opacity: 0; transform: translateX(-30px); }
      100% { opacity: 1; transform: translateX(0); }
    }
    @keyframes fadeInRight {
      0%   { opacity: 0; transform: translateX(30px); }
      100% { opacity: 1; transform: translateX(0); }
    }

    /* 2. Estilos globales y fondo animado */
    body {
      margin: 0;
      padding: 10px;
      font-family: Arial, sans-serif;
      background: linear-gradient(-45deg, #000, #010027, #000);
      background-size: 400% 400%;
      animation: backgroundAnimation 15s infinite alternate ease-in-out;
      color: #fff;
      overflow-x: hidden;
    }
    @keyframes backgroundAnimation {
      0%   { background-position: 0% 50%; }
      50%  { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    /* 3. Contenedor principal animado */
    .header-container {
      display: flex;
      align-items: center;
      justify-content: space-between;
      opacity: 0;
      animation: fadeInDown 0.8s ease-out forwards;
    }

    /* 4. Admin-container (slide desde la izquierda) */
    .admin-container {
      display: flex;
      flex-direction: column;
      gap: 10px;
      align-items: flex-start;
      opacity: 0;
      transform: translateX(-30px);
      animation: fadeInLeft 0.6s ease-out forwards;
      animation-delay: 0.3s;
    }
    .admin-box,
    .logout-box {
      padding: 10px;
      background-color: #222;
      color: #fff;
      text-align: center;
      border-radius: 5px;
      min-width: 100px;
    }
    .logout-link {
      display: inline-block;
      font-size: 14px;
      color: #4da6ff;
      text-decoration: none;
      font-weight: bold;
      cursor: pointer;
    }
    .logout-link:hover {
      text-decoration: underline;
    }

    /* 5. Logo (fadeInDown con retardo) */
    .logo-title {
      flex-grow: 1;
      text-align: center;
      opacity: 0;
      transform: translateY(-30px);
      animation: fadeInDown 0.6s ease-out forwards;
      animation-delay: 0.4s;
    }
    .logo-title img {
      width: 124px;
      height: auto;
      cursor: pointer;
    }

    /* 6. Social-container (slide desde la derecha) */
    .social-container {
      display: flex;
      gap: 20px;
      align-items: center;
      opacity: 0;
      transform: translateX(30px);
      animation: fadeInRight 0.6s ease-out forwards;
      animation-delay: 0.5s;
    }
    .social-container img {
      width: 40px;
      height: 40px;
      filter: invert(1);
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="header-container">
    <!-- Usuario y logout -->
    <div class="admin-container">
      <div class="admin-box"><?php echo htmlspecialchars($usuario); ?></div>
      <div class="logout-box">
        <a href="?logout" class="logout-link">Cerrar sesión</a>
      </div>
    </div>

    <!-- Logo centrado -->
    <div class="logo-title">
      <img
        src="../../assets/images/icons/Icono-Pag-Gym.png"
        alt="Icono Gym"
        id="home-icon"
      />
    </div>

    <!-- Íconos sociales -->
    <div class="social-container">
      <a href="https://www.facebook.com/Bodyathelicsglod"
         target="_blank"
      >
        <img
          src="../../assets/images/icons/facebook.png"
          alt="Facebook"
        />
      </a>
      <a href="https://www.instagram.com/gimnasiobodyathleticsgold/"
         target="_blank"
      >
        <img
          src="../../assets/images/icons/instagram.png"
          alt="Instagram"
        />
      </a>
      <a href="https://twitter.com/tuperfil" target="_blank">
        <img
          src="../../assets/images/icons/twitter.png"
          alt="Twitter"
        />
      </a>
    </div>
  </div>

  <script>
    function navigateToHome() {
      parent.document
        .querySelector('iframe[name="centerFrame"]')
        .src = 'frames/home.php';
    }

    document
      .getElementById('home-icon')
      .addEventListener('click', navigateToHome);
  </script>
</body>
</html>
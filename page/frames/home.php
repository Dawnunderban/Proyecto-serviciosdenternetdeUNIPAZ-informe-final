<?php
session_start();

// Verificar si el usuario ha iniciado sesión correctamente
if (!isset($_SESSION['usuario']) || !isset($_SESSION['cedula']) || !isset($_SESSION['telefono'])) {
    header("Location: ../login/index.php");
    exit();
}

$usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'Invitado';
$cedula  = isset($_SESSION['cedula'])  ? $_SESSION['cedula']  : 'No registrado';
$telefono= isset($_SESSION['telefono'])? $_SESSION['telefono']: 'No registrado';
$plan    = isset($_SESSION['plan'])    ? $_SESSION['plan']    : 'Sin plan';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Perfil de Usuario</title>
  <style>
    /* –––––––––––––––––––––––––––––––––––––––––––––– */
    /* 1. Keyframes de animación */
    @keyframes fadeInDown {
      0%   { opacity: 0; transform: translateY(-30px); }
      100% { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInUp {
      0%   { opacity: 0; transform: translateY(30px); }
      100% { opacity: 1; transform: translateY(0); }
    }

    /* –––––––––––––––––––––––––––––––––––––––––––––– */
    /* 2. Reset y body */
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-image: url('../planes/images/fondo_borroso.jpg');
      background-size: cover;
      background-attachment: fixed;
      background-position: center;
      background-repeat: no-repeat;
      overflow-x: hidden;
    }

    /* –––––––––––––––––––––––––––––––––––––––––––––– */
    /* 3. Contenedor de perfil */
    .profile-container {
      max-width: 900px;
      margin: 80px auto 20px;
      background: rgba(255,255,255,0.15);
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255,255,255,0.3);

      /* animación de entrada */
      opacity: 0;
      animation: fadeInDown 0.8s ease-out forwards;
    }

    .profile-container h2 {
      text-align: center;
      color: white;
      margin-top: 0;
    }

    .user-info {
      margin-bottom: 30px;
      padding: 15px;
      background-color: #f9f9f9;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .user-info .label {
      font-weight: bold;
      color: #000;
    }

    /* –––––––––––––––––––––––––––––––––––––––––––––– */
    /* 4. Contenedor y cada tarjeta de plan */
    .plans-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
      margin-bottom: 40px;
    }

    .plan {
      background-color: #cecece;
      padding: 20px;
      text-align: center;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.15);
      width: 280px;
      transition: transform 0.3s;
      cursor: pointer;

      /* animación de entrada */
      opacity: 0;
      transform: translateY(30px);
      animation: fadeInUp 0.3s ease-out forwards;
    }

    /* retardos escalonados */
    .plan:nth-child(1) { animation-delay: 0.3s; }
    .plan:nth-child(2) { animation-delay: 0.4s; }
    .plan:nth-child(3) { animation-delay: 0.5s; }

    .plan:hover {
      transform: scale(1.05);
    }

    .buy-link {
      display: block;
      margin-top: 10px;
      padding: 8px;
      background-color: #342e8d;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      font-weight: bold;
    }

    .buy-link:hover {
      background-color: #281e6e;
    }
  </style>
</head>
<body>

  <div class="profile-container">
    <h2>Perfil de Usuario</h2>
    <div class="user-info">
      <p><span class="label">Nombre:</span>   <?php echo htmlspecialchars($usuario); ?></p>
      <p><span class="label">Cédula:</span>   <?php echo htmlspecialchars($cedula); ?></p>
      <p><span class="label">Teléfono:</span> <?php echo htmlspecialchars($telefono); ?></p>
      <p><span class="label">Plan:</span>     <?php echo htmlspecialchars($plan); ?></p>
    </div>
  </div>

  <div class="plans-container">
    <div class="plan">
      <h3>Plan Basic</h3>
      <ul>
        <li>Acceso al gym de lunes a sábado</li>
        <li>Horario: 5 a.m. – 10 p.m.</li>
        <li>Área de pesas y cardio</li>
      </ul>
      <div class="price">$80,000 COP/mes</div>
      <a href="../planes/plan_basic.php" class="buy-link">Comprar</a>
    </div>

    <div class="plan">
      <h3>Plan Energy</h3>
      <ul>
        <li>Acceso ilimitado todos los días</li>
        <li>Clases grupales (zumba, spinning)</li>
        <li>Asesoría inicial de entrenamiento</li>
      </ul>
      <div class="price">$120,000 COP/mes</div>
      <a href="../planes/plan_energy.php" class="buy-link">Comprar</a>
    </div>

    <div class="plan">
      <h3>Plan Premium</h3>
      <ul>
        <li>Acceso VIP 24/7</li>
        <li>Entrenador personal 2 veces por semana</li>
        <li>Clases + asesoría nutricional</li>
        <li>Descuentos en productos</li>
      </ul>
      <div class="price">$200,000 COP/mes</div>
      <a href="../planes/plan_premium.php" class="buy-link">Comprar</a>
    </div>
  </div>

</body>
</html>

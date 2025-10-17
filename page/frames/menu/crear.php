<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>¡Muy Pronto!</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #4b6cb7, #182848);
      color: #fff;
      text-align: center;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    h1 {
      font-size: 3.5rem;
      margin-bottom: 20px;
    }
    p {
      font-size: 1.5rem;
      margin-bottom: 40px;
    }
    .loader {
      border: 10px solid rgba(255, 255, 255, 0.2);
      border-top: 10px solid #fff;
      border-radius: 50%;
      width: 80px;
      height: 80px;
      animation: spin 1s ease-in-out infinite;
      margin-bottom: 20px;
    }
    @keyframes spin {
      to { transform: rotate(360deg); }
    }
    .coming-soon {
      font-size: 1.2rem;
      padding: 10px 20px;
      border: 2px solid #fff;
      border-radius: 30px;
      background: rgba(0, 0, 0, 0.3);
    }
  </style>
</head>
<body>
  <h1>¡Muy Pronto!</h1>
  <div class="loader"></div>
  <p>Estamos trabajando en algo increíble. ¡Vuelve pronto para descubrirlo!</p>
  <div class="coming-soon">En Modificación</div>
</body>
</html>

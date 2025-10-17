<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login/index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan Energy</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('images/fondo_borroso.jpg'); /* Ajusta la ruta de la imagen */
            background-size: cover;
            background-position: center;
        }

.payment-container input {
    width: 100%;
    padding: 12px 0px; /* Más espacio a los lados */
    border-radius: 6px;
    margin-top: 5px;
    background-color: rgba(255, 255, 255, 0.2);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.5);
    font-size: 16px;
}


        .payment-container {
            max-width: 500px;
            margin: 80px auto;
            background: rgba(255, 255, 255, 0.15);
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .payment-container h1 {
            color: #57a8ff;
        }

        .payment-container label {
            display: block;
            text-align: left;
            margin-top: 10px;
            color: white;
        }


        .pay-button {
            margin-top: 20px;
            padding: 12px;
            width: 100%;
            background-color: #57a8ff;
            color: #ffffff;
            font-size: 18px;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            border: none;
        }

        .pay-button:hover {
            background-color: #4498e8;
        }
    </style>
</head>
<body>
    <div class="payment-container">
        <h1>Plan Energy</h1>
        <form action="process_payment.php" method="post">
            <label for="card_number">Número de Tarjeta:</label>
            <input type="text" id="card_number" name="card_number" maxlength="19" placeholder="XXXX-XXXX-XXXX-XXXX" required oninput="formatCardNumber(this)" pattern="\d{4}-\d{4}-\d{4}-\d{4}" title="Debe tener exactamente 16 dígitos">
            
            <label for="cvv">CVV:</label>
            <input type="text" id="cvv" name="cvv" maxlength="3" placeholder="XXX" required oninput="validateCVV(this)" pattern="\d{3}" title="Debe tener exactamente 3 dígitos">

            <label for="exp_date">Fecha de Expiración:</label>
            <input type="text" id="exp_date" name="exp_date" maxlength="5" placeholder="MM/YY" required oninput="formatExpDate(this)" pattern="(0[1-9]|1[0-2])\/\d{2}" title="Formato MM/YY, mes entre 01 y 12">
            
            <input type="hidden" name="plan" value="Energy">
            <button type="submit" class="pay-button">Pagar</button>
        </form>
    </div>

    <script>
        function formatCardNumber(input) {
            let value = input.value.replace(/\D/g, '').substring(0, 16);
            value = value.replace(/(\d{4})/g, '$1-').replace(/-$/, '');
            input.value = value;
        }

        function validateCVV(input) {
            input.value = input.value.replace(/\D/g, '').substring(0, 3);
        }

        function formatExpDate(input) {
            let value = input.value.replace(/\D/g, '').substring(0, 4);
            if (value.length >= 2) {
                let month = value.substring(0, 2);
                if (parseInt(month) < 1 || parseInt(month) > 12) {
                    value = '01' + value.substring(2);
                }
                value = month + '/' + value.substring(2);
            }
            input.value = value;
        }
    </script>
</body>
</html>

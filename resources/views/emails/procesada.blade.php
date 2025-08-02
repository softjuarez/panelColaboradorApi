<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Solicitud Recibida</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333333;
            text-align: center;
        }
        p {
            color: #555555;
            line-height: 1.6;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            color: #888888;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Nueva Solicitud Recibida</h1>
        <p>A quien corresponda:</p>
        <p>Se ha recibido una nueva solicitud de <strong>{{ $solicitud->ficha->NOMBRE }}</strong>.</p>
        <p><strong>Tipo de solicitud:</strong> {{ $solicitud->tipo_solicitud->nombre }}</p>
        <p>Por favor, revise la solicitud en el sistema y proceda con su revisión.</p>
        <div class="footer">
            <p>Atentamente,<br>Universidad Da Vinci</p>
        </div>
    </div>
</body>
</html>
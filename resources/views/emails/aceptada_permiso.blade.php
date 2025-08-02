<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud Aceptada</title>
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
            color: #28a745;
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
        <h1>Solicitud de Permiso Aceptada</h1>
        <p>Estimado/a {{ $solicitud->usuario->name }},</p>
        <p>Nos complace informarle que su solicitud de <strong>{{ $solicitud->tipo_solicitud->nombre }}</strong> ha sido <strong>aceptada</strong>.</p>
        <p><strong>Comentarios:</strong> {{ $solicitud->descripcion }}</p>
        <p>Por favor, revise los detalles en el sistema o póngase en contacto con el departamento correspondiente si necesita más información.</p>
        <div class="footer">
            <p>Atentamente,<br>Universidad Da Vinci</p>
        </div>
    </div>
</body>
</html>

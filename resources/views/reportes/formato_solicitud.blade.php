<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitud de Permisos, Ausencias y/o Reposiciones</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
            font-size: 10pt; /* Ajustado para que el contenido quepa en una página */
        }
        .container {
            width: 100%;
            max-width: 750px; /* Ancho aproximado del formulario en la imagen */
            margin: 0 auto;
            box-sizing: border-box;
        }
        .header {
            display: table; /* Usar display: table para controlar el flujo y alineación */
            width: 100%;
            margin-bottom: 20px;
        }
        .header-left, .header-right {
            display: table-cell;
            vertical-align: center;
            padding: 5px;
        }
        .header-left {
            width: 70%; /* Ajustar el ancho según la imagen */
        }
        .header-right {
            width: 30%; /* Ajustar el ancho según la imagen */
            text-align: right;
        }
        .header-logo {
            max-width: 200px; /* Ajusta el tamaño del logo */
            height: auto;
            vertical-align: middle;
            margin-right: 10px;

        }
        .header-text {
            display: inline-block;
            vertical-align: middle;
            font-size: 11pt;
            font-weight: bold;
        }
        .title {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 25px;
            padding-bottom: 10px;
        }
        .field-row {
            margin-bottom: 15px;
            padding-left: 0;
        }
        .field-label {
            font-weight: bold;
            display: inline-block;
            width: 200px; /* Ancho fijo para las etiquetas */
        }
        .field-line {
            display: inline-block;
            border-bottom: 1px solid #000;
            width: calc(100% - 210px); /* Ajusta el ancho de la línea */
            vertical-align: bottom;
            min-height: 12px; /* Altura mínima para que la línea sea visible */
        }
        .field-line.full-width {
            width: 100%;
        }
        .description-box {
            margin-top: 15px;
            margin-bottom: 20px;
        }
        .description-box .field-label {
            width: auto;
            margin-bottom: 5px;
        }
        .description-line {
            border-bottom: 1px solid #000;
            margin-bottom: 8px;
            min-height: 12px;
            width: 100%;

        }
        .replacement-form {
            border: 1px solid #000;
            padding: 15px;
            margin-top: 25px;
            margin-bottom: 30px;
        }
        .replacement-title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 15px;
            font-size: 11pt;
        }
        .replacement-option {
            display: inline-block;
            vertical-align: middle;
            margin-bottom: 10px;
            margin-right: 20px;
            margin-left: 10px;
        }
        .replacement-option input[type="checkbox"] {
            vertical-align: middle;
            margin-right: 5px;
            margin-left: 0;
            transform: scale(0.8); /* Ajustar el tamaño del checkbox */
        }
        .replacement-option label {
            vertical-align: middle;
            font-size: 10pt;
        }
        .replacement-specific {
            margin-top: 10px;
        }
        .replacement-specific .field-line {
            width: calc(100% - 130px); /* Ajusta el ancho de la línea */
            vertical-align: bottom;
        }
        .signatures {
            display: table;
            width: 100%;
            margin-top: 40px;
        }
        .signature-col {
            display: table-cell;
            width: 50%;
            text-align: center;
            padding: 10px;
        }
        .signature-line {
            border-bottom: 1px solid #000;
            width: 80%; /* Ajusta el ancho de la línea de firma */
            margin: 0 auto 5px auto;
            min-height: 12px;
        }
        .signature-label {
            font-size: 9pt;
        }
        .management-info {
            margin-top: 50px;
            font-size: 9pt;
        }
        .management-info .field-label {
            width: auto;
            margin-bottom: 5px;
        }
        .management-info .field-line {
            width: calc(100% - 60px); /* Ajusta el ancho de la línea */
            vertical-align: bottom;
        }
        .date-info {
             margin-top: 30px;
             font-size: 9pt;
             width: 50%;
        }
        .date-info .field-label {
             width: auto;
        }
        .date-info .field-line {
             width: calc(100% - 40px); /* Ajusta el ancho de la línea */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-left">
                <img src="{{ public_path('img/logo-udvgt.png') }}" alt="Logo Universidad Da Vinci" class="header-logo">
                <div class="header-text">
                </div>
            </div>
            <div class="header-right">
                Guatemala: {{ date('d/m/Y') }}</span>
            </div>
        </div>

        <div class="title">
            SOLICITUD DE PERMISOS, AUSENCIAS Y/O REPOSICIONES
        </div>

        <div class="field-row">
            <b>NOMBRE DEL SOLICITANTE: </b> {{ $ficha->NOMBRE }}
        </div>

        <div class="field-row">
            <b>CARGO: </b> {{ $ficha->PUESTO_INGRESA }}
        </div>

        <div class="field-row">
            <b>NOMBRE JEFE INMEDIATO: </b>{{ $ficha->jefeInmediato() }}</span>
        </div>

        <div class="field-row">
            <b>SOLICITUD DE PERMISO PARA: </b>{{ $para }}
            <br/>
            <div style="text-align: center; font-size: 8pt; margin-top: 5px;">(Colocar si será: ausencia, vacaciones o reposición)</div>
        </div>

        <div class="description-box">
            <b>DESCRIPCIÓN DETALLADA:</b> {{ $detalle }}
        </div>

        <div class="replacement-form">
            <div class="replacement-title">
                FORMA DE REPOSICIÓN
            </div>
            <div class="replacement-option">
                <input type="checkbox" id="cuentaVacaciones" checked>
                <label for="cuentaVacaciones">A CUENTA DE VACACIONES</label>
            </div>
            <div class="replacement-option">
                <input type="checkbox" id="descuentoSalario">
                <label for="descuentoSalario">DESCUENTO DE SALARIO</label>
            </div>
            <div class="replacement-option">
                <input type="checkbox" id="otros">
                <label for="otros">OTROS</label>
            </div>
            <div class="replacement-specific">
                <span class="field-label">OTROS ESPECIFIQUE:</span><span class="field-line"></span>
                <div class="description-line"></div>
                <div class="description-line"></div>
            </div>
        </div>

        <div class="signatures">
            <div class="signature-col">
                <div class="signature-line"></div>
                <div class="signature-label">FIRMA SOLICITANTE</div>
            </div>
            <div class="signature-col">
                <div class="signature-line"></div>
                <div class="signature-label">AUTORIZACIÓN JEFE INMEDIATO</div>
            </div>
        </div>

        <div class="signatures">
            <div class="signature-col">
                <div class="signature-line"></div>
                <div class="signature-label">DIRECCIÓN DE GESTIÓN HUMANA</div>
            </div>
        </div>

        <div class="date-info">
            <span class="field-label">Fecha:</span><div class="signature-line"></div>
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .header-table td {
            vertical-align: middle; /* Alineación vertical */
        }

        .header-table img {
            max-width: 250px; /* Tamaño máximo del logo */
        }

        .linea-gris {
            border-bottom: 1px solid #ccc;
            margin: 5px 0;
        }

        .info-table {
            width: 100%;
            margin-top: 2rem;
            border-spacing: 0rem; /* Elimina espacios en la tabla */
        }

        .info-table td {
            padding: 8px 20px; /* Elimina espaciado entre filas */
            vertical-align: top;
            font-size: 9px;
            width: 50%;
        }

        .info-table span {
            color: #1e83f6;
            font-weight: bold;
        }

        .items-table {
            width: 100%;
            border-spacing: 0; /* Elimina espacios internos */
            border-collapse: collapse; /* Une las líneas de los bordes */
            margin-top: 0.5rem;
            font-size: 10px;
            border-right: 1px solid #030649;
        }

        .items-table th {
            font-weight: bold;
            padding: 5px 0px 5px 0px;
            /*border-top: 1px solid #030649;*/ /* Solo el encabezado tiene una línea gris */
        }

        .items-table td {
            padding: 2px 8px;
            border-top: 1px solid #030649;
        }

        .center-text {
            text-align: center;
        }

        .right-text {
            text-align: right;
        }

        .bold-text {
            font-weight: bold;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
        }

        .footer .linea {
            border-top: 1px solid #ccc; /* Línea para la firma */
            width: 50%; /* Largo reducido al 50% */
            margin: 0 auto; /* Centra la línea */
        }

        .observations {
            font-size: 10px;
        }

        .page-break {
            page-break-before: always;
        }

        .page-break:first-child {
            page-break-before: avoid;
        }

        .recibo-info {
            text-align: center;
        }

        .recibo-info h1 {
            font-size: 22px;
            font-weight: bold;
            color: black;
        }

        .recibo-info h2 {
            font-size: 15px;
            font-weight: bold;
            margin: 0;
            color: #1e83f6;
        }

        /* Firma y número de identificación */
        .signature {
            margin-top: 20px;
            text-align: center;
        }

        .signature p {
            margin: 5px 0;
            font-size: 12px;
            color: #000;
        }

        /* Línea de firma */
        .signature-line {
            border-bottom: 1px solid #000;
            width: 50%;
            margin: 0 auto;
            height: 1px;
        }
    </style>
</head>
<body>

@foreach ($recibos as $item)
@php
    $fechaCarbon = \Carbon\Carbon::parse($item->FECHA_INICIO);
@endphp
<div class="page-break">
    <table class="header-table">
        <tr>
            <td>
                <img src="{{ public_path('img/logo-udvgt.png') }}" alt="Logo">
            </td>
            <td class="right-text">
                <p style="color: orange"><strong>UDV RECIBO {{ Str::upper($fechaCarbon->translatedFormat('F')) }} N°.</strong> {{ $item->numeroDeNomina($item->FECHA_PAGO) }}</p>
            </td>
        </tr>
    </table>

    <div class="recibo-info">
        <h1>COMPROBANTE DE PAGO SALARIAL</h1>
        <h2>{{ $item->NOMBRE }}</h2>
        <h2>{{ $item->PUESTO_INGRESA }}</h2>
    </div>

    <table class="info-table">
        <tr>
            <td><strong>NIT:</strong> <span>{{ $item->NIT }}</span></td>
            <td><strong>PERIODO DE PAGO: </strong><span>DEL {{ date('d', strtotime($item->FECHA_INICIO)) }} AL  {{ date('d', strtotime($item->FECHA_FIN)) }} DE {{ Str::upper($fechaCarbon->translatedFormat('F')) }} {{ date('Y', strtotime($item->FECHA_INICIO)) }}</span></td>
        </tr>
        <tr>
            <td><strong>TIPO DE PAGO:</strong> <span>MENSUAL</span> </td>
            <td><strong>FORMA DE PAGO: </strong> <span>{{ $item->FORMA_PAGO }}</span> <strong> NO: </strong> <span>{{ $item->NO_CHEQUE_LOTE }}</span></td>
        </tr>
        <tr>
            <td><strong>DIAS LABORADOS:</strong> <span>{{ number_format($item->DIAS_TRABAJADOS, 0, '', '') }}</span></td>
            <td><strong>FECHA DE PAGO: </strong> <span>{{ date('d/m/Y', strtotime($item->FECHA_PAGO)) }}</span> </td>
        </tr>
        <tr>
            <td colspan="2"><strong>CORREO:</strong> <span>{{ $item->CORREO }}</span></td>
        </tr>
    </table>

    <table style="width: 100%; border-collapse: collapse; border-spacing: 0; border: none;">
        <tr>
            <td style="width: 50%; vertical-align: top; padding: 0; margin: 0;">
                <table class="items-table" style="border-left: 1px solid #030649;">
                    <thead>
                        <tr style="background-color: #030649; color: white;">
                            <th colspan="2" style="text-align: center;">PERCEPCIONES</th>
                        </tr>
                        <tr>
                            <th style="text-align: center; width: 80%;">DETALLE</th>
                            <th style="text-align: center; width: 20%; border-left: 1px solid #030649;">MONTO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>SALARIO MENSUAL</td>
                            <td style="text-align: right; border-left: 1px solid #030649;">{{ number_format($item->VLR_DIAS_TRAB, 2, '.', ',') }}</td>
                        </tr>
                        <tr>
                            <td>BONIFICACION DECRETO 37-2001</td>
                            <td style="text-align: right; border-left: 1px solid #030649;">{{ number_format($item->BONIFICAC_BASE, 2, '.', ',') }}</td>
                        </tr>
                        <tr>
                            <td style="background-color: #030649; color: white; text-align: center;">TOTAL PERCEPCIONES</td>
                            <td style="background-color: #030649; color: white; text-align: right;">{{ number_format($item->BONIFICAC_BASE + $item->VLR_DIAS_TRAB, 2, '.', ',') }}</td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td style="width: 50%; vertical-align: top; padding: 0; margin: 0;">
                <table class="items-table">
                    <thead>
                        <tr style="background-color: #030649; color: white;">
                            <th colspan="2" style="text-align: center;">DEDUCCIONES</th>
                        </tr>
                        <tr>
                            <th style="text-align: center; width: 80%;">DETALLE</th>
                            <th style="text-align: center; width: 20%; border-left: 1px solid #030649;">MONTO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>IGSS</td>
                            <td style="text-align: right; border-left: 1px solid #030649;">{{ number_format($item->IGSS, 2, '.', ',') }}</td>
                        </tr>
                        @php
                            $valorTotalDeucciones = 0;
                        @endphp

                        @foreach ($item->nomina($item->NOMINA_D_NUMERO) as $item2)
                            @php
                                $valorTotalDeucciones += $item2->valor;
                            @endphp

                            <tr>
                                <td>{{ $item2->nombre }}</td>
                                <td style="text-align: right; border-left: 1px solid #030649;">{{ number_format($item2->valor, 2, '.', ',') }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td style="background-color: #030649; color: white; text-align: center;">TOTAL PERCEPCIONES</td>
                            <td style="background-color: #030649; color: white; text-align: right;">{{ number_format(($item->IGSS + $valorTotalDeucciones), 2, '.', ',') }}</td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>

    <table class="items-table" style="margin-top: 1rem;">
        <thead>
            <tr style="background-color: #030649; color: white;">
                <th style="text-align: center; width: 50%;">SALARIO A DEVENGAR</th>
                <th style="text-align: center; width: 50%;">{{ number_format(($item->BONIFICAC_BASE + $item->VLR_DIAS_TRAB) - ($item->IGSS + $valorTotalDeucciones), 2, '.', ',') }}</th>
            </tr>
        </thead>
    </table>

    <table style="width: 100%; margin-top: 2rem;">
        <tr>
            <td style="width: 50%; text-align: center;">
                <div class="signature">
                    </br>
                    <div class="signature-line"></div>
                    <p><strong>FIRMA DE RECIBIDO</strong></p>
                </div>
            </td>
            <td class="right-text" style="width: 50%; text-align: center;">
                <div class="signature">
                    <p>{{ number_format($item->numero_dpi, 0, '', '') }}</p>
                    <div class="signature-line"></div>
                    <p><strong>NÚMERO DE IDENTIFICACIÓN</strong></p>
                </div>
            </td>
        </tr>
    </table>

    <div class="linea-gris"></div>
</div>
@endforeach

</body>
</html>

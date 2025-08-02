<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ficha de responsabilidad</title>
    <style>

        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 3cm;
            text-align: center;
            padding: 0cm;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 1.5cm;
            background-color: #f0f0f0;
            text-align: center;
            line-height: 1cm;
            border-top: 1px solid #ccc;
            padding: 0.5cm;
            font-size: 0.8em;
        }

        body {
            margin-top: 2.5cm;
            margin-bottom: 2cm;
            line-height: 1.6;
            font-family: Arial, sans-serif;
            font-size: 10px;
        }

        .content {
            margin: 0 0cm; /* Margen lateral para el contenido */
            width: 100%;
        }

        .page-break {
            page-break-after: always;
        }

        .info-section {
            margin-bottom: 2px;
            border: 1px solid #000;
            padding: 5px;
            line-height: 1.5;
            border-bottom: #000 solid 3px;
        }

        .container {
            width: 100%;
            border: 1px solid #000;
        }

        .assets-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .assets-table th, .assets-table td {
            border-bottom: 1px solid #000;
            padding: 2px 5px 2px 5px;
            text-align: left;
        }
        .assets-table th {
            font-weight: bold;
            text-align: center;
        }
        .assets-table .total-items {
            text-align: right;
            font-weight: bold;
            padding-right: 10px;
            border: none;
        }
        .assets-table .total-items span {
            border-bottom: 1px solid #000;
            padding: 3px 8px;
            display: inline-block;
            margin-left: 5px;
        }
        .clause-section {
            border-top: 1px solid #000;
            padding: 8px;
            margin-bottom: 15px;
            font-size: 9px;
            line-height: 1.4;
            text-align: justify;
        }
        .clause-section strong {
            font-weight: bold;
        }
        .note-section {
            font-size: 8px;
            line-height: 1.3;
            margin-top: 10px;
        }
        .signatures-section {
            width: 100%;
            margin-top: 20px;
        }

        @page {
            margin-top: 2cm;
            @top {
                content: element(header);
            }
            @bottom-right {
                content: "Página " counter(page);
            }
        }

        .page-number::after {
            content: counter(page);
        }

    </style>
</head>
<body>
    <header>
        <table width="100%">
            <tr>
                <td width="20%"><img src="{{ public_path('img/logo-udvgt.png') }}" alt="Logo" style="max-width: 150px;"></td>
                <td width="40%" style="text-align: center;">
                    <h2 style="margin: 0;">{{ $parametros['empresa']->NOMBRE_COMPLETO }}</h2>
                    <h4 style="margin: 0;">HOJA DE RESPONSABILIDAD DE ACTIVOS</h4>
                </td>
                <td width="20%" style="text-align: right;">
                    <b style="text-align: right; margin:0;">Pagina: <span class="page-number"></span></b>
                    <p style="text-align: right; margin:0;">Fecha: {{ date('d/m/Y') }}</p>
                </td>
            </tr>
        </table>
    </header>


    <main class="content">
        <div style="border-top:#000 solid 3px; margin-bottom: 5px;"></div>

        <div class="info-section">
            <table width="100%">
                <tr>
                    <td style="text-align: right; font-weight:bold;">Nombre del Responsable:</td>
                    <td>{{ $ficha->NOMBRE }}</td>
                    <td>Número del Responsable:</td>
                    <td>{{ $ficha->NUMERO }}</td>
                </tr>
                <tr>
                    <td style="text-align: right; font-weight:bold;">Departamento:</td>
                    <td>{{ $ficha->Entidad()->NOMBRE }}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="text-align: right; font-weight:bold;">No. de Identificación Personal:</td>
                    <td>{{ number_format($ficha->numero_dpi, 0, '', '') }}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="text-align: right; font-weight:bold;">Tipo / Número Activo:</td>
                    <td>GENERAL</td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
        </div>

        <div class="container">
            <table class="assets-table">
                <thead>
                    <tr>
                        <th>Fecha de Alta</th>
                        <th>Código</th>
                        <th>Código UDV</th>
                        <th>Descripción Activo</th>
                        <th>Observaciones</th>
                        <th># Serie</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $item)
                        <tr>
                            <td>{{ date('d/m/Y', strtotime($item->FECHA_ALTA)) }}</td>
                            <td >{{ $item->Numero }}</td>
                            <td >{{ data_get($item, 'Código Barras') }}</td>
                            <td style="font-size:8px;">{{ $item->DESCRIPCION }}</td>
                            <td style="font-size:8px;">{{ $item->LOCALIDAD }}</td>
                            <td>{{ $item->SERIE }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No hay registros</td>
                        </tr>
                    @endforelse

                    <tr>
                        <td colspan="4" class="total-items">Total Items:</td>
                        <td colspan="2" class="total-items"><span>{{ count($data) }}</span></td>
                    </tr>
                </tbody>
            </table>

            <div class="clause-section">
                <div class="clause-title" style="font-weight: bold; text-align: center; margin-bottom: 5px;">
                    OBSERVACIONES:
                </div>
                <p>
                    CLAUSULA DE COMPROMISO: Como colaborador de Universidad Da Vinci de Guatemala, recibo los activos y/o inventarios relacionados en la presente hoja y sus anexos los cuales estarán bajo mi responsabilidad, les daré el uso y trato adecuado al desempeño de mis funciones y la destinación prevista para cada uno de ellos. Me comprometo a informar oportunamente al área de activos fijos sobre cualquier desplazamiento, siniestro, reparación, traslado, cambio de responsables, por medio de los correos respectivos y sobre cualquier situación que ponga en inminente el riesgo de los bienes de UDV. No haré disposición de los activos a mi cargo por otros que me parecieran más nuevos, más cómodos o más versátiles que los que están en mi responsabilidad a menos que fuere debidamente necesario para el cumplimiento de mis funciones. No moveré los activos a otro sitio donde no corresponde a menos que sean por actividades sumamente necesarias en el cumplimiento de mis funciones y los devolveré al lugar donde fueron tomados inmediatamente. En caso de lo contrario asumiré el daño o la pérdida de los mismos originados por mi negligencia, mal uso, falta de control o incumplimiento de lo establecido en esta cláusula de la conservación y custodia de los mismos. Dado que la omisión de estas disposiciones es considerada como falta grave por el Reglamento Interno de Trabajo, asumo las consecuencias económicas que conlleven el daño o la pérdida de los bienes mencionados.
                </p>
                <p class="note-section">
                    Nota: En caso de existir faltantes al momento de hacer la entrega de la hoja de responsabilidad o la verificación de la misma por los encargados de Activos Fijos, por Auditoría Interna o Externa y que firmé en señal de aceptación se adelantarán las disposiciones que dicte el Reglamento Interno de Trabajo.
                </p>
            </div>

            <div class="signatures-section">
                <table width="100%">
                    <tr style="text-align: center;">
                        <td style="width: 40%">
                            <h4 style="margin: 0;">Firma del Responsable</h4>
                            <p style="margin: 0;">{{ $ficha->NOMBRE }}</p>
                        </td>
                        <td style="width: 20%"></td>
                        <td style="width: 40%">
                            <h4 style="margin: 0;">Responsable Activos Fijos</h4>
                            <p style="margin: 0;">{{ auth()->user()->name }}</p>
                        </td>
                    </tr>
                    <tr style="text-align: center;">
                        <td></td>
                        <td>
                            <h4 style="margin: 0;">Fecha Impresión</h4>
                            <p style="margin: 0;">{{ date('d/m/Y') }}</p>
                        </td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    </main>
</body>
</html>

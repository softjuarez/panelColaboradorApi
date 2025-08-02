<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requerimiento de Compra</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .container { width: 100%; }
        .header { width: 100%; text-align: center; margin-bottom: 10px;}
        .footer { width: 100%; text-align: center; margin-bottom: 10px; margin-top: 4rem; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid black; padding: 5px; text-align: left; }
        .table th { background-color: #f2f2f2; }
        .signature { width: 33%; display: inline-block; text-align: center; }
        .signature-box { border-top: 1px solid black; width: 80%; margin: auto; padding-top: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <table width="100%">
                <tr>
                    <td width="40%"><img src="{{ public_path('img/logo-udvgt.png') }}" alt="Logo" style="max-width: 200px;"></td>
                    <td width="20%" style="text-align: center;"></td>
                    <td width="40%" style="text-align: right;">
                        <b>UDV-MEM-{{ $requisicion->NUMERO }} <br/> Tipo de Compra: {{ $requisicion->tipoCompra() }}</b>
                        <p style="text-align: right; margin:0; margin-top:1rem;">Fecha: {{ date('d/m/Y', strtotime($requisicion->FECHA))}}</p>
                    </td>
                </tr>
            </table>
        </div>

        <h2 style="text-align: center; margin-top:3rem; margin-bottom:3rem; font-size: 20px;">Requerimiento de Compra</h2>


        <p><strong>De:</strong> {{ Str::title($requisicion->ficha->NOMBRE) }}</p>
        <p><strong>Para:</strong> {{ Str::title($requisicion->usuarioDestinoActual()) }}</p>

        @if ($requisicion->T_RECHAZO == 'A')
        <p style="margin-top:2rem;">Asignación de Activo a: <b>{{ Str::title($requisicion->usuarioDestino()) }}</b></p>
        @endif

        <table class="table">
            <tr>
                <th style="text-align: center; ">Descripción</th>
                <th style="text-align: center; ">Cantidad</th>
                <th style="text-align: center; ">P/Unitario</th>
                <th style="text-align: center; ">Total</th>
            </tr>
            @php
                $total = 0;
            @endphp
            @foreach ($requisicion->detalles as $detalle)
            @php
                $total += $detalle->PU;
            @endphp
            <tr>
                <td>{{ $detalle->DESCRIPCION }}</td>
                <td style="text-align: right;">{{ number_format($detalle->CANTIDAD, 2, '.', ',') }}</td>
                <td style="text-align: right;">{{ number_format($detalle->PU / $detalle->CANTIDAD, 2, '.', ',') }}</td>
                <td style="text-align: right;">{{ number_format($detalle->PU, 2, '.', ',') }}</td>
            </tr>
            @endforeach
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: right;">Total:</td>
                    <td style="text-align: right;">{{ number_format($total, 2, '.', ',') }}</td>
                </tr>
            </tfoot>
        </table>

        <p style="color: blue;"><strong>Nota:</strong> La cotización es únicamente con fines de referencia, queda a cargo del Departamento de Compras en buscar un nuevo proveedor o bien realizar la negociación para adquirir un mejor precio.</p>

        <h3 style="margin:0;">Justificacion de compra:</h3>
        <p style="border: 1px solid black; height: 50px; margin:0;">{{ $requisicion->COMENTARIOS }}</p>


        <h3 style="margin-top:2rem;">Esto se incluirá en el presupuesto de:</h3>
        <table cellspacing="0" style="width: 100%; margin:0; font-size: 12px;">
            <tr>
                <td style="width: 25%; padding: 0;">
                </td>
                <td style="width: 35%; padding: 0;">
                    <ul style="margin:0;">
                        <li><b>Asignado a Dirección / Facultad / Vicerrectoría</b> (Centro de Costo):</li>
                    </ul>
                </td>
                <td style="width: 40%; padding: 0; vertical-align: bottom;">
                    {{ $requisicion->obtenerCentroCosto() }}
                </td>
            </tr>
            <tr>
                <td style="width: 25%; padding: 0;">
                </td>
                <td style="width: 35%; padding: 0;">
                    <ul style="margin:0;">
                        <li><b>OPEX / CAPEX / Cuenta Contable</b> (La cta. contable no indispensable):</li>
                    </ul>
                </td>
                <td style="width: 40%; padding: 0; vertical-align: bottom;">
                    {{ $requisicion->cuentaContable() }}
                </td>
            </tr>
            <tr>
                <td style="width: 25%; padding: 0;">
                </td>
                <td style="width: 35%; padding: 0;">
                    <ul style="margin:0;">
                        <li><b>Sedes</b> (Listado de las sedes involuca):</li>
                    </ul>
                </td>
                <td style="width: 40%; padding: 0; vertical-align: bottom;">
                    {{ Str::of($requisicion->sedesDestino())->title() }}
                </td>
            </tr>
        </table>

        <div class="footer" style="margin-top:10rem;">
            <table width="100%">
                <tr>
                    <td width="33%" style="text-align: center; vertical-align: top;"><p class="signature-box">{{ Str::title($requisicion->ficha->NOMBRE) }} (Solicitante)</p></td>
                    <td width="33%" style="text-align: center; vertical-align: top;"><p class="signature-box">{{ Str::title($requisicion->autorizacionJefe()) }} (Jefe Inmediato)</p></td>
                    <td width="33%" style="text-align: center; vertical-align: top;"><p class="signature-box">{{ Str::title($requisicion->autorizacionPresupuesto()) }} (Presupuestos)</p></td>
                    <td width="33%" style="text-align: center; vertical-align: top;"><p class="signature-box">{{ Str::title($requisicion->autorizacionTesoreria()) }} (Tesoreria)</p></td>
                </tr>
            </table>
        </div>

    </div>
</body>
</html>

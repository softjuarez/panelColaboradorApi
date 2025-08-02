<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orden de Compra</title>
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
                        <p style="text-align: right; margin:0; margin-top:1rem;">Fecha: {{ date('d/m/Y', strtotime($orden->FECHA))}}</p>
                    </td>
                </tr>
            </table>
        </div>

        <h2 style="text-align: center; margin-top:3rem; margin-bottom:3rem; font-size: 20px;">Orden de Compra</h2>


        <p><strong>Para:</strong> {{ Str::title($orden->proveedor()) }}</p>

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
            @foreach ($orden->detalles as $detalle)
            @php
                $total += $detalle->VLR_FOB;
            @endphp
            <tr>
                <td>{{ $detalle->DESCRIPCION }}</td>
                <td style="text-align: right;">{{ number_format($detalle->CANT_OC, 2, '.', ',') }}</td>
                <td style="text-align: right;">{{ number_format($detalle->PRECIO_UNITARIO, 2, '.', ',') }}</td>
                <td style="text-align: right;">{{ number_format($detalle->VLR_FOB, 2, '.', ',') }}</td>
            </tr>
            @endforeach
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: right;">Total:</td>
                    <td style="text-align: right;">{{ number_format($total, 2, '.', ',') }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="footer" style="margin-top:10rem;">
            <table width="100%">
                <tr>
                    <td width="40%" style="text-align: center; vertical-align: top;"><p class="signature-box">Universidad Da Vinci</p></td>
                    <td width="40%" style="text-align: center; vertical-align: top;"><p class="signature-box">{{ Str::title($orden->proveedor()) }}</p></td>
                </tr>
            </table>
        </div>

    </div>
</body>
</html>

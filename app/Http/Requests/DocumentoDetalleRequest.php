<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\OrdenDeCompraH;
use App\Models\DocumentoDetalle;

class DocumentoDetalleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'bien_servicio' => ['required'],
            'unidad_medida' => ['required', 'max:15'],
            'cantidad' => ['required', 'numeric', 'gt:0'],
            'precio_unitario' => ['required', 'numeric', 'gt:0'],
            'valor_impuestos' => ['required', 'numeric', 'min:0'],
            'descuento' => ['required', 'numeric', 'min:0'],
            'descripcion' => ['required', 'max:512'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$validator->errors()->any()) {
                $documento = $this->route('documento') ??
                             ($this->route('detalle') ? $this->route('detalle')->documento : null);

                if (!$documento) {
                    $validator->errors()->add('base', 'No se pudo determinar el documento asociado.');
                    return;
                }

                $valorTotalNuevo = ((floatval($this->cantidad) * floatval($this->precio_unitario)) + floatval($this->valor_impuestos)) - floatval($this->descuento);

                $ordenCompra = OrdenDeCompraH::where('NUMERO', $documento->ordcom_h)->first();

                if (!$ordenCompra) {
                    $validator->errors()->add('base', 'No se encontró la orden de compra asociada.');
                    return;
                }

                $sumaDetalles = DocumentoDetalle::whereIn('documento_id', $ordenCompra->documentos->where('estatus', '!=', 4)->pluck('id'))
                    ->when($this->route('detalle'), function ($query) {
                        return $query->where('id', '!=', $this->route('detalle')->id);
                    })
                    ->sum('valor_total');

                $sumaTotal = $sumaDetalles + $valorTotalNuevo;

                if ($sumaTotal > $ordenCompra->VLR_FOB) {
                    $validator->errors()->add(
                        'cantidad',
                        'La suma total de los detalles (' . number_format($sumaTotal, 2) .
                        ') excede el valor TOTAL de la orden (' . number_format($ordenCompra->VLR_FOB, 2) . ').'
                    );
                }
            }
        });
    }


}

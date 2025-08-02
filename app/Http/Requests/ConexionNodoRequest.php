<?php

namespace App\Http\Requests;

use App\Models\Nodo;
use App\Rules\ValidarConexionNodo;
use Illuminate\Foundation\Http\FormRequest;

class ConexionNodoRequest extends FormRequest
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
            'nodo_padre' => [
                'required',
                'exists:nodos,id',
                function ($attribute, $value, $fail) {
                    $nodoHijo = Nodo::find($this->input('nodo_hijo'));
                    if ($nodoHijo && $nodoHijo->esDescendienteDe($value)) {
                        $fail('El nodo padre no puede ser descendiente del nodo hijo.');
                    }
                }
            ],
            'nodo_hijo' => [
                'required',
                'exists:nodos,id',
                'different:nodo_padre',
                new ValidarConexionNodo(Nodo::find($this->input('nodo_padre')))
            ],
        ];
    }

    public function messages()
    {
        return [
            'nodo_hijo.different' => 'El nodo hijo debe ser diferente al nodo padre.',
            'nodo_padre.exists' => 'El nodo padre seleccionado no existe.',
            'nodo_hijo.exists' => 'El nodo hijo seleccionado no existe.',
        ];
    }
}

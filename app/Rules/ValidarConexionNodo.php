<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Nodo;

class ValidarConexionNodo implements ValidationRule
{
    protected $nodoPadre;

    public function __construct($nodoPadre)
    {
        $this->nodoPadre = $nodoPadre;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->nodoPadre) {
            $fail('El nodo padre no existe.');
            return;
        }

        $nodoHijo = Nodo::find($value);
        if (!$nodoHijo) {
            $fail('El nodo hijo no existe.');
            return;
        }

        if ($this->nodoPadre->tipo === Nodo::TIPO_DETALLADO &&
            $nodoHijo->tipo !== Nodo::TIPO_DETALLADO) {
            $fail('Un nodo padre detallado solo puede tener hijos detallados.');
        }
    }

    public function message()
    {
        return 'Un nodo padre detallado solo puede tener hijos detallados.';
    }
}

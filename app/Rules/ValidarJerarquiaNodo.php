<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Nodo;

class ValidarJerarquiaNodo implements ValidationRule
{
    protected $nodo;

    public function __construct(Nodo $nodo)
    {
        $this->nodo = $nodo;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value === $this->nodo->type) {
            return;
        }

        $this->validarComoPadre($value, $fail);

        $this->validarComoHijo($value, $fail);
    }

    protected function validarComoPadre(string $nuevoTipo, Closure $fail): void
    {
        if ($nuevoTipo === Nodo::TIPO_DETALLADO) {
            $hijosInvalidos = $this->nodo->hijos()
                ->where('tipo', '!=', 'D')
                ->exists();

            if ($hijosInvalidos) {
                $fail('No puede cambiar a tipo Detallado porque tiene hijos Resumidos.');
            }
        }
    }

    protected function validarComoHijo(string $nuevoTipo, Closure $fail): void
    {
        if ($nuevoTipo === Nodo::TIPO_RESUMIDO) {
            $padresInvalidos = $this->nodo->padres()
                ->where('tipo', 'D')
                ->exists();

            if ($padresInvalidos) {
                $fail('No puede cambiar a tipo Resumido porque tiene padres Detallados.');
            }
        }
    }
}

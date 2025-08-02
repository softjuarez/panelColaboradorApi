<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class Dpi implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $cleanedValue = Str::of($value)->replaceMatches('/\D/', '');

        if ($cleanedValue->length() !== 13) {
            $fail('El campo :attribute debe contener exactamente 13 dígitos numéricos.');
        }
    }
}

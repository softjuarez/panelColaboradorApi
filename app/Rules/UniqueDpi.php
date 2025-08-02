<?php

namespace App\Rules;

use App\Models\Ficha;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class UniqueDpi implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public $ignore;

    public function __construct($ignore = 0)
    {
        $this->ignore = $ignore;
    }


    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $cleanedValue = Str::of($value)->replaceMatches('/\D/', '');
        $exists = Ficha::where('dpi', $cleanedValue)->whereNot('id', $this->ignore)->exists();

        if ($exists) {
            $fail('El campo :attribute ya fue registrado.');
        }
    }
}

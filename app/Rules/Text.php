<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Text implements ValidationRule
{
    protected $pattern = "/^[\p{L}\p{N}\s().!@#$%^&*;:'\",<>?`~\[\]{}|\\-]*$/u";

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Check if the value matches the regex pattern
        if (!preg_match($this->pattern, $value)) {
            // If it doesn't match, call the fail closure with a custom message
            $fail("El campo {$attribute} contiene caracteres inválidos.");
        }
    }
}

<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class OneRequired implements ValidationRule
{
    protected $other_field;

    public function __construct($other_field)
    {
        $this->other_field = $other_field;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (empty($value) && empty(request()->input($this->other_field))) {
            $fail("Al menos :attribute o $this->other_field deben ser seleccionados");
        }
    }
}

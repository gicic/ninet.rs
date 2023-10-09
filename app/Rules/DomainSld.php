<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DomainSld implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match('/^(?!\-)([a-zA-Zđžćčš\p{Cyrillic}\d\-]{0,62}[a-zA-Zđžćčš\p{Cyrillic}\d]){2,63}/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.custom.domain_sld.regex');
    }
}

<?php

namespace App\Rules;

use App\Models\Country;
use Illuminate\Contracts\Validation\Rule;

class ValidCountry implements Rule
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
        $countriesIds = Country::pluck('id')->toArray();

        return in_array($value, $countriesIds);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('main.invalid_country');
    }
}

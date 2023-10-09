<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class checkHashedPassword implements Rule
{

    protected $table;
    protected $email;

    /**
     * Create a new rule instance.
     *
     * @param string $table
     * @param string $email
     * @return void
     */
    public function __construct($table, $email)
    {
        $this->table = $table;
        $this->email = $email;
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
        $password = \DB::table($this->table)->select('password')->where('email', $this->email)->first();
        if(!isset($password)) return false;
        return \Hash::check($value, $password->password);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.custom.password.wrong');
    }
}

<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class CheckPasswordHash implements Rule
{
    protected $input;

    /**
     * Create a new rule instance.
     *
     * @param string $input
     */
    public function __construct($input)
    {
        $this->input = $input;
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
        return Hash::check($value, $this->input);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Password entered does not match the password we have on record for you.';
    }
}

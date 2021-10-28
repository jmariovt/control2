<?php

namespace XAdmin\Rules;

use Illuminate\Contracts\Validation\Rule;

class RangoPorcentaje implements Rule
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
        return $value >= 5 && $value <= 25; 
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Porcentaje debe ser un valor entre 5% y 25%.';
    }
}

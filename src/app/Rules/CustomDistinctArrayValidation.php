<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CustomDistinctArrayValidation implements Rule
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
    public function passes($attribute, $values)
    {
        // 配列が重複しているかどうかを検知
        $validate = True;
        foreach(array_count_values($values) as $value) {
            if ($value >= 2) $validate = False;
        }
        return $validate;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attributeが重複しています';
    }
}

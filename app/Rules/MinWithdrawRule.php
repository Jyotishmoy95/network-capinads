<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Setting;

class MinWithdrawRule implements Rule
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
        $settings = Setting::select('minimum_withdrawal', 'maximum_withdrawal')->find(1);
        return $value >= $settings->minimum_withdrawal && $value <= $settings->maximum_withdrawal;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be greater than or equal to '.Setting::find(1)->minimum_withdrawal;
    }
}

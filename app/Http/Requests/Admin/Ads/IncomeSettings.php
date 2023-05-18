<?php

namespace App\Http\Requests\Admin\Ads;

use Illuminate\Foundation\Http\FormRequest;

class IncomeSettings extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'credit_type'       => 'required',
            //'self_income'       => 'required|numeric|min:0',
            // 'levels'            => 'required|array',
            // 'levels.*'          => 'required|numeric|min:0',
        ];
    }
}

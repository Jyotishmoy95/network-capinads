<?php

namespace App\Http\Requests\Admin\Packages;

use Illuminate\Foundation\Http\FormRequest;

class CreatePackage extends FormRequest
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
            'package_name'      => 'required|string|unique:packages',
            'amount'            => 'required|numeric|min:1',
            'self_ad_income'    => 'required|numeric|min:0',
            'level_type'        => 'required|string',
            'levels'            => 'required|array',
            'levels.*'          => 'required|numeric',
            'ad_levels'         => 'required|array',
            'ad_levels.*'       => 'required|numeric',
            'referrals'         => 'required|array',
            'referrals.*'       => 'required|numeric',
        ];
    }
}

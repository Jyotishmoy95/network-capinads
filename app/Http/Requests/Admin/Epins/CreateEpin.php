<?php

namespace App\Http\Requests\admin\Epins;

use Illuminate\Foundation\Http\FormRequest;

class CreateEpin extends FormRequest
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
            'package_id'        => 'required|exists:packages,id',
            'quantity'          => 'required|numeric|min:1',
            'member_id'         => 'required|string|exists:members'
        ];
    }
}

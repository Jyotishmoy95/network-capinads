<?php

namespace App\Http\Requests\Activations;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewActivation extends FormRequest
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
            'package'           => ['required', Rule::exists('packages', 'id')->where(function ($query) {
                return $query->where('status', 1);
            })],
            'member_id'         => ['required', 'exists:members']
        ];
    }
}

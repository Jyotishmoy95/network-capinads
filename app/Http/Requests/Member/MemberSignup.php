<?php

namespace App\Http\Requests\Member;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MemberSignup extends FormRequest
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
            'fname'     => 'required|string',
            'lname'     => 'required|string',
            //'position'  => 'required|string',
            'email'     => 'required|email:filter|unique:members',
            'mobile'    => 'required|digits:10|unique:members',
            //'password'  => 'required|confirmed'
            'sponsor'   => ['required', Rule::exists('hirarchies', 'member_id')->where(function ($query) {
                return $query->where('activation_amount', '>', 0);
            })],
            //'placement' => 'required|exists:hirarchies,member_id'
        ];
    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'sponsor.exists' => 'The selected Sponsor ID selected is invalid',
        ];
    }

}

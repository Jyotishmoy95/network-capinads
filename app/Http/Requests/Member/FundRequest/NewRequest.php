<?php

namespace App\Http\Requests\Member\FundRequest;

use Illuminate\Foundation\Http\FormRequest;

class NewRequest extends FormRequest
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
            'transaction_id'    => 'required|string|unique:fund_requests',
            'amount'            => 'required|numeric|min:1',
            'receipt'           => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ];
    }
}

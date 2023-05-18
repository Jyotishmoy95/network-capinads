<?php

namespace App\Http\Requests\Member\Settings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UploadDocuments extends FormRequest
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
            'document_type'     => 'required|in:aadhar,pan,passport,driving_license,other',
            'document_number'   => ['required','string', Rule::unique('member_documents')->where(function ($query) {
                $query->where('member_id', '!=', $this->user()->member_id);
            })],
            'document_photo'    => 'required|image|mimes:jpeg,png,jpg|max:500',
        ];
    }
}

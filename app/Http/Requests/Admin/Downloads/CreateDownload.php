<?php

namespace App\Http\Requests\Admin\Downloads;

use Illuminate\Foundation\Http\FormRequest;

class CreateDownload extends FormRequest
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
            'title' => 'required|string',
            'file'  => 'required|file|mimes:pdf,txt,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,csv|max:1024',
        ];
    }
}

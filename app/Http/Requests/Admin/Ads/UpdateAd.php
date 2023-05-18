<?php

namespace App\Http\Requests\Admin\Ads;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAd extends FormRequest
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
            'ad_title'          => 'required|string',
            'ad_type'           => 'required|string',
            'ad_url'            => 'exclude_if:ad_type,image|required|url',
            'ad_image'          => 'exclude_if:ad_type,url|sometimes|image|mimes:jpeg,jpg,png,gif,webp|max:500',
        ];
    }
}

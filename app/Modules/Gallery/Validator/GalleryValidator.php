<?php

namespace App\Modules\Gallery\Validator;

use Illuminate\Foundation\Http\FormRequest;

class GalleryValidator extends FormRequest
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
    public function rules() {
        return [
            'type' => 'required',
        ];
    }

    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */
   public function messages() {
       return [
           'type.required'  => 'Type is required'
       ];
    }
}

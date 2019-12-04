<?php

namespace App\Modules\Gallery\Validator;

use Illuminate\Foundation\Http\FormRequest;

class GalleryPhotoValidator extends FormRequest
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
            'g_id' => 'required',
        ];
    }

    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */
   public function messages() {
       return [
           'type.required'  => 'Please Select Gallery'
       ];
    }
}

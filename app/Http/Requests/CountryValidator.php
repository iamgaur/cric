<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CountryValidator extends FormRequest
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
        $id = request()->route('id');
        $name_rule = (!empty($id)) ?
                'required|unique_space_check:country,'. $id. '|max:255' : 'required|unique_space_check:country|max:255';
        return [
            'name' => $name_rule,
            'meta_title' => 'required'
        ];
    }

    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */
   public function messages() {
       return [
           'name.required' => 'Name is required',
           'name.unique_space_check' => 'Name already exist in our records',
           'meta_title.required'  => 'Meta Title is required',
       ];
    }

}

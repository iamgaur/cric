<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeamValidator extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $slug = request()->route('slug');
        $name_rule = (!empty($slug)) ?
                'required|unique_space_check:team,'. $slug. '|max:255' : 'required|unique_space_check:team|max:255';
        return [
            'name' => $name_rule,
            'short_name' => 'required'
        ];
    }

   /**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */
   public function messages() {
       return [
           'name.required' => 'Team name is required',
           'name.unique_space_check' => 'Team name already exist in our records',
           'short_name.required'  => 'Short name is required',
       ];
    }
}

<?php

namespace App\Modules\Match\Validator;

use Illuminate\Foundation\Http\FormRequest;

class MatchValidator extends FormRequest
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
        $slug = request()->route('slug');
        $name_rule = (!empty($slug)) ?
                'required|unique_space_check:matches,'. $slug. '|max:255' : 'required|unique_space_check:matches|max:255';
        return [
            'series_id' => 'required',
            'match_title' => $name_rule
        ];
    }

    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */
   public function messages() {
       return [
           'series_id.required'  => 'Series Title is required',
           'match_title.required' => 'Match title is required',
           'match_title.unique_space_check' => 'Match title already exist in our records',
       ];
    }

}

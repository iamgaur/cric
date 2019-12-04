<?php

namespace App\Modules\IccRanking\Validator;

use Illuminate\Foundation\Http\FormRequest;

class IccRankingValidator extends FormRequest
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
            'ranking_type' => 'required',
        ];
    }

    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */
   public function messages() {
       return [
           'ranking_type.required'  => 'ICC Ranking Type is required'
       ];
    }

}

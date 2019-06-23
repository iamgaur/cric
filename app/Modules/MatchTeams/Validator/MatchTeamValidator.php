<?php

namespace App\Modules\MatchTeams\Validator;

use Illuminate\Foundation\Http\FormRequest;

class MatchTeamValidator extends FormRequest
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
            'match_id' => 'required',
            'first_team' => 'required',
            'second_team' => 'required',
        ];
    }

    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */
   public function messages() {
       return [
           'match_id.required'  => 'Match id is required',
           'first_team.required' => 'First team is required',
           'second_team.required' => 'Second team is required',
       ];
    }

}

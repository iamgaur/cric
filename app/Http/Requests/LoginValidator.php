<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginValidator extends FormRequest
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
            'username' => 'required',
            'password' => 'required'
        ];
    }

    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array

     *      */
   public function messages()
   {
       return [
           'username.required' => 'User Name is required',
           'password.required'  => 'Password can not be empty',
       ];
    }
}

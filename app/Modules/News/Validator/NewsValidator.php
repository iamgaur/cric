<?php

namespace App\Modules\News\Validator;

use Illuminate\Foundation\Http\FormRequest;

class NewsValidator extends FormRequest
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
                'required|unique_space_check:news,' . $slug . '|max:255' : 'required|unique_space_check:news|max:255';
        return [
            'title' => $name_rule,
            'description' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages() {
        return [
            'title.required' => 'Match title is required',
            'title.unique_space_check' => 'Match title already exist in our records',
            'description.required' => 'Series Title is required',
        ];
    }

}

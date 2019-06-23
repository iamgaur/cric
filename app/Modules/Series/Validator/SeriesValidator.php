<?php

namespace App\Modules\Series\Validator;

use Illuminate\Foundation\Http\FormRequest;

class SeriesValidator extends FormRequest
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
        $slug = request()->route('slug');
        $name_rule = (!empty($slug)) ?
                'required|unique_space_check:team,'. $slug. '|max:255' : 'required|unique_space_check:team|max:255';
        return [
            'name' => $name_rule,
            'series_start_date' => 'required|date|date_format:Y-m-d|before:series_end_date',
            'series_end_date' => 'required|date|date_format:Y-m-d|after:series_start_date'
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenerationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'generation_head_id'=>'required',
            'date_from'=>'required|before_or_equal:date_to',
            'date_to'=>'required|after_or_equal:date_from',
            'payee_id'=>'required|integer',
            'payee_name'=>'required|string',
            'registered_address'=>'nullable',
            'tin'=>'required',
            'zip_code'=>'nullable',
            'atc_id'=>'required|integer',
            'atc_code'=>'required|string',
            'atc_remarks'=>'nullable',
            'atc_percentage'=>'nullable',
            'include_sign'=>'nullable',
            'reference_number'=>'nullable',
            'accountant_id'=>'required',
            'accountant_name'=>'required',
            'accountant_position'=>'required',
            'accountant_tin'=>'required',
            'accountant_sign'=>'nullable',
        ];
    }

    public function messages() : array

    {

        return [
            'generation_head_id.required' => 'Not able to create generation head.',
            'date_from.required' => 'Date from is a required field.',
            'date_to.required' => 'Date to is a required field.',
            'date_from.before:date_to' => 'Date from must be before or same with date to.',
            'date_to.after:date_from' => 'Date to must be after or same with date from.',
            'no_of_days.required' => 'No. of days is a required field',
            'payee_id.required' => 'Payee is a required field.',
            'payee_name.required' => 'Payee is a required field.',
            'tin.required' => 'Payee TIN is not existing. Kindly update the masterfile.',
            'atc_id.required' => 'ATC Code is a required field.',
            'atc_code.required' => 'ATC Code is a required field.',
            'accountant_id.required' => 'No active accountant was set in the masterfile.',
            'accountant_name.required' => 'No active accountant was set in the masterfile.',
            'accountant_position.required' => 'Accountant position not set in masterfile.',
            'accountant_tin.required' => 'Accountant TIN not set in masterfile.',

        ];

    }
}

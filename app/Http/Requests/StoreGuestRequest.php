<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class StoreGuestRequest extends FormRequest
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
            'visitor_name' => 'required|string|max:255',
            'visitor_email' => 'required|email|max:255',
            'visitor_phoneno' => 'required|string|max:20',
            'purpose' => 'required|string|max:500',
            'entry_time' => 'required|date_format:Y-m-d\TH:i',
            'exit_time' => 'required|date_format:Y-m-d\TH:i|after_or_equal:entry_time',
        ];
    }
    public function messages()
    {
        return [
            'visitor_name.required' => 'Please enter the visitor\'s name.',
            'visitor_name.string' => 'The visitor\'s name must be a valid string.',
            'visitor_name.max' => 'The visitor\'s name should not exceed 255 characters.',

            'visitor_email.required' => 'Please enter the visitor\'s email address.',
            'visitor_email.email' => 'Please enter a valid email address.',
            'visitor_email.max' => 'The email should not exceed 255 characters.',

            'visitor_phoneno.required' => 'Please enter the visitor\'s phone number.',
            'visitor_phoneno.string' => 'The phone number must be a valid string.',
            'visitor_phoneno.max' => 'The phone number should not exceed 20 characters.',

            'purpose.required' => 'Please specify the purpose of the visit.',
            'purpose.string' => 'The purpose must be a valid string.',
            'purpose.max' => 'The purpose should not exceed 500 characters.',

            'entry_time.required' => 'Please enter the entry time.',
            'entry_time.date_format' => 'The entry time must be in the correct format (Y-m-d H:i).',
            'exit_time.required' => 'Please enter the entry time.',
             
            'exit_time.date_format' => 'The exit time must be in the correct format (Y-m-d H:i).',
            'exit_time.after_or_equal' => 'The exit time must be after or equal to the entry time.'
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
}

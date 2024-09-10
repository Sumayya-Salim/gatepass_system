<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreflatRequest extends FormRequest
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
        'flat_no' => [
            'required', 
            'regex:/^(?=.*[a-zA-Z])(?=.*\d)[A-Za-z0-9]+$/', // Must contain both letters and numbers
            'unique:flats,flat_no'
        ],
        'flat_type' => 'required|in:1,2,3', // Assuming 1, 2, 3 are valid flat types
        'furniture_type' => 'required|in:1,2,3', 
    ];
}

public function messages()
{
    return [
        'flat_no.required' => 'The flat number is required.',
        'flat_no.regex' => 'The flat number must contain both letters and numbers.',
        'flat_no.unique' => 'The flat number already exists.',
        'flat_type.required' => 'Please select a flat type.',
        'flat_type.in' => 'The selected flat type is invalid.',
        'furniture_type.required' => 'Please select a furnish type.',
        'furniture_type.in' => 'The selected furnish type is invalid.',
    ];
}
}
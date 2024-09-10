<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class StoreflatownerRequest extends FormRequest
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
            'owner_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phoneno' => 'required|digits:10',
            'password' => 'required|min:6',
            'flat_no' => 'required|exists:flats,id',
            'members' => 'required|numeric|min:1',
            'park_slott' => 'required|in:1,2,3,4',
        ];
    }
    public function messages()
    {
        return [
            'owner_name.required' => 'The owner name is required.',
            'owner_name.string' => 'The owner name must be a string.',
            'owner_name.max' => 'The owner name should not exceed 255 characters.',

            'email.required' => 'The email address is required.',
            'email.email' => 'Please provide a valid email address.',
      

            'phoneno.required' => 'The phone number is required.',
            'phoneno.digits' => 'The phone number must be 10 digits.',

            'password.required' => 'The password is required.',
            'password.min' => 'The password must be at least 6 characters.',

            'flat_no.required' => 'Please select a flat number.',
            'flat_no.exists' => 'The selected flat number is invalid.',

            'members.required' => 'Please enter the number of members.',
            'members.numeric' => 'The number of members must be a valid number.',
            'members.min' => 'There must be at least 1 member.',

            'park_slott.required' => 'Please select a park slot.',
            'park_slott.in' => 'The selected park slot is invalid.',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
}

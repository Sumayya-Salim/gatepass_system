<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSecurityRequest extends FormRequest
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
            'email' => 'required|email',
            'name' => 'required|string|max:255',
            'password' => 'required|min:6',
            'phoneno' => 'required|digits:10',
        ];
    }
    public function messages()
    {
        return [
            'email.required' => 'Email is required',
            'email.email' => 'Please enter a valid email address',
            'name.required' => 'Name is required',
            'name.string' => 'Name must be a valid string',
            'name.max' => 'Name cannot be longer than 255 characters',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 6 characters long',
            'phoneno.required' => 'Phone number is required',
            'phoneno.digits' => 'Phone number must be 10 digits long',
        ];
    }
}

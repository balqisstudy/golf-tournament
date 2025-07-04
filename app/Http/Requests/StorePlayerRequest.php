<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlayerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Add proper authorization logic based on your needs
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'Name' => 'required|string|max:255',
            'Email' => 'required|email|unique:users,Email',
            'Password' => 'required|string|min:8',
        ];
    }

    /**
     * Get the custom error messages for validation.
     */
    public function messages(): array
    {
        return [
            'Name.required' => 'Player name is required',
            'Email.required' => 'Email address is required',
            'Email.email' => 'Please provide a valid email address',
            'Email.unique' => 'This email is already registered',
            'Password.required' => 'Password is required',
            'Password.min' => 'Password must be at least 8 characters'
        ];
    }
}

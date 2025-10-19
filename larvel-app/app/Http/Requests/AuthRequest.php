<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ];

        // Add name & confirm_password validation only for signup
        if ($this->isMethod('post') && $this->routeIs('auth.signup')) {
            $rules['name'] = 'required|string|max:255';
            $rules['confirm_password'] = 'required|string|min:6|same:password';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required for signup',
            'email.required' => 'Email is required',
            'email.email' => 'Please provide a valid email address',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 6 characters',
            'confirm_password.required' => 'Please confirm your password',
            'confirm_password.same' => 'Passwords do not match',
        ];
    }
}

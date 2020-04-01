<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            "firstName" => ["required", "regex:/^[A-z\d]+$/"],
            "lastName" => ["required", "regex:/^[A-z\d]+$/"],
            "username" => ["required", "regex:/^[A-z\d]+$/"],
            "pass" => ["required", "regex:/^[A-z\d]+$/"],
            "email" => "required|email",
        ];
    }
    public function messages()
    {
        return [
            "firstName.required" => "First name is required!",
            "lastName.required" => "Last name is required!",
            "username.required" => "Username is required!",
            "pass.required" => "Password is required!",
            "email.required" => "Password is required!",
        ];
    }
}

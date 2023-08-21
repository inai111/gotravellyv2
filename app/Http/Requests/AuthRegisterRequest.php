<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRegisterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'=>'required|string|min:3|max:120',
            'email'=>'required|unique:users|email',
            // 'password'=>'min:6|confirmed|regex:^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*\W).+$^',
            'password_confirmation'=>"",
            'password'=>'required|min:6|confirmed',
        ];
    }

    protected function passedValidation(): void
    {
        $this->replace($this->validated());
    }
}

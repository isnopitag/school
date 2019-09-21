<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:3'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email requerido',
            'email.max'      => 'Email demasiado largo',
            'email.email'      => 'Email no tiene formato',
            'email.unique'      => 'Email tomando',
            'password.required'      => 'Password Requerido',
            'password.min'      => 'Password debe tener mas de tres caracteres',
        ];
    }
}

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
        //This will be Change for every System.
        //Todo Change it
        return[
            'name' => 'required|string',
            'username' => 'required|string',
            'birth' => 'required|date',
            'sex' => 'required|string|max:1',
            'mobile_phone' => 'required|string',
            'address' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'rfc' => 'string|unique:users',
            'id_role' => 'required|numeric|exists:roles,id',
            'password'=> 'required'
        ];
    }
}
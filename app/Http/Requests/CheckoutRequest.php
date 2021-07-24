<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {

        $emailValidated = auth()->check() ? 'required|email' : 'required|email|unique:users';
        return [
            'email' => $emailValidated,
            'name' => ['required' , 'min:6'],
            'address' => 'required',
            'city' => 'required',
            'province' => 'required',
            'postalcode' => 'required',
            'phone' => 'required'
        ];
    }

    public function messages()
    {
        return[
            'email.unique' => 'You already have an account with email address . Please <a href=" ' .  route('login') .   '">login</a> to continue.'
        ];
    }
}

<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email'         => 'required',
            'password'      => 'required|min:8'
        ];
    }

    public function messages(){
        return [
            'email.required'        => 'البريد الالكتروني أو رقم الهاتف مطلوب',
            'password.required'     => 'كلمة المرور مطلوبة',
            'password.min'          => 'يجب ان لا تقل كلمة المرور عن 8 احرف'
        ];
    }
}

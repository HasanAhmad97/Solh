<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'name'                      => 'required|min:3|max:74',
            'password'                  => 'required|min:3|confirmed',
            'email'                     => 'required|email|unique:users',
            'phone'                     => 'min:10|numeric|unique:users'
        ];
    }

    public function messages(){
        return [
            'name.required'                         => 'الاسم مطلوب',
            'name.min'                              => 'الإسم الذي أدخلته قصير جدا , أقل طول يسمح به : 3',
            'name.max'                              => 'الإسم الذي أدخلته طويل جدا , أكثر طول يسمح به : 74',
            'password.required'                     => 'كلمة المرور مطلوبة',
            'password.min'                          => 'كلمة المرور يجب أن لا تقل عن ثلاثة أحرف',
            'password.password_confirmation'        => 'يجب أن تتوافق كلمة المرور مع تأكيدها',
            'email.required'                        => 'البريد الالكتروني مطلوب',
            'email.email'                           => 'يرجى إدخال بريد صحيح',
            'email.unique'                          => 'البريد الذي إخترته مسجل لعضو أخر',
            'phone.min'                             => 'يجب أن يتكون رقم الهاتف من أرقام فقط وأن لا يقل طوله عن 10 أرقام',
            'phone.numeric'                         => 'يجب أن يتكون رقم الهاتف من أرقام فقط وأن لا يقل طوله عن 10 أرقام',
            'phone.unique'                          => 'رقم الهاتف المدخل مسجل لعضو أخر'
        ];
    }
}

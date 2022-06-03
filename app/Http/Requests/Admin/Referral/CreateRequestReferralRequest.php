<?php

namespace App\Http\Requests\Admin\Referral;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequestReferralRequest extends FormRequest
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
            'title'                 => 'required',
            'contact_name'          => 'required'
        ];
    }
    public function messages(){
        return [
            'title.required'                => 'فضلاً تحقق من كتابتك لإسم الجهة',
            'contact_name.required'         => 'فضلاً تحقق من كتابتك لإسم الجهة في الصادر'
        ];
    }
}

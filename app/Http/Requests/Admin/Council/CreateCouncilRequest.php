<?php

namespace App\Http\Requests\Admin\Council;

use Illuminate\Foundation\Http\FormRequest;

class CreateCouncilRequest extends FormRequest
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
            'room_code'             => 'required',
            'level_code'            => 'required',
            'total_chairs'          => 'required',
        ];
    }

    public function messages(){
        return [
            'room_code.required'            => 'فضلاً تحقق من إدخالك لرمز الغرفة',
            'level_code.required'           => 'فضلاً تحقق من إدخالك لرمز الدور',
            'total_chairs.required'         => 'فضلاً تحقق من إدخالك لعدد الكراسي'
        ];
    }
}

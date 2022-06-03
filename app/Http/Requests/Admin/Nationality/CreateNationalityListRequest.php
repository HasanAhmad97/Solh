<?php

namespace App\Http\Requests\Admin\Nationality;

use Illuminate\Foundation\Http\FormRequest;

class CreateNationalityListRequest extends FormRequest
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
            'title_female'          => 'required',
            'country'               => 'required'
        ];
    }
    public function messages(){
        return [
            'title.required'                => 'فضلاً تحقق من كتابتك لعنوان الجنسية',
            'title_female.required'         => 'فضلاً تحقق من كتابتك لعنوان الجنسية للمؤنث',
            'country.required'              => 'فضلاً تحقق من كتابتك لإسم الدولة'
        ];
    }
}

<?php

namespace App\Http\Requests\Admin\Close;

use Illuminate\Foundation\Http\FormRequest;

class CreateCasesCloseRequest extends FormRequest
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
        ];
    }
    public function messages(){
        return [
            'title.required'                => 'فضلاً تحقق من كتابتك لعنوان الحالة',
        ];
    }

}

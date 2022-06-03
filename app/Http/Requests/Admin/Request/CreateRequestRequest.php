<?php

namespace App\Http\Requests\Admin\Request;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequestRequest extends FormRequest
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
            'husband_name'                  => 'required',
            'husband_nationality_id'        => 'required',
            'husband_national_id'           => 'required',
            'husband_phone'                 => 'required',
            'wife_name'                     => 'required',
            'wife_nationality_id'           => 'required',
            'wife_national_id'              => 'required',
            'wife_phone'                    => 'required',
            'req_type_others'               => 'required_if:req_type,other',
            'second_part_type'              => 'required',
            'req_type'                      => 'required'
        ];
    }

    public function messages(){
        return [
            'husband_name.required'                 => 'فضلاًُ تحقق من كتابتك ل إسم الزوج',
            'husband_nationality_id.required'       => 'فضلاًُ تحقق من كتابتك ل جنسية الزوج',
            'husband_national_id.required'          => 'فضلاًُ تحقق من كتابتك ل رقم الهوية الخاصة بالزوج',
            'husband_phone.required'                => 'فضلاًُ تحقق من كتابتك ل رقم هاتف الزوج',
            'wife_name.required'                    => 'فضلاًُ تحقق من كتابتك ل اسم الزوجة',
            'wife_nationality_id.required'          => 'فضلاًُ تحقق من كتابتك ل رقم الهوية الخاص بالزوجة',
            'wife_national_id.required'             => 'فضلاًُ تحقق من كتابتك ل لرقم الوطني الخاص بالزوجة',
            'wife_phone.required'                   => 'فضلاًُ تحقق من كتابتك ل رقم هاتف الزوجة',
            'req_type_others.required'              => 'فضلاً تحقق من كتابتك لنوع الطلب',
            'second_part_type.required'             => 'فضلاً تحقق من اختيارك للطرف الثاني في الطلب بصورة صحيحة',
            'req_type.required'                     => 'فضلاً تحقق من اختيارك لسبب القضية بصورة صحيحة'
        ];
    }
}

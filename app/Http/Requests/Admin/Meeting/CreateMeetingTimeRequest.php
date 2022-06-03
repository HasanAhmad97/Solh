<?php

namespace App\Http\Requests\Admin\Meeting;

use Illuminate\Foundation\Http\FormRequest;

class CreateMeetingTimeRequest extends FormRequest
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
            'session_time_start'    => 'required',
            'session_time_end'      => 'required'
        ];
    }

    public function messages(){
        return [
            'title.required'                => 'فضلاً تحقق من كتابتك لإسم الجهة',
            'session_time_start.required'   => 'فضلاً تحقق من كتابتك لوقت بداية الجلسة',
            'session_time_end.required'     => 'فضلاً تحقق من كتابتك لوقت نهاية الجلسة'
        ];
    }
}

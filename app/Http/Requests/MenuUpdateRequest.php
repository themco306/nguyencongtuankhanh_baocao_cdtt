<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'link' => 'required|string|max:255',

        ];
    }
    public function messages(): array
    {
        $messages = [
            'same' => 'Mật khẩu không trùng khớp',
            'required' => 'Bạn chưa điền vào đây',
            'size' => 'Vượt quá :size từ!!',
            'min' => 'Phải lớn hơn hoặc bằng  :min ',
            'max' => 'Phải nhỏ hơn hoặc bằng  :max ',
            'mimes' => 'Không hổ trợ định dạng',
        ];
        return [

            'name.required' => $messages['required'],
            'name.max' => $messages['max'] . ' từ',

            'link.required' => $messages['required'],
            'link.max' => $messages['max'] . ' từ',

        ];
    }
}

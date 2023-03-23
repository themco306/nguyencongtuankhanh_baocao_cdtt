<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderUpdateRequest extends FormRequest
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
            'name' => 'required|unique:brand,name|max:255',
            'link' => 'required|string|max:255',
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:4096',

        ];
    }
    public function messages(): array
    {
        $messages = [
            'same' => 'Đã tồn tại',
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


            'image.mimes' => $messages['mimes'],
            'image.max' => 'Dung lượng ảnh quá lớn',

        ];
    }
}

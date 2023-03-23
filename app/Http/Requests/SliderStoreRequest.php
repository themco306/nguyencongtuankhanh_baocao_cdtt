<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderStoreRequest extends FormRequest
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
            'name' => 'required|unique:slider,name|max:255',
            'link' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:4096',

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
            'name.unique' => 'Tên đã được sử dụng. Vui lòng chon tên khác',

            'link.required' => $messages['required'],
            'link.max' => $messages['max'] . ' từ',

            'image.required' => $messages['required'],
            'image.mimes' => $messages['mimes'],
            'image.max' => 'Dung lượng ảnh quá lớn',

        ];
    }
}

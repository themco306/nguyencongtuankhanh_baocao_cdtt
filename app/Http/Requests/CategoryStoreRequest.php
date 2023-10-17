<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryStoreRequest extends FormRequest
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
            'name' => 'required|string|unique:brand,name|unique:category,name|unique:product,name|unique:topic,name|unique:post,title|max:255',
            'metadesc' => 'required|string|max:255',
            'metakey' => 'required|string|max:255',

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

            'metadesc.required' => $messages['required'],
            'metakey.max' => $messages['max'] . ' từ',

            'metakey.required' => $messages['required'],
            'metakey.max' => $messages['max'] . 'từ',

        ];
    }
}

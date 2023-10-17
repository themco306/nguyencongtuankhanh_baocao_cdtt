<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreStoreRequest extends FormRequest
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
            'qty' => 'required|integer|min:1|max:100',
            'price' => 'required|numeric|min:1000',

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

            'qty.min' => $messages['min'],
            'qty.max' => $messages['max'],
            'qty.required' => $messages['required'],

            'price.required' => $messages['required'],
            'price.min' => $messages['min'],

        ];
    }
}

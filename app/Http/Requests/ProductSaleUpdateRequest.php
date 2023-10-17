<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductSaleUpdateRequest extends FormRequest
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
            'discount' => 'required|numeric|min:0|max:100',
            'date_begin' => 'required|required_with:date_end|date',
            'date_end' => 'required|required_with:date_begin|date|after:date_begin',
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

            'discount.required' => $messages['required'],
            'discount.max' => $messages['max'],
            'discount.min' => $messages['min'],


            'date_begin.required' => $messages['required'],
            'date_begin.required_with' => $messages['required'],

            'date_end.required_with' => $messages['required'],
            'date_end.after' => 'Ngày kết thúc phải nhỏ hơn ngày bắt đầu',
            'date_end.required' => $messages['required'],


        ];
    }
}

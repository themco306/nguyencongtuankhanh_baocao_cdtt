<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
            'name' => 'required|string|unique:product,name|unique:brand,name|unique:category,name|unique:post,title|unique:topic,name|max:255',
            'detail' => 'required|string|max:1500',
            'metadesc' => 'required|string|max:255',
            'metakey' => 'required|string|max:255',
            'qty' => 'required|integer|min:1|max:100',
            'price' => 'required|numeric|min:1000',
            'price_sale' => 'nullable|required_with:date_begin,date_end|numeric|min:1000|lt:price',
            'date_begin' => 'nullable|required_with:price_sale|date',
            'date_end' => 'nullable|required_with:price_sale,date_begin|date|after:date_begin',
            'images' => 'required|array|min:2',
            'images.*' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',

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
            'name.max' => $messages['max'] . 'từ',
            'name.unique' => 'Tên đã được sử dụng. Vui lòng chon tên khác',

            'detail.required' => $messages['required'],
            'detail.max' => $messages['max'] . 'từ',

            'metadesc.required' => $messages['required'],

            'metakey.required' => $messages['required'],

            'qty.min' => $messages['min'],
            'qty.max' => $messages['max'],
            'qty.required' => $messages['required'],

            'price.required' => $messages['required'],
            'price.min' => $messages['min'],

            'price_sale.min' => $messages['min'],
            'price_sale.lt' => 'Phải nhỏ hơn giá gốc',
            'price_sale.required_with' => $messages['required'],

            'date_begin.required_with' => $messages['required'],

            'date_end.required_with' => $messages['required'],
            'date_end.after' => 'Ngày kết thúc phải nhỏ hơn ngày bắt đầu',


            'images.required' => 'Hình ảnh không được để trống.',
            'images.min' => 'Bạn cần tải lên ít nhất 2 hình ảnh.',
            'images.*.image' => 'Tập tin phải là hình ảnh.',
            'images.*.mimes' => 'Hình ảnh phải có định dạng jpg, png, jpeg, gif hoặc svg.',
            'images.*.max' => 'Kích thước hình ảnh tối đa là 2048KB.'

        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SiteCheckoutStoreRequest extends FormRequest
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
            'phone' => 'required|numeric|regex:/^\d{10}$/',
            'email' => 'required|email|max:30',
            'address' => 'required|max:50',
            'province' => 'required',
            'ward' => 'required',
            'district' => 'required',
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
            'numeric' => 'Chỉ được nhập số',
            'regex_10' => 'Số điện thoại phải có 10 số'
        ];
        return [
            'phone.required' => $messages['required'],
            'phone.numeric' => $messages['numeric'],
            'phone.regex' => $messages['regex_10'],

            'email.required' => $messages['required'],
            'email.max' => $messages['max'] . ' từ',
            'email.email' => 'Phải có @gmail.com',

            'address.required' => $messages['required'],
            'address.max' => $messages['max'] . ' từ',

            'province.required' => $messages['required'],

            'ward.required' => $messages['required'],

            'district.required' => $messages['required'],



        ];
    }
}

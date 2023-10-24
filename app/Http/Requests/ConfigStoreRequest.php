<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfigStoreRequest extends FormRequest
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
            'name' => 'required|string|max:60',
            'metadesc' => 'required|string|max:255',
            'metakey' => 'required|string|max:255',
            'facebook' => 'required|string|max:150',
            'slogan' => 'required|string|max:60',
            'phone' => 'required|numeric|regex:/^\d{10}$/',
            'email' => 'required|email|max:30',
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

            'numeric' => 'Chỉ được nhập số',

            'regex_10' => 'Số điện thoại phải có 10 số'

        ];
        return [
            'name.required' => $messages['required'],
            'name.max' => $messages['max'] . 'từ',

            'facebook.required' => $messages['required'],
            'facebook.max' => $messages['max'] . 'từ',

            'slogan.required' => $messages['required'],
            'slogan.max' => $messages['max'] . 'từ',

            'metadesc.required' => $messages['required'],
            'metadesc.max' => $messages['max'] . 'từ',

            'metakey.required' => $messages['required'],
            'metadesc.max' => $messages['max'] . 'từ',


            'phone.required' => $messages['required'],
            'phone.numeric' => $messages['numeric'],
            'phone.regex' => $messages['regex_10'],

            'email.required' => $messages['required'],
            'email.max' => $messages['max'] . ' từ',
            'email.email' => 'Phải có @gmail.com',





        ];
    }
}

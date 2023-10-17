<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactStoreRequest extends FormRequest
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
            'email' => 'required|email|max:255',
            'phone' => 'required|regex:/^0[0-9]{9}$/',

            'detail' => 'required|string|max:1500',

        ];
    }
    public function messages(): array
    {
        $messages = [

            'required' => 'Bạn chưa điền vào đây',
            'size' => 'Vượt quá :size từ!!',
            'max' => 'Phải nhỏ hơn hoặc bằng  :max ',
        ];
        return [
            'name.required' => $messages['required'],
            'name.max' => $messages['max'] . ' từ',

            'email.required' => $messages['required'],
            'email.email' => "Phải là email vd:abc@gamil.com",
            'email.max' => $messages['max'] . ' từ',

            'phone.required' => $messages['required'],
            'phone.regex' => 'Phải bắt đầu bằng 0 và tối đa 10 chữ số',

            'detail.required' => $messages['required'],
            'detail.max' => $messages['max'] . ' từ',





        ];
    }
}

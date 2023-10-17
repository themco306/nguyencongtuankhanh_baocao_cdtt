<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'username' => 'required|string|max:255',
            'password' => 'max:255',
            'password_re' => 'same:password|max:255',
            'email' => 'required|email|max:50',
            'phone' => 'required|string|max:12',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',

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

            'username.required' => $messages['required'],
            'username.max' => $messages['max'] . ' từ',

            'password.max' => $messages['max'] . ' từ',

            'password_re.same' => $messages['same'],
            'password_re.max' => $messages['max'] . ' từ',

            'email.required' => $messages['required'],
            'email.max' => $messages['max'] . ' từ',
            'email.email' => 'Phải có @gmail.com',

            'name.required' => $messages['required'],
            'name.max' => $messages['max'] . ' từ',

            'phone.required' => $messages['required'],
            'phone.max' => $messages['max'] . 'số',

            'address.required' => $messages['required'],
            'address.max' => $messages['max'] . 'từ',

            'image.mimes' => $messages['mimes'],
            'image.max' => 'Dung lượng ảnh quá lớn',

        ];
    }
}

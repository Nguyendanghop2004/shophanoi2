<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'old_password' => 'required',
            'password' => 'required|confirmed',
        ];
    }
    public function messages()
    {
        return [
            'old_password.required' => 'Bạn phải nhập mật khẩu hiện tại.',
            'password.required' => 'Bạn phải nhập mật khẩu mới.',
            'password.confirmed' => 'Mật khẩu mới không khớp với mật khẩu xác nhận.',
        ];
    }
}

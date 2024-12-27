<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Xác định xem người dùng có được phép thực hiện yêu cầu này không.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Lấy các quy tắc xác thực sẽ áp dụng cho yêu cầu này.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
           
            'name' => 'required|string|max:255|unique:users,name',

           
            'email' => 'required|string|email|max:255|unique:users,email',

            'password' => 'required|string|min:8|confirmed',

           
            'password_confirmation' => 'required|string|min:8',
        ];
    }

    /**
     * Tùy chỉnh thông báo lỗi cho các quy tắc xác thực
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tên là bắt buộc.',
            'name.unique' => 'Tên này đã tồn tại. Vui lòng chọn tên khác.',
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email này đã được đăng ký.',
            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.confirmed' => 'Mật khẩu và xác nhận mật khẩu không khớp.',
            'password_confirmation.required' => 'Xác nhận mật khẩu là bắt buộc.',
            'password_confirmation.min' => 'Xác nhận mật khẩu phải có ít nhất 8 ký tự.',
        ];
    }
}

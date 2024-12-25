<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Xác định xem người dùng có quyền thực hiện yêu cầu này hay không.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Lấy các quy tắc xác thực cho yêu cầu này.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone_number' => 'required|string|regex:/^(0[3-9])[0-9]{8}$/', 
            'address' => 'required|string|max:255',
            'city_id' => 'required|integer',
            'wards_id' => 'required|integer',
            'province_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'email' => 'required|string|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/', 
            'note' => 'nullable|string|max:500',
        ];
    }

    /**
     * Tùy chỉnh thông báo lỗi xác thực.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'phone_number.required' => 'Số điện thoại là bắt buộc.',
            'phone_number.regex' => 'Số điện thoại không hợp lệ. Vui lòng nhập số điện thoại hợp lệ (ví dụ: 0912345678).',
            'address.required' => 'Địa chỉ là bắt buộc.',
            'city_id.required' => 'Thành phố là bắt buộc.',
            'wards_id.required' => 'Xã/Phường là bắt buộc.',
            'province_id.required' => 'Quận/Huyện là bắt buộc.',
            'name.required' => 'Tên là bắt buộc.',
            'email.required' => 'Email là bắt buộc.',
            'email.regex' => 'Email không hợp lệ. Vui lòng nhập email đúng định dạng (ví dụ: example@domain.com).',
            'note.max' => 'Ghi chú không quá 500 ký tự.',
        ];
    }
}

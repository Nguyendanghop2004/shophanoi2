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
        // Chỉ cho phép nếu người dùng đã đăng nhập (có thể tùy chỉnh)
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
            'phone_number' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'city_id' => 'required|integer',
            'wards_id' => 'required|integer',
            'province_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
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
            'address.required' => 'Địa chỉ là bắt buộc.',
            'city_id.required' => 'Thành phố là bắt buộc.',
            'wards_id.required' => 'Xã/Phường là bắt buộc.',
            'province_id.required' => 'Quận/Huyện là bắt buộc.',
            'name.required' => 'Tên là bắt buộc.',
            'email.required' => 'Email là bắt buộc.',
            'note.max' => 'Ghi chú không quá 500 ký tự.',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ColorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Đảm bảo người dùng được phép thực hiện yêu cầu này
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:colors,name',
            ],
            'sku_color' => [
                'required',
                'string',
                'max:255',
                'unique:colors,sku_color',
            ],
        ];
    }

    /**
     * Get the custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tên màu là bắt buộc.',
            'name.string' => 'Tên màu phải là một chuỗi ký tự.',
            'name.unique' => 'tên đã tồn tại',
            'name.max' => 'Tên màu không được vượt quá 255 ký tự.',
            'sku_color.required' => 'Mã SKU là bắt buộc.',
            'sku_color.string' => 'Mã SKU phải là một chuỗi ký tự.',
            'sku_color.max' => 'Mã SKU không được vượt quá 255 ký tự.',
            'sku_color.unique' => 'Mã SKU này đã tồn tại, vui lòng chọn mã khác.',
        ];
    }
}

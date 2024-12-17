<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSliderRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'link_url' => 'nullable|url|max:255',
            'is_active' => 'boolean',
        ];
        ;
    }

    public function messages(): array
    {
        return [
            'short_description.string' => 'Mô tả ngắn phải là một chuỗi ký tự.',
            'short_description.max' => 'Mô tả ngắn không được vượt quá 500 ký tự.',

            'image_path.image' => 'Tệp tải lên phải là hình ảnh.',
            'image_path.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif, hoặc svg.',
            'image_path.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',

            'link_url.url' => 'Liên kết URL không hợp lệ.',
            'link_url.max' => 'Liên kết URL không được vượt quá 255 ký tự.',

            'is_active.boolean' => 'Trạng thái kích hoạt phải là true hoặc false.',
        ];
    }
}

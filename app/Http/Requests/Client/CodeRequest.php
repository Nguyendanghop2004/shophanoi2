<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class CodeRequest extends FormRequest
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
            'reset_code' => 'required|string|size:6',
        ];
    }
    public function messages()
    {
        return [
            'reset_code.required' => 'Mã code là bắt buộc.',
            'reset_code.string' => 'Mã code phải là một chuỗi ký tự.',
            'reset_code.size' => 'Mã code phải có độ dài 6 ký tự.',
        ];
    }
}

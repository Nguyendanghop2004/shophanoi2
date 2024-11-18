<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateVariantProductRequest extends FormRequest
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
    public function rules()
    {
        return [
            'colorVatiant' => 'required|integer|exists:colors,id',
            'sizes' => 'required|array|min:1',  // Kiểm tra 'sizes' là mảng và ít nhất có 1 phần tử
            'sizes.*' => 'integer|exists:sizes,id',  // Kiểm tra từng size có tồn tại trong bảng sizes
            'price' => 'array|nullable',              // 'price' có thể là mảng hoặc null
            'price.*' => 'nullable|numeric|min:0',    // Giá có thể null hoặc phải là số và >= 0
            'stock' => 'required|array',
            'stock.*' => 'integer|min:0',             // Số lượng phải là số nguyên không âm
            'imagesVatiant' => 'required|array|min:1',  // Mảng ảnh có ít nhất một phần tử
            'imagesVatiant.*' => 'file|image|mimes:jpeg,png,jpg,gif|max:2048', // Quy tắc cho từng ảnh
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('active_tab', 'variantproduct') // Tab form 2
        );
    } 
    public function messages()
    {
        return [
            'colorVatiant.required' => 'Màu sản phẩm là bắt buộc.',
            'colorVatiant.integer' => 'Mã màu phải là một số nguyên.',
            'colorVatiant.exists' => 'Màu sản phẩm này không tồn tại.',

            'sizes.required' => 'Kích thước là bắt buộc.',
            'sizes.array' => 'Kích thước phải là một mảng.',
            'sizes.min' => 'Cần phải chọn ít nhất một kích thước.',

            'price.*.numeric' => 'Giá phải là một số.',
            'price.*.min' => 'Giá phải lớn hơn hoặc bằng 0.',

            'stock.required' => 'Số lượng là bắt buộc.',
            'stock.array' => 'Số lượng phải là một mảng.',
            'stock.*.integer' => 'Số lượng phải là một số nguyên.',
            'stock.*.min' => 'Số lượng không được âm.',

            'imagesVatiant.required' => 'Hình ảnh là bắt buộc.',
            'imagesVatiant.min' => 'Cần phải có ít nhất một hình ảnh.',

            'imagesVatiant.*.file' => 'Hình ảnh phải là một tệp tin.',
            'imagesVatiant.*.image' => 'Tệp tin phải là hình ảnh.',
            'imagesVatiant.*.mimes' => 'Hình ảnh phải có định dạng jpeg, png, jpg hoặc gif.',
            'imagesVatiant.*.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',
        ];
    }

}

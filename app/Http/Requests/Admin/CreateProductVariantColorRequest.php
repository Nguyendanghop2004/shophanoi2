<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateProductVariantColorRequest extends FormRequest
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
            'product_id' => 'required|exists:products,id', // Kiểm tra rằng product_id tồn tại trong bảng products
            'color_id' => 'required|exists:colors,id', // Kiểm tra rằng color_id tồn tại trong bảng colors
            'sizes' => 'required|array', // Kiểm tra rằng sizes là mảng
            'sizes.*' => 'required|string', // Mỗi phần tử trong sizes phải là chuỗi (hoặc kiểu dữ liệu khác nếu cần)
            'pricevariantcolor' => 'required|numeric|min:0', // Kiểm tra giá phải là số và không âm
            'quantityvariantcolor' => 'required|integer|min:0', // Kiểm tra số lượng phải là số nguyên và không âm
            'product_code' => 'required|string|max:255|unique:product_variants,product_code', // Kiểm tra rằng mã sản phẩm là duy nhất trong bảng product_variants
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
            'product_id.required' => 'Product ID là bắt buộc.',
            'color_id.required' => 'Color ID là bắt buộc.',
            'sizes.required' => 'Kích thước là bắt buộc.',
            'sizes.array' => 'Kích thước phải là một mảng.',
            'sizes.*.required' => 'Mỗi kích thước là bắt buộc.',
            'pricevariantcolor.required' => 'Giá là bắt buộc.',
            'quantityvariantcolor.required' => 'Số lượng là bắt buộc.',
            'product_code.unique' => 'Mã sản phẩm phải là duy nhất.',
        ];
    }
}

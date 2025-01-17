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
            'sizes' => 'required', // Kiểm tra rằng sizes là mảng
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
                ->with('active_tab', 'variantproduct')->with('show_modal', 'createVariantColorProduct')->with('colorId', $this->input('color_id'))// Tab form 2
        );
    }
    public function messages()
    {
        return [
            'product_id.required' => 'ID sản phẩm là bắt buộc.',
            'product_id.exists' => 'ID sản phẩm không tồn tại trong hệ thống.',
            'color_id.required' => 'ID màu sắc là bắt buộc.',
            'color_id.exists' => 'ID màu sắc không tồn tại trong hệ thống.',
            'sizes.required' => 'Bạn cần chọn ít nhất một kích thước.',
            'sizes.*.required' => 'Kích thước không được để trống.',
            'sizes.*.string' => 'Kích thước phải là một chuỗi ký tự hợp lệ.',
            'pricevariantcolor.required' => 'Giá sản phẩm là bắt buộc.',
            'pricevariantcolor.numeric' => 'Giá sản phẩm phải là một số hợp lệ.',
            'pricevariantcolor.min' => 'Giá sản phẩm không được nhỏ hơn 0.',
            'quantityvariantcolor.required' => 'Số lượng sản phẩm là bắt buộc.',
            'quantityvariantcolor.integer' => 'Số lượng sản phẩm phải là một số nguyên.',
            'quantityvariantcolor.min' => 'Số lượng sản phẩm không được nhỏ hơn 0.',
            'product_code.required' => 'Mã sản phẩm là bắt buộc.',
            'product_code.string' => 'Mã sản phẩm phải là một chuỗi ký tự.',
            'product_code.max' => 'Mã sản phẩm không được vượt quá 255 ký tự.',
            'product_code.unique' => 'Mã sản phẩm đã tồn tại, vui lòng chọn mã khác.',
        ];
    }
    
}

<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'brand_id' => 'required|exists:brands,id',
            'product_name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug',
            'product_code' => 'required|string|max:255|unique:products,sku',
            'status' => 'required|boolean',
            'description' => 'nullable|string',
            'tagCollection' => 'nullable|array',
            'tagCollection.*' => 'exists:tags,id',
            'tagMaterial' => 'nullable|array',
            'tagMaterial.*' => 'exists:tags,id',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'price' => 'required|numeric|min:0',

            // Kiểm tra các biến thể sản phẩm
            'variants' => 'required|array',
            'variants.*.color_id' => 'required|exists:colors,id',
            'variants.*.sizes' => 'required|array',
            'variants.*.sizes.*.size_id' => 'required|exists:sizes,id',
            'variants.*.sizes.*.stock_quantity' => 'required|integer|min:0',

            // Kiểm tra ảnh sản phẩm
            'images' => 'required|array',
            'images.*' => 'array',
            'images.*.*' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'brand_id.required' => 'Vui lòng chọn thương hiệu cho sản phẩm.',
            'brand_id.exists' => 'Thương hiệu không hợp lệ.',
            'product_name.required' => 'Tên sản phẩm không được bỏ trống.',
            'slug.required' => 'Slug không được bỏ trống.',
            'slug.unique' => 'Slug đã tồn tại, vui lòng chọn slug khác.',
            'product_code.required' => 'Mã sản phẩm không được bỏ trống.',
            'product_code.unique' => 'Mã sản phẩm đã tồn tại, vui lòng chọn mã khác.',
            'status.required' => 'Trạng thái sản phẩm là bắt buộc.',
            'categories.required' => 'Vui lòng chọn ít nhất một danh mục cho sản phẩm.',

            'categories.*.exists' => 'Danh mục không hợp lệ.', 

            'tagCollection.*.exists' => 'Tag không tồn tại.',
            'tagMaterial.*.exists' => 'Tag không tồn tại.',

            'variants.required' => 'Vui lòng nhập biến thể sản phẩm, thêm ảnh, chọn biến thể kích thước và nhập số lượng từng biến thể ',
            'variants.*.color_id.required' => 'Màu của biến thể là bắt buộc.',
            'variants.*.color_id.exists' => 'Màu của biến thể không hợp lệ.',
            'variants.*.sizes.required' => 'Vui lòng nhập biến thể kích thước.',
            'variants.*.sizes.*.size_id.required' => 'Kích thước của biến thể là bắt buộc.',
            'variants.*.sizes.*.size_id.exists' => 'Kích thước của biến thể không hợp lệ.',
            'variants.*.sizes.*.stock_quantity.required' => 'Số lượng cho mỗi biến thể là bắt buộc.',
            'variants.*.sizes.*.stock_quantity.integer' => 'Số lượng phải là số nguyên.',
            'variants.*.sizes.*.stock_quantity.min' => 'Số lượng không thể nhỏ hơn 0.',
            'price.required' => 'Giá cho sản phẩm là bắt buộc.',
            'price.numeric' => 'Giá sản phẩm phải là một số.',
            'price.min' => 'Giá sản phẩm không được nhỏ hơn 0.',

            'images.required' => 'Vui lòng thêm ít nhất một ảnh cho sản phẩm.',
            'images.*.*.file' => 'Ảnh tải lên phải là một tệp hợp lệ.',
            'images.*.*.mimes' => 'Ảnh chỉ chấp nhận định dạng jpg, jpeg, png.',
            'images.*.*.max' => 'Dung lượng ảnh tối đa là 2MB.',
        ];
    }

}

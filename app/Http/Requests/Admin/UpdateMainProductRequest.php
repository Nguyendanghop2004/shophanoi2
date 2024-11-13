<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateMainProductRequest extends FormRequest
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
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'status' => 'required|boolean',
            'slug' => 'required|string|max:255|unique:products,slug,' . $this->route('id'),
            'product_code' => 'required|string|max:50',
            'brand_id' => 'required|exists:brands,id',
            'description' => 'nullable|string',
            'tagCollection' => 'array',
            'tagCollection.*' => 'integer|exists:tags,id',
            'tagMaterial' => 'array',
            'tagMaterial.*' => 'integer|exists:tags,id',
            'categories' => 'required|array',
            'categories.*' => 'required|integer|exists:categories,id',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            redirect()->back()
                      ->withErrors($validator)
                      ->withInput()
                      ->with('active_tab', 'mainproduct') // Tab form 1
        );
    }
    public function messages()
    {
        return [
            'product_name.required' => 'Tên sản phẩm là bắt buộc.',
            'product_name.string' => 'Tên sản phẩm phải là một chuỗi.',
            'product_name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự.',

            'price.required' => 'Giá là bắt buộc.',
            'price.numeric' => 'Giá phải là một số.',
            'price.min' => 'Giá phải lớn hơn hoặc bằng 0.',

            'status.required' => 'Trạng thái là bắt buộc.',
            'status.boolean' => 'Trạng thái phải là true hoặc false.',

            'slug.required' => 'Slug là bắt buộc.',
            'slug.string' => 'Slug phải là một chuỗi.',
            'slug.max' => 'Slug không được vượt quá 255 ký tự.',
            'slug.unique' => 'Slug đã tồn tại. Vui lòng chọn một slug khác.',

            'product_code.required' => 'Mã sản phẩm là bắt buộc.',
            'product_code.string' => 'Mã sản phẩm phải là một chuỗi.',
            'product_code.max' => 'Mã sản phẩm không được vượt quá 50 ký tự.',

            'brand_id.required' => 'ID thương hiệu là bắt buộc.',
            'brand_id.exists' => 'ID thương hiệu không tồn tại.',

            'description.string' => 'Mô tả phải là một chuỗi.',

            'tagCollection.array' => 'Tag Collection phải là một mảng.',
            'tagCollection.*.integer' => 'Mỗi tag trong Tag Collection phải là một số nguyên.',
            'tagCollection.*.exists' => 'Tag không tồn tại.',

            'tagMaterial.array' => 'Tag Material phải là một mảng.',
            'tagMaterial.*.integer' => 'Mỗi tag trong Tag Material phải là một số nguyên.',
            'tagMaterial.*.exists' => 'Material không tồn tại.',

            'categories.required' => 'Các danh mục là bắt buộc.',
            'categories.array' => 'Các danh mục phải là một mảng.',
            'categories.*.required' => 'ID danh mục là bắt buộc.',
            'categories.*.integer' => 'Mỗi danh mục phải là một số nguyên.',
            'categories.*.exists' => 'Danh mục không tồn tại.',
        ];
    }

}

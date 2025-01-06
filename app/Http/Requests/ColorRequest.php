<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ColorRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('id');

        return [
            'name' => 'required|string|max:255|unique:colors,name,' . $id,
            'sku_color' => 'required|string|max:255|unique:colors,sku_color,' . $id,
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên màu sắc là bắt buộc.',
            'name.unique' => 'Tên màu sắc đã tồn tại.',
            'sku_color.required' => 'Mã màu sắc là bắt buộc.',
            'sku_color.unique' => 'Mã màu sắc đã tồn tại.',
        ];
    }
}

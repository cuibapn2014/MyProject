<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductionRequestValidator extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'detail_order_id' => 'required',
            'code' => 'required|unique:production_requests,code',
            'image.0' => 'nullable|image|max:3000',
            'name' => 'required',
            'amount' => 'required|min:1'
        ];
    }

    public function messages()
    {
        return [
            //
            'detail_order_id.required' => 'Vui lòng chọn đơn hàng',
            'code.required' => 'Không được để trống mã sản phẩm',
            'image.0.image' => 'File được tải lên không phải là hình ảnh',
            'name.required' => 'Tên sản phẩm không được để trống',
            'amount.required' => 'Số lượng không được để trống',
            'amount.min' => 'Số lượng ít nhất phải là 1',
            'image.0.max' => 'Ảnh tải lên vượt mức cho phép 3MB',
            'code.unique' => 'Mã sản phẩm bị trùng. Vui lòng thử lại'
        ];
    }
}

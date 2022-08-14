<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanRequest extends FormRequest
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
            'id_production_request' => 'required|exists:production_requests,id',
            'code' => 'required|unique:plan_productions,code,'.$this->id.',id',
            'id_ingredient.0' => 'required|exists:ingredients,id',
            'ingredient_amount.0' => 'required|min:1',
            'name_product' => 'required',
            'quota' => 'required|min:1',
            'completed' => 'min:0'
        ];
    }

    public function messages()
    {
        return [
            //
            'id_production_request.required' => 'Đề nghị sản xuất không được để trống',
            'code.required' => 'Mã kế hoạch không được để trống',
            'name_product.required' => 'Tên sản phẩm không được để trống',
            'id_ingredient.0.required' => 'Nguyên vật liệu không được để trống',
            'id_ingredient.0.exists' => 'Nguyên vật liệu không tồn tại',
            'id_production_request.exists' => 'Đề nghị sản xuất không tồn tại',
            'ingredient_amount.0.required' => 'Số lượng nguyên vật liệu không được để trống',
            'quota.required' => 'Số lượng sản phẩm không được để trống',
            'quota.min' => 'Số lượng sản phẩm không được nhỏ hơn 1',
            'ingredient_amount.0.min' => 'Số lượng nguyên vật liệu không được nhỏ hơn 1',
            'completed.min' => 'Số lượng hoàn thành không được nhỏ hơn 0'
        ];
    }
}

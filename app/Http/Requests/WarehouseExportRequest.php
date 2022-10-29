<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WarehouseExportRequest extends FormRequest
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
            'code' => 'required',
            'type' => 'required|min:1|max:3',
            'id_ingredient' => 'required|exists:ingredients,id',
            'amount' => 'required|min:1|numeric',
            'export_date' => 'required|date',
            'price' => 'required|numeric|gt:0'
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
            'required' => 'Không được để trống',
            'exists' => 'Không tồn tại trong hệ thống',
            'numeric' => 'Giá trị phải là số nguyên',
            'date' => 'Định dạng ngày không hợp lệ',
            'price.gt' => 'Đơn giá không được bằng 0'
        ];
    }
}

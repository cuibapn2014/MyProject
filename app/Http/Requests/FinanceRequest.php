<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FinanceRequest extends FormRequest
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
            'type' => 'required',
            'code' => 'required',
            'title' => 'required',
            'total' => 'required|integer',
            'create_date' => 'required|date'
        ];
    }

    public function messages()
    {
        return [
            //
            'required' => 'Không được bỏ trống',
            'integer' => 'Giá trị phải là số nguyên',
            'date' => 'Định dạng ngày không hợp lệ'
        ];
    }
}

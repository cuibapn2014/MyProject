<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
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
            'name' => 'required',
            'phone_number' => 'required|digits:10|unique:customers,phone_number,'.$this->id.',id',
            'address' => 'required',            
        ];
    }

    public function messages()
    {
        return [
            //
            'name.required' => 'Tên khách hàng không được để trống',
            'phone_number.required' => 'Số điện thoại không được để trống',
            'phone_number.digits' => 'Số điện thoại không hợp lệ',
            'phone_number.unique' => 'Số điện thoại đã tồn tại trong ứng dụng',
            'address.required' => 'Địa chỉ không được để trống',            
        ];
    }
}

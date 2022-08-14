<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProviderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
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
            'name' => 'required|unique:providers,name,'.$this->id.',id',
            'phone_number' => 'required|digits:10|unique:providers,phone_number,'.$this->id.',id'
        ]; 
    }

    public function messages(){
        return [
            'name.required' => 'Tên nhà cung cấp không được để trống',
            'name.unique' => 'Nhà cung cấp này đã tồn tại',
            'phone_number.required' => 'Số điện thoại không được để trống',
            'phone_number.digits' => 'Số điện thoại không hợp lệ',
            'phone_number.unique' => 'Số điện thoại này đã có nhà cung cấp',
        ];
    }
}

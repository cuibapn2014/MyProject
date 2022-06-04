<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function index()
    {
        return view('admin.manage.order.order', ['orders' => Order::all()]);
    }

    public function create()
    {
        return view('admin.manage.order.createOrder');
    }

    public function store(Request $req)
    {
        if ($req->productType === 'available') $this->validateProductAvailable($req);
        else $this->validateProductUnavailable($req);
        return back();
    }

    public function update(Request $req, $id)
    {
    }

    public function delete($id)
    {
    }

    private function validateProductAvailable($req)
    {
        $this->validate(
            $req,
            [
                'fullname' => 'required',
                'phone_number' => 'required|numeric|digits:10',
                'province' => 'required',
                'district' => 'required',
                'ward' => 'required',
                'address' => 'required',
                'product_name' => 'requried',
                'size' => 'required',
                'quantity' => 'min:1',
                'category' => 'required',
                'fabric' => 'required',
                'fabric_owner' => 'required',
                'quality' => 'required',
                'totalPrice' => 'required',
                'duration' => 'required'
            ],
            [
                'fullname.required' => 'Tên khách hàng không được để trống',
                'phone_number.required' => 'Số điện thoại không được để trống',
                'phone_number.numeric' => 'Số điện thoại không hợp lệ',
                'phone_number.digits' => 'Số điện thoại không hợp lệ',
                'province.required' => 'Không được để trống Tỉnh/Thành Phố',
                'district.required' => 'Không được để trống Quận/Huyện',
                'ward.required' => 'Không được để trống Phường/Xã',
                'address.required' => 'Không được để trống địa chỉ',
                'product_name.required' => 'Không được để trống tên sản phẩm',
                'size.required' => 'Không được để trống kích thước sản phẩm',
                'quantity.required' => 'Không được để trống sớ lượng sản phẩm',
                'category.required' => 'Không được để trống danh mục sản phẩm',
                'fabric.required' => 'Không được để trống loại vải',
                'fabric_owner.required' => 'Không được để trống nguồn cung cấp vải',
                'quality.required' => 'Không được để trống chất lượng sản phẩm',
                'totoPrice.required' => 'Không được để trống tổng số tiền',
                'duration.required' => 'Không được để trống ngày trả đơn'
            ]
        );
    }

    private function validateProductUnavailable($req)
    {
        $this->validate(
            $req,
            [
                'fullname' => 'required|min:6',
                'phone_number' => 'required|numeric|digits:10',
                'province' => 'required',
                'district' => 'required',
                'ward' => 'required',
                'address' => 'required',
                'product_name' => 'requried',
                'size' => 'required',
                'quantity' => 'min:1',
                'category' => 'required',
                'fabric' => 'required',
                'fabric_owner' => 'required',
                'duration' => 'required',
                'price' => 'required|numeric'
            ],
            [
                'fullname.required' => 'Tên khách hàng không được để trống',
                'phone_number.required' => 'Số điện thoại không được để trống',
                'phone_number.numeric' => 'Số điện thoại không hợp lệ',
                'phone_number.digits' => 'Số điện thoại không hợp lệ',
                'province.required' => 'Không được để trống Tỉnh/Thành Phố',
                'district.required' => 'Không được để trống Quận/Huyện',
                'ward.required' => 'Không được để trống Phường/Xã',
                'address.required' => 'Không được để trống địa chỉ',
                'product_name.required' => 'Không được để trống tên sản phẩm',
                'size.required' => 'Không được để trống kích thước sản phẩm',
                'quantity.required' => 'Không được để trống sớ lượng sản phẩm',
                'category.required' => 'Không được để trống danh mục sản phẩm',
                'fabric.required' => 'Không được để trống loại vải',
                'fabric_owner.required' => 'Không được để trống nguồn cung cấp vải',
                'quality.required' => 'Không được để trống chất lượng sản phẩm',
                'price.required' => 'Không được để trống giá tiền',
                'price.numeric' => 'Giá tiền không hợp lệ',
                'duration.required' => 'Không được để trống ngày trả đơn'
            ]
        );
    }
}

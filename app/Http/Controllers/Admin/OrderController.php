<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetailOrder;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

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
        $file_name = null;
        $address = $req->address . ', ' . $req->ward . ' - ' . $req->district . ' - ' . $req->province;

        if ($req->hasFile('image')) {
            $file = $req->file('image')[0];
            $extension = $file->getClientOriginalExtension();
            $accept = array("png", "jpg", "jpeg", "bmp");

            if (!in_array($extension, $accept))
                return back()->with('error', 'Định dạng ảnh không hợp lệ! Vui lòng thử lại');

            $file_name = current(explode('.', $extension)) . '_' . time() . '.' . $extension;
            $file->move('img', $file_name);
        }

        $order = Order::create([
            'TenKhachHang' => $req->fullname,
            'SoDienThoai' => $req->phone_number,
            'DiaChi' => $address,
            'NgayTraDon' => $req->duration
        ]);

        if ($req->productType === 'available') {
            $this->validateProductAvailable($req);
            $orderDetail = DetailOrder::create([
                'id_DonHang' => $order->id,
                'TenSP' => $req->product_name,
                'id_DanhMuc' => $req->category,
                'id_LoaiVai' => $req->fabric,
                'id_PhuLieu' => $req->ingredient,
                'SoLuong' => $req->quantity,
                'KichThuoc' => $req->size,
                'id_ChatLuong' => $req->quality,
                'TongTien' => $req->totalPrice,
                'TienCoc' => $req->deposit,
                'LoaiHang' => 'Hàng may',
                'image' => $file_name
            ]);
        } else {
            $this->validateProductUnavailable($req);
            $orderDetail = DetailOrder::create([
                'id_DonHang' => $order->id,
                'TenSP' => $req->product_name,
                'id_DanhMuc' => $req->category,
                'id_LoaiVai' => $req->fabric,
                'id_PhuLieu' => $req->ingredient,
                'SoLuong' => $req->quantity,
                'KichThuoc' => $req->size,
                'id_ChatLuong' => $req->quality,
                'LoaiHang' => 'Hàng mẫu',
                'image' => $file_name,
                'TongTien' => $req->price * $req->quantity
            ]);
        }

        return back();
    }

    public function edit($id)
    {
        return view('admin.manage.order.editOrder', ['order' => Order::with([
            'detail',
            'detail.category',
            'detail.fabric',
            'detail.ingredient',
            'detail.quality'
        ])->findOrFail($id)]);
    }

    public function update(Request $req, $id)
    {
        $file_name = null;
        $oldImg = Order::findOrFail($id)->detail->image;
        $address = $req->address . ', ' . $req->ward . ' - ' . $req->district . ' - ' . $req->province;

        if ($req->hasFile('image')) {
            if ($oldImg != null) {
                File::delete(public_path("img/" . $oldImg));
            }
            $file = $req->file('image')[0];
            $extension = $file->getClientOriginalExtension();
            $accept = array("png", "jpg", "jpeg", "bmp");

            if (!in_array($extension, $accept))
                return back()->with('error', 'Định dạng ảnh không hợp lệ! Vui lòng thử lại');

            $file_name = current(explode('.', $extension)) . '_' . time() . '.' . $extension;
            $file->move('img', $file_name);
        }

        if ($req->productType === 'available') {
            $this->validateProductAvailable($req);
            $orderDetail = DetailOrder::where('id_DonHang', $id)->update([
                'TenSP' => $req->product_name,
                'id_DanhMuc' => $req->category,
                'id_LoaiVai' => $req->fabric,
                'id_PhuLieu' => $req->ingredient,
                'SoLuong' => $req->quantity,
                'KichThuoc' => $req->size,
                'id_ChatLuong' => $req->quality,
                'TongTien' => $req->totalPrice,
                'TienCoc' => $req->deposit,
                'LoaiHang' => 'Hàng may',
                'image' => $file_name != null ? $file_name : $oldImg
            ]);
        } else {
            $this->validateProductUnavailable($req);
            $orderDetail = DetailOrder::where('id_DonHang', $id)->update([
                'TenSP' => $req->product_name,
                'id_DanhMuc' => $req->category,
                'id_LoaiVai' => $req->fabric,
                'id_PhuLieu' => $req->ingredient,
                'SoLuong' => $req->quantity,
                'KichThuoc' => $req->size,
                'id_ChatLuong' => $req->quality,
                'LoaiHang' => 'Hàng mẫu',
                'image' => $file_name != null ? $file_name : $oldImg,
                'TongTien' => $req->price * $req->quantity
            ]);
        }

        $order = Order::findOrFail($id);
        $order->update([
            'TenKhachHang' => $req->fullname,
            'SoDienThoai' => $req->phone_number,
            'DiaChi' => $address,
            'NgayTraDon' => $req->duration,
        ]);

        $order->updated_at = now();
        $order->save();

        return back()->with('success', 'Cập nhật thành công');
    }

    public function delete($id)
    {
        Order::findOrFail($id)->detail()->delete();
        Order::findOrFail($id)->delete();
        return back()->with('success', 'Đã xóa');
    }

    private function validateProductAvailable($req)
    {
        $validator = Validator::make(
            $req->all(),
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
                'duration' => 'required|date',
                'image.0' => 'required|mimes:jpeg,jpg,png,bmp|max:3000'
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
                'duration.required' => 'Không được để trống ngày trả đơn',
                'image.0.required' => 'Bạn chưa chọn ảnh sản phẩm',
                'image.0.mimes' => 'Định dạng file ảnh không hợp lệ',
                'image.0.max' => 'Dung lượng tối đa của hình ảnh không phải nhỏ hơn 3MB'
            ]
        );
    }

    private function validateProductUnavailable($req)
    {
        $validator = Validator::make(
            $req->all(),
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
                'duration' => 'required|date',
                'price' => 'required|numeric',
                'image.0' => 'required|mimes:jpeg,jpg,png,bmp|max:3000',
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
                'duration.required' => 'Không được để trống ngày trả đơn',
                'image.0.required' => 'Bạn chưa chọn ảnh sản phẩm',
                'image.0.mimes' => 'Định dạng file ảnh không hợp lệ',
                'image.0.max' => 'Dung lượng tối đa của hình ảnh không phải nhỏ hơn 3MB'
            ]
        );
    }
}

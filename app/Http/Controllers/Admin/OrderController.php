<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetailOrder;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrderExport;
use App\Models\Customer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    //
    public function index()
    {
        return view('admin.manage.order.order', ['orders' => Order::with([
            'detail',
            'detail.category',
            'detail.ingredient',
            'detail.quality',
        ])->orderByDesc('created_at')->paginate(25)]);
    }

    public function create()
    {
        return view('admin.manage.order.createOrder');
    }

    public function store(Request $req)
    {
        DB::beginTransaction();
        try {
            $file_name = null;
            $address = $req->address . ', ' . $req->ward . ' - ' . $req->district . ' - ' . $req->province;
            if (!$req->hasFile('image')) return back()->withErrors(['image' => 'Bạn chưa thêm ảnh cho sản phẩm']);

            if ($req->productType === 'available') {
                $validator = Validator::make(
                    $req->all(),
                    [
                        'fullname' => 'required',
                        'phone_number' => 'required|numeric|digits:10',
                        'province' => 'required',
                        'district' => 'required',
                        'ward' => 'required',
                        'address' => 'required',
                        // 'product_name' => 'required',
                        // 'weight.*' => 'required',
                        // 'height.*' => 'required',
                        'quantity.*' => 'min:1',
                        'category' => 'required',
                        // 'fabric' => 'required',
                        // 'fabric_owner' => 'required',
                        'quality' => 'required',
                        'totalPrice' => 'required',
                        // 'duration' => 'required|date',
                        'image.0' => 'mimes:jpeg,jpg,png,bmp|max:3000'
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
                        // 'product_name.required' => 'Không được để trống tên sản phẩm',
                        // 'weight.*.required' => 'Không được để trống thuộc tính cân nặng',
                        // 'height.*.required' => 'Không được để trống thuộc tính chiều cao',
                        // 'quantity.*.required' => 'Không được để trống sớ lượng sản phẩm',
                        // 'category.required' => 'Không được để trống danh mục sản phẩm',
                        // 'fabric.required' => 'Không được để trống loại vải',
                        // 'fabric_owner.required' => 'Không được để trống nguồn cung cấp vải',
                        'quality.required' => 'Không được để trống chất lượng sản phẩm',
                        'totalPrice.required' => 'Không được để trống tổng số tiền',
                        // 'duration.required' => 'Không được để trống ngày trả đơn',
                        'image.0.mimes' => 'Định dạng file ảnh không hợp lệ',
                        'image.0.max' => 'Dung lượng tối đa của hình ảnh phải nhỏ hơn 3MB'
                    ]
                );

                if ($validator->fails()) {
                    return back()->withErrors($validator)->withInput();
                }


                $order = Order::create([
                    'TenKhachHang' => $req->fullname,
                    'SoDienThoai' => $req->phone_number,
                    'DiaChi' => $address,
                    'NgayTraDon' => $req->duration,
                    'id_NhanVien' => Auth::user()->id,
                    'TongTien' => $req->totalPrice
                ]);

                if ($req->hasFile('image')) {
                    $file = $req->image[0];
                    $extension = $file->getClientOriginalExtension();
                    $accept = array("png", "jpg", "jpeg", "bmp");

                    if (!in_array($extension, $accept))
                        return back()->with('error', 'Định dạng ảnh không hợp lệ! Vui lòng thử lại');

                    $file_name = current(explode('.', $file->getClientOriginalName())) . '_' . time() . '.' . $extension;
                    $file->move('img', $file_name);
                }

                $orderDetail = DetailOrder::create([
                    'id_DonHang' => $order->id,
                    'TenSP' => $req->product_name,
                    'id_DanhMuc' => $req->category,
                    // 'id_LoaiVai' => $req->fabric,
                    // 'id_PhuLieu' => $req->ingredient,
                    'id_ChatLuong' => $req->quality ? $req->quality : 1,
                    'TongTien' => $req->total,
                    'TienCoc' => $req->deposit,
                    'ThanhToanBS' => $req->paid,
                    'NguonCungCap' => $req->fabric_owner == 'customer' ? "Khách hàng" : "Công ty",
                    'LoaiHang' => 'Hàng may',
                    'image' => $file_name,
                    'Gia' => $req->price,
                    'VaiChinh' => $req->fabric_main,
                    'VaiLot' => $req->fabric_lining,
                    'VaiPhu' => $req->fabric_extra,
                    'GhiChu' => $req->note
                ]);
            } else {
                $validator = Validator::make(
                    $req->all(),
                    [
                        'fullname' => 'required',
                        'phone_number' => 'required|numeric|digits:10',
                        'province' => 'required',
                        'district' => 'required',
                        'ward' => 'required',
                        'address' => 'required',
                        'product_name' => 'required',
                        // 'weight.*' => 'required',
                        // 'height.*' => 'required',
                        'quantity.*' => 'min:1',
                        'category' => 'required',
                        // 'fabric' => 'required',
                        // 'fabric_owner' => 'required',
                        // 'duration' => 'required|date',
                        'price' => 'required|numeric',
                        'image.0' => 'mimes:jpeg,jpg,png,bmp|max:3000',
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
                        // 'weight.*.required' => 'Không được để trống thuộc tính cân nặng',
                        // 'height.*.required' => 'Không được để trống thuộc tính chiều cao',
                        'quantity.*.required' => 'Không được để trống sớ lượng sản phẩm',
                        'category.required' => 'Không được để trống danh mục sản phẩm',
                        // 'fabric.required' => 'Không được để trống loại vải',
                        // 'fabric_owner.required' => 'Không được để trống nguồn cung cấp vải',
                        'quality.required' => 'Không được để trống chất lượng sản phẩm',
                        // 'price.required' => 'Không được để trống giá tiền',
                        'price.numeric' => 'Giá tiền không hợp lệ',
                        // 'duration.required' => 'Không được để trống ngày trả đơn',
                        'image.0.mimes' => 'Định dạng file ảnh không hợp lệ',
                        'image.0.max' => 'Dung lượng tối đa của hình ảnh không phải nhỏ hơn 3MB'
                    ]
                );

                if ($validator->fails()) {
                    return back()->withInput()->withErrors($validator);
                }

                $order = Order::create([
                    'TenKhachHang' => $req->fullname,
                    'SoDienThoai' => $req->phone_number,
                    'DiaChi' => $address,
                    'NgayTraDon' => $req->duration,
                    'id_NhanVien' => Auth::user()->id,
                    'TongTien' => $req->totalPrice
                ]);

                if ($req->hasFile('image')) {
                    $file = $req->image[0];
                    $extension = $file->getClientOriginalExtension();
                    $accept = array("png", "jpg", "jpeg", "bmp");

                    if (!in_array($extension, $accept))
                        return back()->with('error', 'Định dạng ảnh không hợp lệ! Vui lòng thử lại');

                    $file_name = current(explode('.', $file->getClientOriginalName())) . '_' . time() . '.' . $extension;
                    $file->move('img', $file_name);
                }

                $orderDetail = DetailOrder::create([
                    'id_DonHang' => $order->id,
                    'TenSP' => $req->product_name,
                    'id_DanhMuc' => $req->category,
                    // 'id_LoaiVai' => $req->fabric,
                    // 'id_PhuLieu' => $req->ingredient,
                    'id_ChatLuong' => $req->quality ? $req->quality : 1,
                    'NguonCungCap' => $req->fabric_owner == 'customer' ? "Khách hàng" : "Công ty",
                    'LoaiHang' => 'Hàng mẫu',
                    'image' => $file_name,
                    'Gia' => $req->price,
                    'TongTien' => $req->total,
                    'ThanhToanBS' => $req->paid,
                    'VaiChinh' => $req->fabric_main,
                    'VaiLot' => $req->fabric_lining,
                    'VaiPhu' => $req->fabric_extra,
                    'GhiChu' => $req->note
                ]);
            }

            Customer::updateOrCreate([
                'phone_number' => $req->phone_number
            ],[
                'name' => $req->fullname,
                'phone_number' => $req->phone_number,
                'address' => $address,
                'creator' => auth()->user()->id
            ]);

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            throw $ex;
        }

        return redirect()->route('admin.order.index')->with('success', 'Thêm đơn hàng thành công');
    }

    public function edit($id)
    {
        return view('admin.manage.order.editOrder', ['order' => Order::with([
            'detail',
            'detail.category',
            'detail.quality',
        ])->findOrFail($id)]);
    }

    public function update(Request $req, $id)
    {
        DB::beginTransaction();
        try {
            $file_name = null;
            $oldImg = Order::findOrFail($id)->detail->image;
            $address = $req->address . ', ' . $req->ward . ' - ' . $req->district . ' - ' . $req->province;

            $detail = DetailOrder::where('id_DonHang', $id)->first();

            if ($req->productType === 'available') {
                $this->validateProductAvailable($req);
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
                    File::delete(public_path("img/" . $oldImg));
                    $file->move('img', $file_name);
                }

                $orderDetail = DetailOrder::where('id_DonHang', $id)->update([
                    'TenSP' => $req->product_name,
                    'id_DanhMuc' => $req->category,
                    // 'id_LoaiVai' => $req->fabric,
                    // 'id_PhuLieu' => $req->ingredient,
                    'id_ChatLuong' => $req->quality,
                    'TongTien' => $req->total,
                    'Gia' => $req->price,
                    'NguonCungCap' => $req->fabric_owner == 'customer' ? "Khách hàng" : "Công ty",
                    'TienCoc' => $req->deposit,
                    'ThanhToanBS' => $req->paid,
                    'LoaiHang' => 'Hàng may',
                    'image' => $file_name != null ? $file_name : $oldImg,
                    'VaiChinh' => $req->fabric_main,
                    'VaiLot' => $req->fabric_lining,
                    'VaiPhu' => $req->fabric_extra,
                    'GhiChu' => $req->note
                ]);
            } else {
                $this->validateProductUnavailable($req);

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
                    File::delete(public_path("img/" . $oldImg));
                    $file->move('img', $file_name);
                }

                $orderDetail = DetailOrder::where('id_DonHang', $id)->update([
                    'TenSP' => $req->product_name,
                    'id_DanhMuc' => $req->category,
                    // 'id_LoaiVai' => $req->fabric,
                    // 'id_PhuLieu' => $req->ingredient,
                    'id_ChatLuong' => $req->quality,
                    'NguonCungCap' => $req->fabric_owner == 'customer' ? "Khách hàng" : "Công ty",
                    'LoaiHang' => 'Hàng mẫu',
                    'image' => $file_name != null ? $file_name : $oldImg,
                    'Gia' => $req->price,
                    'TongTien' => $req->total,
                    'ThanhToanBS' => $req->paid,
                    'VaiChinh' => $req->main,
                    'VaiChinh' => $req->fabric_main,
                    'VaiLot' => $req->fabric_lining,
                    'VaiPhu' => $req->fabric_extra,
                    'GhiChu' => $req->note
                ]);
            }

            $order = Order::findOrFail($id);
            $order->update([
                'TenKhachHang' => $req->fullname,
                'SoDienThoai' => $req->phone_number,
                'DiaChi' => $address,
                'NgayTraDon' => $req->duration,
                'TongTien' => $req->totalPrice
            ]);

            $order->updated_at = now();
            $order->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            throw $ex;
        }

        return redirect()->route('admin.order.index')->with('success', 'Cập nhật thành công');
    }

    public function delete($id)
    {
        $order = Order::findOrFail($id);
        $detail = DetailOrder::where('id_DonHang', $order->id)->first();
        File::delete(public_path("img/" . $detail->image));
        $detail->delete();
        $order->delete();
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
                // 'product_name' => 'required',
                // 'weight.*' => 'required',
                // 'height.*' => 'required',
                'quantity.*' => 'min:1',
                'category' => 'required',
                // 'fabric' => 'required',
                // 'fabric_owner' => 'required',
                'quality' => 'required',
                'totalPrice' => 'required',
                // 'duration' => 'required|date',
                'image.0' => 'mimes:jpeg,jpg,png,bmp|max:3000'
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
                // 'product_name.required' => 'Không được để trống tên sản phẩm',
                // 'weight.*.required' => 'Không được để trống thuộc tính cân nặng',
                // 'height.*.required' => 'Không được để trống thuộc tính chiều cao',
                // 'quantity.*.required' => 'Không được để trống sớ lượng sản phẩm',
                'category.required' => 'Không được để trống danh mục sản phẩm',
                // 'fabric.required' => 'Không được để trống loại vải',
                // 'fabric_owner.required' => 'Không được để trống nguồn cung cấp vải',
                'quality.required' => 'Không được để trống chất lượng sản phẩm',
                'totalPrice.required' => 'Không được để trống tổng số tiền',
                // 'duration.required' => 'Không được để trống ngày trả đơn',
                'image.0.mimes' => 'Định dạng file ảnh không hợp lệ',
                'image.0.max' => 'Dung lượng tối đa của hình ảnh phải nhỏ hơn 3MB'
            ]
        );

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }
    }

    private function validateProductUnavailable($req)
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
                'product_name' => 'required',
                // 'weight.*' => 'required',
                // 'height.*' => 'required',
                'quantity.*' => 'min:1',
                'category' => 'required',
                // 'fabric' => 'required',
                // 'fabric_owner' => 'required',
                // 'duration' => 'required|date',
                'price' => 'required|numeric',
                'image.0' => 'mimes:jpeg,jpg,png,bmp|max:3000',
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
                // 'weight.*.required' => 'Không được để trống thuộc tính cân nặng',
                // 'height.*.required' => 'Không được để trống thuộc tính chiều cao',
                'quantity.*.required' => 'Không được để trống sớ lượng sản phẩm',
                'category.required' => 'Không được để trống danh mục sản phẩm',
                // 'fabric.required' => 'Không được để trống loại vải',
                // 'fabric_owner.required' => 'Không được để trống nguồn cung cấp vải',
                'quality.required' => 'Không được để trống chất lượng sản phẩm',
                // 'price.required' => 'Không được để trống giá tiền',
                'price.numeric' => 'Giá tiền không hợp lệ',
                // 'duration.required' => 'Không được để trống ngày trả đơn',
                'image.0.mimes' => 'Định dạng file ảnh không hợp lệ',
                'image.0.max' => 'Dung lượng tối đa của hình ảnh không phải nhỏ hơn 3MB'
            ]
        );

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }
    }

    public function export()
    {
        return Excel::download(new OrderExport, 'don_hang.xlsx');
    }
}

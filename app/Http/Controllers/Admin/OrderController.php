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
use App\Models\Ingredient;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    //
    public function index()
    {
        $orders = Order::orderByDesc('created_at')->paginate(25);
        return view('admin.manage.order.order', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::all();
        $products = Ingredient::where('id_ingredient_type', 3)->get();
        return view('admin.manage.order.createOrder', compact('customers', 'products'));
    }

    public function store(Request $req)
    {
        DB::beginTransaction();
        try {
            // $address = $req->address . ', ' . $req->ward . ' - ' . $req->district . ' - ' . $req->province;
            if (!$req->hasFile('image')) return back()->withErrors(['image' => 'Bạn chưa thêm ảnh cho sản phẩm']);

            $validator = Validator::make(
                $req->all(),
                [
                    'quantity.*' => 'min:1',
                    'quality' => 'required',
                    // 'duration' => 'required|date',
                    'image.0' => 'mimes:jpeg,jpg,png,bmp|max:3000'
                ],
                [
                    'quality.required' => 'Không được để trống chất lượng sản phẩm',
                    // 'duration.required' => 'Không được để trống ngày trả đơn',
                    'image.0.mimes' => 'Định dạng file ảnh không hợp lệ',
                    'image.0.max' => 'Dung lượng tối đa của hình ảnh phải nhỏ hơn 3MB'
                ]
            );

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $order = Order::create([
                'id_customer' => $req->id_customer,
                'NgayTraDon' => $req->duration,
                'id_NhanVien' => Auth::user()->id,
                'vat' => $req->vat,
                'note' => $req->note
            ]);


            if ($req->has('id_product')) {
                $file_name = null;
                foreach ($req->id_product as $key => $product) {
                    if ($req->hasFile('image.' . $key)) {
                        $file = $req->image[0];
                        $extension = $file->getClientOriginalExtension();
                        $accept = array("png", "jpg", "jpeg", "bmp");
        
                        if (!in_array($extension, $accept))
                            return back()->with('error', 'Định dạng ảnh không hợp lệ! Vui lòng thử lại');
        
                        $file_name = current(explode('.', $file->getClientOriginalName())) . '_' . time() . '.' . $extension;
                        $file->move('img', $file_name);
                    }

                    DetailOrder::create([
                        'id_DonHang' => $order->id,
                        'id_product' => $product,
                        'id_ChatLuong' => $req->quality[$key] ? $req->quality[$key] : 1,
                        'amount' => $req->quantity[$key],
                        'image' => $file_name,
                    ]);
                }
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            throw $ex;
        }

        return redirect()->route('admin.order.index')->with('success', 'Thêm đơn hàng thành công');
    }

    public function edit($id)
    {
        $customers = Customer::all();
        $products = Ingredient::where('id_ingredient_type', 3)->get();
        $order = Order::with([
            'detail',
            'detail.category',
            'detail.quality',
        ])->findOrFail($id);
        return view('admin.manage.order.editOrder', ['order' => $order, 'customers' => $customers, 'products' => $products]);
    }

    public function update(Request $req, $id)
    {
        try {
            DetailOrder::where('id_DonHang', $id)->delete();

            $this->validateProductAvailable($req);

            $order = Order::findOrFail($id);
            $order->update([
                'id_customer' => $req->id_customer,
                'NgayTraDon' => $req->duration,
                'vat' => $req->vat,
                'note' => $req->note
            ]);

            $order->updated_at = now();
            $order->save();

            if ($req->has('id_product')) {
                foreach ($req->id_product as $key => $product) {
                    DetailOrder::create([
                        'id_DonHang' => $order->id,
                        'id_product' => $product,
                        'id_ChatLuong' => $req->quality[$key] ? $req->quality[$key] : 1,
                        'amount' => $req->quantity[$key],
                        'GhiChu' => $req->note
                    ]);
                }
            }
        } catch (\Exception $ex) {
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

                'quantity.*' => 'min:1',
                'quality' => 'required',
                // 'duration' => 'required|date',
                'image.0' => 'mimes:jpeg,jpg,png,bmp|max:3000'
            ],
            [
                'quality.required' => 'Không được để trống chất lượng sản phẩm',
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
                'product_name' => 'required',
                'quantity.*' => 'min:1',
                'price' => 'required|numeric',
                'image.0' => 'mimes:jpeg,jpg,png,bmp|max:3000',
            ],
            [
                'quantity.*.required' => 'Không được để trống sớ lượng sản phẩm',
                'quality.required' => 'Không được để trống chất lượng sản phẩm',
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
        return Excel::download(new OrderExport, 'orders.xlsx');
    }

     public function getDataEdit($id)
    {
        $order = Order::with([
            'detail',
            'detail.category',
            'detail.quality',
        ])->findOrFail($id);
        return response()->json(['data' => $order->detail]);
    }

}

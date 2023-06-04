<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DetailOrder;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $orders = Order::with(['customer', 'user'])
        ->where(function ($query) use ($request) {
            $query->where('code', 'like', '%' . $request->keyword . '%')
                ->orWhereRelation('customer', 'name', 'like', '%' . $request->keyword . '%')
                ->orWhereRelation('customer', 'phone_number', 'like', '%' . $request->keyword . '%')
                ->orWhere('note', 'like', '%' . $request->keyword . '%');
        })
        ->orderByDesc('orders.created_at')
        ->paginate(20);
        return response()->json(['code' => 200, 'data' => $orders], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        DB::beginTransaction();
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'quantity.*' => 'min:1',
                    'quality.*' => 'required',
                ],
                [
                    'quality.*.required' => 'Không được để trống chất lượng sản phẩm',
                ]
            );

            if ($validator->fails())
                return response()->json(['msg' => 'error', 'errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);

            $order = Order::create([
                'id_customer' => $request->id_customer,
                'NgayTraDon' => $request->delivery_date,
                'id_NhanVien' => auth()->user()->id,
                'vat' => $request->vat,
                'total' => str_replace('.', '', $request->total),
                'paid' => str_replace('.', '', $request->paid),
                'note' => $request->note
            ]);

            $order->code = Order::generateCode($order->id);
            $order->save();

            if ($request->has('id_product')) {
                $file_name = null;
                foreach ($request->id_product as $key => $product) {
                    // if ($request->hasFile('image.' . $key)) {
                    //     $file = $request->image[0];
                    //     $extension = $file->getClientOriginalExtension();
                    //     $accept = array("png", "jpg", "jpeg", "bmp");

                    //     if (!in_array($extension, $accept))
                    //         return back()->with('error', 'Định dạng ảnh không hợp lệ! Vui lòng thử lại');

                    //     $file_name = current(explode('.', $file->getClientOriginalName())) . '_' . time() . '.' . $extension;
                    //     $file->move('img', $file_name);
                    // }
                    DetailOrder::create([
                        'id_DonHang' => $order->id,
                        'id_product' => $product,
                        'price' => str_replace('.', '', $request->price[$key]),
                        'id_ChatLuong' => $request->quality[$key] ? $request->quality[$key] : 2,
                        'amount' => str_replace('.', '', $request->quantity[$key]),
                        'image' => $file_name,
                    ]);
                }
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            throw $ex;
        }

        return response()->json(['msg' => 'create success', 'data' => $order], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $order = Order::with([
            'detail',
            'customer',
            'detail.product',
            'detail.product.unit_cal',
            'detail.quality',
            'user'
        ])->findOrFail($id);
        return response()->json(['msg' => 'success', 'data' => $order], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        try {
            DetailOrder::where('id_DonHang', $id)->delete();

            $validator = Validator::make(
                $request->all(),
                [
                    'quantity.*' => 'min:1',
                    'quality.*' => 'required',
                ],
                [
                    'quality.*.required' => 'Không được để trống chất lượng sản phẩm',
                ]
            );

            if ($validator->fails())
                return response()->json(['msg' => 'error', 'errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);

            $order = Order::findOrFail($id);
            $order->update([
                'id_customer' => $request->id_customer,
                'NgayTraDon' => $request->delivery_date,
                'vat' => $request->vat,
                'total' => str_replace('.', '', $request->total),
                'paid' => str_replace('.', '', $request->paid),
                'note' => $request->note
            ]);

            $order->updated_at = now();
            $order->save();

            if ($request->has('id_product')) {
                foreach ($request->id_product as $key => $product) {
                    DetailOrder::create([
                        'id_DonHang' => $order->id,
                        'id_product' => $product,
                        'price' => str_replace('.', '', $request->price[$key]),
                        'id_ChatLuong' => $request->quality[$key] ? $request->quality[$key] : 2,
                        'amount' => str_replace('.', '', $request->quantity[$key])
                    ]);
                }
            }
        } catch (\Exception $ex) {
            throw $ex;
        }

        return response()->json(['msg' => 'create success', 'data' => $order], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $order = Order::findOrFail($id);
        $order->delete();
        return response()->json(['msg' => 'success'], Response::HTTP_OK);
    }

    /**
     * Update order status
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $id)
    {
        //
        $order = Order::find($id);
        $validator = Validator::make($request->all(), 
            [
                'status' => 'required|between:1,5'
            ],
            [
                'required' => 'Trạng thái không được bỏ trống',
                'between' => 'Trạng thái không tồn tại'
            ]
        );

        if ($validator->fails())
            return response()->json(['msg' => 'error', 'errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        
        if (!$order)
            return response()->json(['msg' => 'error', 'error' => 'Không tìm thấy đơn hàng hợp lệ'], Response::HTTP_NOT_FOUND);

        $order->update([
            'status' => $request->status
        ]);

        return response()->json(['msg' => 'Cập nhật thành công'], Response::HTTP_OK);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\CreatePlaningIngredient;
use App\Models\PlanIngredient;
use App\Models\ProductionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ProductionRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $productions = ProductionRequest::with([
            'user',
            'user:id,name,image,id_role',
            'user.role:id,name',
            'product',
            'product.images'
        ])->where('code', 'like', '%' . $request->keyword . '%')
            ->orWhere('size', 'like', '%' . $request->keyword . '%')
            ->orWhere('color', 'like', '%' . $request->keyword . '%')
            ->orWhereRelation('product', 'Ten', 'like', '%' . $request->keyword . '%')
            ->orderByDesc('id')
            ->paginate(25);

        return response()->json(['code' => 200, 'data' => $productions], Response::HTTP_OK);
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
        $rules =  [
            'detail_order_id' => 'required',
            'image.0' => 'nullable|image|mimes:jpg,jpeg,png,bmp|max:3000',
            'id_product' => 'required',
            'amount' => 'required|min:1',
        ];

        $message = [
            'detail_order_id.required' => 'Vui lòng chọn đơn hàng',
            'image.0.image' => 'File được tải lên không phải là hình ảnh',
            'id_product.required' => 'Sản phẩm không được để trống',
            'amount.required' => 'Số lượng không được để trống',
            'amount.min' => 'Số lượng ít nhất phải là 1',
            'image.0.max' => 'Ảnh tải lên vượt mức cho phép 3MB',
            'image.*.mimes' => 'Định dạng ảnh không hợp lệ'
        ];

        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails())
            return response()->json(['msg' => 'error', 'errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        $productionRequest = NULL;
        DB::beginTransaction();
        try {
            $file_name = "";
            $newArr = $request->all();

            if ($request->hasFile('image')) {
                $file = $request->image[0];
                $extension = $file->getClientOriginalExtension();
                $file_name = current(explode('.', $file->getClientOriginalName())) . '_' . time() . '.' . $extension;
                $file->move('img_product', $file_name);
            }

            $newArr['image'] = !$file_name && $file_name == '' ? 'placeholder.jpg' : $file_name;
            $newArr['creator'] = auth()->user()->id;

            $productionRequest = ProductionRequest::create($newArr);
            $productionRequest->code = generateCode($productionRequest->id, 'DNSX');
            $productionRequest->save();

            DB::commit();
            // PlanIngredient::createData($productionRequest->id);
            CreatePlaningIngredient::dispatch($productionRequest->id);
        } catch (\Exception $ex) {
            DB::rollBack();
            throw $ex;
        }
        return response()->json(['msg' => 'create success', 'data' => $productionRequest], Response::HTTP_OK);
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
        $production = ProductionRequest::with([
            'product:id,Ten',
            'detail_order:id,id_product,id_DonHang',
            'detail_order.order:id,code,id_customer',
            'detail_order.product:id,Ten',
            'detail_order.order.customer:id,name'
        ])->findOrFail($id);
        return response()->json(['msg' => 'success', 'data' => $production], Response::HTTP_OK);
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
        $rules =  [
            'detail_order_id' => 'required',
            'image.0' => 'nullable|image|mimes:jpg,jpeg,png,bmp|max:3000',
            'id_product' => 'required',
            'amount' => 'required|min:1',
        ];

        $message = [
            'detail_order_id.required' => 'Vui lòng chọn đơn hàng',
            'image.0.image' => 'File được tải lên không phải là hình ảnh',
            'id_product.required' => 'Sản phẩm không được để trống',
            'amount.required' => 'Số lượng không được để trống',
            'amount.min' => 'Số lượng ít nhất phải là 1',
            'image.0.max' => 'Ảnh tải lên vượt mức cho phép 3MB',
            'image.*.mimes' => 'Định dạng ảnh không hợp lệ'
        ];

        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails())
            return response()->json(['msg' => 'error', 'errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);

        $production_request = ProductionRequest::findOrFail($id);
        DB::beginTransaction();
        try {
            $file_name = "";
            $newArr = $request->all();

            if ($request->hasFile('image')) {
                if($production_request->image != 'placeholder.jpg') unlink(public_path('/img_product/' . $production_request->image));
                $file = $request->image[0];
                $extension = $file->getClientOriginalExtension();
                $file_name = current(explode('.', $file->getClientOriginalName())) . '_' . time() . '.' . $extension;
                $newArr['image'] = $file_name;
                $file->move('img_product', $file_name);
            }


            $production_request->update($newArr);

            DB::commit();
            CreatePlaningIngredient::dispatch($production_request->id);
        } catch (\Exception $ex) {
            DB::rollBack();
            throw $ex;
        }
        return response()->json(['msg' => 'update success', 'data' => $production_request], Response::HTTP_OK);
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
        $production = ProductionRequest::findOrFail($id);
        $file_path = public_path('/img_product/' . $production->image);
        $existsFile = Storage::exists($file_path);
        if($existsFile) unlink($file_path);
        $production->delete();
        return response()->json(['msg' => 'success'], Response::HTTP_OK);
    }

    /**
     * Show progress
     * @param int $id
     * @return \Illuminate\Http\Response
    */
    public function showDataProgress($id){
        $production = ProductionRequest::with([
            'productions:id,id_product,id_production_request,id_plan_ingredient,require_total',
            'productions.product:id,Ten,stage',
            'productions.product.stage_product',
            'productions.produceds:id,id_production,amount'
        ])->find($id);
        if(!$production) response()->json(['msg' => 'Không tìm thấy', 'data' => $production], Response::HTTP_NOT_FOUND);
        return response()->json(['msg' => 'success', 'data' => $production], Response::HTTP_OK);
    }
    
    /**
     * Update status
     * @param \Illuminate\Http\Request $req
     * @param int $id
     * @return \Illuminate\Http\Response
    */
    public function updateStatus(Request $req, $id){
        $status = 4;// Ngừng sản xuất
        $productRequest = ProductionRequest::findOrFail($id);
        $productRequest->update([
            'status' => $status
        ]);
        return response()->json(['msg' => 'Cập nhật thành công'], Response::HTTP_OK);
    }
}

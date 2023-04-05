<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $customers = Customer::with('user')->where('name', 'like', '%'.$request->keyword.'%')
        ->orWhere('phone_number', 'like', '%'.$request->keyword.'%')
        ->orWhere('address', 'like', '%'.$request->keyword.'%')
        ->orderBy('name')
        ->paginate(25);

        return response()->json(['code' => 200, 'data' => $customers], Response::HTTP_OK);
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
        $validator  = Validator::make($request->all(), [
            'name' => 'required',
            'phone_number' => 'required|digits:10|unique:customers,phone_number',
            'address' => 'required',
        ],[
            'required' => ':attribute không được để trống',
            'digits' => 'Số điện thoại không hợp lệ',
            'unique' => 'Số điện thoại đã tồn tại trong hệ thống'
        ],[
            'name' => 'Tên nhà cung cấp',
            'phone_number' => 'Số điện thoại',
            'address' => 'Số điện thoại'
        ]);

        if($validator->fails())
            return response()->json(['msg' => 'error', 'errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        
        $customer = Customer::create($request->all() + ['creator' => auth()->user()->id]);
        return response()->json(['msg' => 'create success', 'data' => $customer], Response::HTTP_OK);
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
        $customer = Customer::findOrFail($id);
        return response()->json(['msg' => 'success', 'data' => $customer], Response::HTTP_OK);
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
        $validator  = Validator::make($request->all(), [
            'name' => 'required',
            'phone_number' => 'required|digits:10|unique:customers,phone_number,'.$id.',id',
            'address' => 'required',
        ],[
            'required' => ':attribute không được để trống',
            'digits' => 'Số điện thoại không hợp lệ',
            'unique' => 'Số điện thoại đã tồn tại trong hệ thống'
        ],[
            'name' => 'Tên nhà cung cấp',
            'phone_number' => 'Số điện thoại',
            'address' => 'Số điện thoại'
        ]);

        if($validator->fails())
            return response()->json(['msg' => 'error', 'errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        
        $customer = Customer::findOrFail($id)->update($request->all() + ['edit' => auth()->user()->id]);
        return response()->json(['msg' => 'create success', 'data' => $customer], Response::HTTP_OK);
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
        $customer = Customer::findOrFail($id);
        $customer->delete();
        return response()->json(['msg' => 'success'], Response::HTTP_OK);
    }
}

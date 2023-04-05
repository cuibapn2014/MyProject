<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $providers = Provider::where('name', 'like', '%' . $request->keyword . '%')
            ->orWhere('address', 'like', '%' . $request->keyword . '%')
            ->orWhere('phone_number', 'like', '%' . $request->keyword . '%')
            ->orderByDesc('id')
            ->paginate(25);
        return response()->json(['code' => 200, 'data' => $providers], Response::HTTP_OK);
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
            'phone_number' => 'required|digits:10'
        ], [
            'required' => ':attribute không được để trống',
            'digits' => 'Số điện thoại không hợp lệ'
        ], [
            'name' => 'Tên nhà cung cấp',
            'phone_number' => 'Số điện thoại'
        ]);

        if ($validator->fails())
            return response()->json(['msg' => 'error', 'errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);

        $provider = Provider::updateOrCreate(['id' => $request->id], $request->all());
        return response()->json(['msg' => 'create success', 'data' => $provider], Response::HTTP_OK);
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
        $provider = Provider::findOrFail($id);
        return response()->json(['msg' => 'success', 'data' => $provider], Response::HTTP_OK);
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
            'phone_number' => 'required|digits:10'
        ], [
            'required' => ':attribute không được để trống',
            'digits' => 'Số điện thoại không hợp lệ'
        ], [
            'name' => 'Tên nhà cung cấp',
            'phone_number' => 'Số điện thoại'
        ]);

        if ($validator->fails())
            return response()->json(['msg' => 'error', 'errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);

        $provider = Provider::findOrFail($id);
        $provider->update($request->all());
        return response()->json(['msg' => 'success', 'data' => $provider], Response::HTTP_OK);
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
        $provider = Provider::findOrFail($id);
        $provider->delete();
        return response()->json(['msg' => 'success'], Response::HTTP_OK);
    }
}

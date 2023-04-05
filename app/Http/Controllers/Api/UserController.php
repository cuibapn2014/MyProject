<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $users = User::where('name', 'like', '%' . $request->keyword . '%')
            ->orWhere('phone', 'like', '%' . $request->keyword . '%')
            ->orWhere('email', 'like', '%' . $request->keyword . '%')
            ->orWhereRelation('role', 'name', 'like', '%' . $request->keyword . '%')
            ->orderBy('name')
            ->paginate(25);
        return response()->json(['code' => 200, 'data' => $users], Response::HTTP_OK);
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
        $role = auth()->user()->role->alias;
        if (!in_array($role, ['USER_MANAGER', 'CEO', 'ADMIN', 'USER_HR']))
            return response()->json(['msg' => 'access denied'], Response::HTTP_FORBIDDEN);
        $user = User::findOrFail($id);
        if (in_array($user->role->alias, ['USER_MANAGER', 'CEO', 'ADMIN', 'USER_HR']))
            return response()->json(['msg' => 'access denied'], Response::HTTP_FORBIDDEN);
        $user->delete();
        return response()->json(['msg' => 'success'], Response::HTTP_OK);
    }
}

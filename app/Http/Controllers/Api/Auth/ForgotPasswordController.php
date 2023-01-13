<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    //
    public function postForgotPassword(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'email' => 'required|email'
        ], [
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không hợp lệ',
        ]);

        if($validator->fails()){
            return response()->json(['status' => false, 'errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        $status = Password::sendResetLink(
            $req->only('email')
        );

        if($status === Password::RESET_LINK_SENT)
            return response()->json(['status' => true, 'success' => __($status)], Response::HTTP_OK);
        else 
            return response()->json(['status' => false, 'errors' => (object)["email" => ["Email không tồn tại trong hệ thống"]]], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UploadImageController extends Controller
{
    //
    public function update(Request $req)
    {
        $id = auth()->user()->id;
        $user = User::findOrFail($id);
        $accept = array("png", "jpg", "jpeg", "bmp");
        if ($req->hasFile('image')) {
            $extension = $req->file('image')->getClientOriginalExtension();
            if ($req->file('image') != null && in_array($extension, $accept)) {
                if($user->image != 'user.png')
                File::delete(public_path("img/user/" . $user->image));
                $file_name = current(explode('.', $req->file('image')->getClientOriginalName())) . '_' . time() . '.' . $extension;
                $req->file('image')->move('img/user/', $file_name);
                $user->image = $file_name;
                $user->save();
            }
        }
        return response()->json(['user' => $user, 'status' => true]);
    }
}

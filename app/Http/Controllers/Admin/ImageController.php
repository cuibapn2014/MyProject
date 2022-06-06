<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ImageController extends Controller
{
    //
    public function delete($type,$idIngredient, $idImg)
    {
        $images = Image::where('type', $type)->where('id', $idImg)->where('id_provide', $idIngredient)->get();
        if ($images->count() > 0) {
            foreach ($images as $image) {
                File::delete(public_path("img/".$image->urlImage));
            }
            Image::where('type', $type)->where('id', $idImg)->where('id_provide', $idIngredient)->delete();
        }
        return back()->with('success', 'Xóa thành công');
    }
}

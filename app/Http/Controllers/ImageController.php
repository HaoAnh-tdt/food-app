<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class ImageController extends Controller
{
    public function show(Request $request, $filename)
    {
        $path = storage_path('app/public/images/monan/' . $filename);
        if (!file_exists($path)) {
            abort(404);
        }

        $width = $request->query('w'); // ví dụ ?w=600
        if ($width) {
            // tạo thumbnail on-the-fly (và có thể cache vào disk)
            $img = Image::make($path)->widen((int)$width, function ($constraint) {
                $constraint->upsize(); // không phóng to ảnh nhỏ hơn
            });
            return response($img->encode('jpg'), 200)
                ->header('Content-Type', 'image/jpeg');
        }

        // trả ảnh gốc
        return response()->file($path);
    }
}

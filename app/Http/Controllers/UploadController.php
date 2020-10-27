<?php

namespace App\Http\Controllers;

use App\Http\Requests\Image\StoreImageRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UploadController extends Controller
{
    public function uploadPage()
    {
        return view('upload');
    }

    public function store(StoreImageRequest $request){

        if($request->has('image')){

            $image = $request->file('image');
            $extension = $request->file('image')->getClientOriginalExtension();

            $filename = md5(time()).'_'.$image->getClientOriginalName();

            $file = Image::make($image);

            switch ($request->get('type')){
                case \App\Models\Models\Image::TYPE_ORIGINAL:
                    $this->imageSetOriginal($filename, $file, $extension);
                    break;

                case \App\Models\Models\Image::TYPE_SQUARE:
                    $this->imageSetSquare($filename, $file, $extension);
                    break;

                case \App\Models\Models\Image::TYPE_SMALL:
                    $this->imageSetSmall($filename, $file, $extension);
                    break;

                case \App\Models\Models\Image::TYPE_ALL:
                    $this->imageSetOriginal($filename, $file, $extension);
                    $this->imageSetSquare($filename, $file, $extension);
                    $this->imageSetSmall($filename, $file, $extension);
                    break;

            }

            return redirect()->back();
        }
    }

    private function imageSetOriginal($filename, $file, $extension)
    {
        $internalFile = clone $file;

        return Storage::disk('local')->put('original/' . $filename, (string) $internalFile->encode($extension), 'public');
    }

    private function imageSetSquare($filename, $file, $extension)
    {
        $internalFile = clone $file;

        $side = max($internalFile->width(), $internalFile->height());
        $internalFile->resizeCanvas($side, $side, 'center', false, '#ffffff');

        return Storage::disk('local')->put('square/' . $filename, (string) $internalFile->encode($extension), 'public');
    }

    private function imageSetSmall($filename, $file, $extension)
    {
        $internalFile = clone $file;

        $internalFile->resize(256, 256);

        return Storage::disk('local')->put('small/' . $filename, (string) $internalFile->encode($extension), 'public');
    }
}

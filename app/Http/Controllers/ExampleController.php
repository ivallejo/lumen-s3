<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function store(Request $request)
    {
        $path = $request->file('image')->store('images', 's3');

        Storage::disk('s3')->setVisibility($path, 'public');

        $image = Image::create([
            'filename' => basename($path),
            'url' => Storage::disk('s3')->url($path)
        ]);

        return $image;
    }

    public function show($id)
    {
        // return $image;
        $image = Image::find($id);
        return $image->url;
    }
    //

    public function remove($id)
    {
        $image = Image::find($id);
        // $image->delete();
        Storage::disk('s3')->delete('images/'.$image->filename); 
        return $image;
    }
    
}

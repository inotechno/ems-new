<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Upload ke Google Cloud Storage
        $file = $request->file('image');
        $path = $file->store('images', 'gcs');

        return response()->json([
            'url' => Storage::disk('gcs')->url($path)
        ]);
    }
}

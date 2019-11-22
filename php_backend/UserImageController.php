<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UserImageController extends Controller
{
    /**
     * Store a new user image.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $validator = request()->validate([
            'image' => ['required', 'image']
        ]);
        
        if (!$validator){
            $response = [
                'status' => 'success',
                'error'    => false,
                'message' => 'Invalid Image',
            ];
            
            return response()->json($response, 404);
        }

        Storage::disk('public')->delete(auth()->user()->getOriginal('image_path'));

        auth()->user()->update([
            'image' => request()->file('image')->store('images', 'public')
        ]);
        
        $response = [
            'status' => 'success',
            'error'    => false,
            'message' => 'File Uploaded Successfully',
        ];

        return response()->json($response, 200);
    }
}

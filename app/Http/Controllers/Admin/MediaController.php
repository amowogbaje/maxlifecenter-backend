<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\MediaService;
use App\Http\Resources\EditorJsImageResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Log;

class MediaController extends Controller
{
    protected $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    public function upload(Request $request)
    {
        // 1. Validate the incoming request
        $validator = Validator::make($request->all(), [
            'image' => [
                'required',
                'image',           // Must be an image
                'mimes:jpeg,png,jpg,gif,webp', // Specific formats
                'max:2048',        // Max 2MB
            ],
        ]);

        // 2. Handle Validation Failure
        if ($validator->fails()) {
            Log::warning('Image upload validation failed', ['errors' => $validator->errors()]);
            return response()->json([
                'success' => 0,
                'message' => $validator->errors()->first('image')
            ], 422);
        }

        try {
            // 3. Proceed with upload via Service
            $url = $this->mediaService->upload($request->file('image'));

            return response()->json([
                'success' => 1,
                'file' => [
                    'url' => $url
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Image upload failed', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => 0,
                'message' => 'Upload failed on the server.'
            ], 500);
        }
    }
}
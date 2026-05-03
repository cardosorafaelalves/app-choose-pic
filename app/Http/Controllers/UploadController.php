<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Throwable;

class UploadController extends Controller
{
    public function __construct()
    {
    }

    /**
     * Generate a signed upload URL for a file
     */
    public function generateUploadUrl(Request $request, string $cloudService): JsonResponse
    {
        try {
            $request->validate([
                'file_name' => 'required|string|max:255',
                'content_type' => 'required|in:image/jpeg,image/png,image/webp',
            ]);

            $service = App::make($cloudService);
            $results = $service->generateUploadUrl($request->all());

            return response()->json(['message' => 'Upload URL generated successfully', 'data' => $results], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'error_line' => $th->getLine(),
                'error_file' => $th->getFile()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class ImageController extends Controller
{
    protected $service;

    public function __construct(ImageService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $items = $this->service->getAll();

            return response()->json(["message" => "Images found successfully.", "data" => $items]);
        } catch (Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'error_line' => $th->getLine(),
                'error_file' => $th->getFile()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'customer_uuid' => 'required|uuid|exists:customers,uuid',
                'photographer_uuid' => 'required|uuid|exists:photographers,uuid',
                'file_url' => 'required|string|max:255',
            ]);

            $this->service->create($request->all());

            return response()->json(['message' => 'Image created successfully'], Response::HTTP_CREATED);
        } catch (Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'error_line' => $th->getLine(),
                'error_file' => $th->getFile()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function show($uuid)
    {
        try {
            $item = $this->service->getById($uuid);

            if ($item) {
                return response()->json($item);
            }

            return response()->json(['message' => 'Image not found'], Response::HTTP_NOT_FOUND);
        } catch (Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'error_line' => $th->getLine(),
                'error_file' => $th->getFile()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(Request $request, $uuid)
    {
        try {
            $data = $request->validate([
                'photographer_uuid' => 'required|uuid|exists:photographers,uuid',
                'customer_uuid' => 'required|uuid|exists:customers,uuid',
                'file_url' => 'required|url',
                'thumbnail_url' => 'required|url',
                'is_selected' => 'boolean'
            ]);

            $item = $this->service->update($uuid, $data);

            if ($item) {
                return response()->json(["message" => "Image updated successfully.", "data" => $item]);
            }

            return response()->json(['message' => 'Image not found'], Response::HTTP_NOT_FOUND);
        } catch (Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'error_line' => $th->getLine(),
                'error_file' => $th->getFile()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy($uuid)
    {
        try {
            $deleted = $this->service->delete($uuid);

            if ($deleted) {
                return response()->json(['message' => 'Image deleted']);
            }

            return response()->json(['message' => 'Image not found'], Response::HTTP_NOT_FOUND);
        } catch (Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'error_line' => $th->getLine(),
                'error_file' => $th->getFile()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}

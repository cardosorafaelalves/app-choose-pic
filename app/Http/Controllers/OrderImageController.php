<?php

namespace App\Http\Controllers;

use App\Services\OrderImageService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class OrderImageController extends Controller
{
    protected $service;

    public function __construct(OrderImageService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $items = $this->service->getAll();
        return response()->json(["message" => "Order images found successfully.", "data" => $items]);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->only(['order_uuid', 'image_uuid']);
            $item = $this->service->create($data);
            return response()->json($item, Response::HTTP_CREATED);
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
        $item = $this->service->getById($uuid);
        if ($item) {
            return response()->json($item);
        }
        return response()->json(['message' => 'OrderImage not found'], Response::HTTP_NOT_FOUND);
    }

    public function update(Request $request, $uuid)
    {
        try {
            $data = $request->only(['order_uuid', 'image_uuid']);
            $item = $this->service->update($uuid, $data);
            if ($item) {
                return response()->json(["message" => "Order image updated successfully.", "data" => $item]);
            }
            return response()->json(['message' => 'OrderImage not found'], Response::HTTP_NOT_FOUND);
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
                return response()->json(['message' => 'OrderImage deleted']);
            }
            return response()->json(['message' => 'OrderImage not found'], Response::HTTP_NOT_FOUND);
        } catch (Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'error_line' => $th->getLine(),
                'error_file' => $th->getFile()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}

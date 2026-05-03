<?php

namespace App\Http\Controllers;

use App\Services\CustomerConfigService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class CustomerConfigController extends Controller
{
    protected $service;

    public function __construct(CustomerConfigService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json($this->service->getAll());
    }

    public function store(Request $request)
    {
        try {
            $data = $request->only([
                'customer_uuid', 'max_photos', 'photo_price', 'gallery_expiration', 'allow_download', 'watermark_enabled'
            ]);
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
        return response()->json(['message' => 'Not found'], Response::HTTP_NOT_FOUND);
    }

    public function update(Request $request, $uuid)
    {
        try {
            $data = $request->only([
                'customer_uuid', 'max_photos', 'photo_price', 'gallery_expiration', 'allow_download', 'watermark_enabled'
            ]);
            $item = $this->service->update($uuid, $data);
            if ($item) {
                return response()->json($item);
            }
            return response()->json(['message' => 'Not found'], Response::HTTP_NOT_FOUND);
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
                return response()->json(['message' => 'Deleted']);
            }
            return response()->json(['message' => 'Not found'], Response::HTTP_NOT_FOUND);
        } catch (Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'error_line' => $th->getLine(),
                'error_file' => $th->getFile()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}

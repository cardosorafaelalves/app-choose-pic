<?php

namespace App\Http\Controllers;

use App\Services\PhotographerConfigService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class PhotographerConfigController extends Controller
{
    protected $service;

    public function __construct(PhotographerConfigService $service)
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
                'photographer_uuid',
                'logo_url',
                'primary_color',
                'secondary_color',
                'welcome_message',
                'send_email_on_choice',
                'email_template_id'
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
        return response()->json(['message' => 'Photographer config not found'], Response::HTTP_NOT_FOUND);
    }

    public function update(Request $request, $uuid)
    {
        try {
            $data = $request->only([
                'photographer_uuid', 'logo_url', 'primary_color', 'secondary_color', 'welcome_message', 'send_email_on_choice', 'email_template_id'
            ]);
            $item = $this->service->update($uuid, $data);
            if ($item) {
                return response()->json($item);
            }
            return response()->json(['message' => 'Photographer config not found'], Response::HTTP_NOT_FOUND);
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
                return response()->json(['message' => 'Photographer config deleted']);
            }
            return response()->json(['message' => 'Photographer config not found'], Response::HTTP_NOT_FOUND);
        } catch (Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'error_line' => $th->getLine(),
                'error_file' => $th->getFile()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}

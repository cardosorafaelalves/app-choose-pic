<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\PhotographersService;
use Throwable;

class PhotographersController extends Controller
{

    protected $service;

    public function __construct(PhotographersService $service)
    {
        $this->service = $service;
    }

    // Create a new Photographer
    public function store(Request $request)
    {
        try {
            $data = $request->validate(
                [
                    'name' => 'required|string|max:255',
                    'email' => 'required|email|unique:photographers',
                    'subdomain' => 'required|string|unique:photographers',
                    'active' => 'boolean'
                ]
            );

            $photographer = $this->service->create($data);

            return response()->json($photographer, Response::HTTP_CREATED);
        } catch (Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'error_line' => $th->getLine(),
                'error_file' => $th->getFile()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    // Get all Photographers
    public function index()
    {
        try {
            $photographers = $this->service->getAll();

            return response()->json(["message" => "Photographers found successfully.", "data" => $photographers]);
        } catch (Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'error_line' => $th->getLine(),
                'error_file' => $th->getFile()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    // Get a single Photographer by UUID
    public function show($uuid)
    {
        try {
            $photographer = $this->service->getById($uuid);
            if ($photographer) {
                return response()->json($photographer);
            }
            return response()->json(['message' => 'Photographer not found'], Response::HTTP_NOT_FOUND);
        } catch (Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'error_line' => $th->getLine(),
                'error_file' => $th->getFile()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    // Update a Photographer by UUID
    public function update(Request $request, $uuid)
    {
        try {
            $data = $request->validate(
                [
                    'name' => 'required|string|max:255',
                    'email' => 'required|email|unique:photographers',
                    'subdomain' => 'required|string|unique:photographers',
                    'active' => 'boolean'
                ]
            );
            $photographer = $this->service->update($uuid, $data);

            if ($photographer) {
                return response()->json(["message" => "Photographer updated successfully.", "data" => $photographer]);
            }

            return response()->json(['message' => 'Photographer not found'], Response::HTTP_NOT_FOUND);
        } catch (Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'error_line' => $th->getLine(),
                'error_file' => $th->getFile()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    // Delete a Photographer by UUID
    public function destroy($uuid)
    {
        try {
            $deleted = $this->service->delete($uuid);

            if ($deleted) {
                return response()->json(['message' => 'Photographer deleted']);
            }

            return response()->json(['message' => 'Photographer not found'], Response::HTTP_NOT_FOUND);
        } catch (Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'error_line' => $th->getLine(),
                'error_file' => $th->getFile()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}

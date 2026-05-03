<?php

namespace App\Http\Controllers;

use App\Services\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class CustomerController extends Controller
{
    protected $service;

    public function __construct(CustomerService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $items = $this->service->getAll();

            return response()->json(["message" => "Customers found successfully.", "data" => $items]);
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
            $data = $request->validate([
                'photographer_uuid' => 'required|uuid|exists:photographers,uuid',
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:customers,email',
                'access_token' => 'required|string|max:255'
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
        try {
            $item = $this->service->getById($uuid);

            if ($item) {
                return response()->json($item);
            }

            return response()->json(['message' => 'Customer not found'], Response::HTTP_NOT_FOUND);
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
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:customers,email,' . $uuid,
                'access_token' => 'required|string|max:255'
            ]);

            $item = $this->service->update($uuid, $data);

            if ($item) {
                return response()->json(["message" => "Customer updated successfully.", "data" => $item]);
            }

            return response()->json(['message' => 'Customer not found'], Response::HTTP_NOT_FOUND);
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
                return response()->json(['message' => 'Customer deleted']);
            }
            return response()->json(['message' => 'Customer not found'], Response::HTTP_NOT_FOUND);
        } catch (Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'error_line' => $th->getLine(),
                'error_file' => $th->getFile()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}

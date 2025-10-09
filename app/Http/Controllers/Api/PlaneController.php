<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Plane;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PlaneController extends Controller
{
    /**
     * Display a listing of all planes.
     */
    public function index(): JsonResponse
    {
        try {
            $planes = Plane::orderBy('name')->get();

            return response()->json([
                'success' => true,
                'message' => 'Planes retrieved successfully',
                'data' => $planes
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve planes',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified plane.
     */
    public function show($id): JsonResponse
    {
        try {
            $plane = Plane::findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Plane retrieved successfully',
                'data' => $plane
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Plane not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve plane',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

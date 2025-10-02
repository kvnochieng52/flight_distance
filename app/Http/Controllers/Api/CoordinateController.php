<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coordinate;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CoordinateController extends Controller
{
    /**
     * Display a listing of active coordinates.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = $request->get('per_page', 15);
            $search = $request->get('search');
            $getAll = $request->get('all', false); // New parameter to get all coordinates

            $query = Coordinate::active();

            if ($search) {
                $query->where('location_name', 'like', "%{$search}%");
            }

            // If 'all' parameter is true, get all coordinates without pagination
            if ($getAll || $perPage === 'all') {
                $coordinates = $query->orderBy('location_name')->get();

                return response()->json([
                    'success' => true,
                    'message' => 'All active coordinates retrieved successfully',
                    'data' => $coordinates,
                    'total' => $coordinates->count()
                ]);
            }

            // Otherwise, use pagination as before
            $coordinates = $query->orderBy('location_name')->paginate($perPage);

            return response()->json([
                'success' => true,
                'message' => 'Active coordinates retrieved successfully',
                'data' => $coordinates
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve coordinates',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified coordinate.
     */
    public function show($id): JsonResponse
    {
        try {
            $coordinate = Coordinate::active()->findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Coordinate retrieved successfully',
                'data' => $coordinate
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Coordinate not found or inactive'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve coordinate',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get coordinates by location name.
     */
    public function searchByLocation(Request $request): JsonResponse
    {
        try {
            $location = $request->get('location');

            if (!$location) {
                return response()->json([
                    'success' => false,
                    'message' => 'Location parameter is required'
                ], 400);
            }

            $coordinates = Coordinate::active()
                ->where('location_name', 'like', "%{$location}%")
                ->orderBy('location_name')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Coordinates found',
                'data' => $coordinates,
                'count' => $coordinates->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to search coordinates',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get coordinates within a radius of given lat/lng.
     */
    public function getNearby(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'latitude' => 'required|numeric|between:-90,90',
                'longitude' => 'required|numeric|between:-180,180',
                'radius' => 'nullable|numeric|min:1|max:1000'
            ]);

            $latitude = $request->get('latitude');
            $longitude = $request->get('longitude');
            $radius = $request->get('radius', 50); // Default 50km radius

            // Using Haversine formula to calculate distance
            $coordinates = Coordinate::active()
                ->selectRaw("
                    *,
                    (6371 * acos(
                        cos(radians(?)) *
                        cos(radians(latitude)) *
                        cos(radians(longitude) - radians(?)) +
                        sin(radians(?)) *
                        sin(radians(latitude))
                    )) AS distance
                ", [$latitude, $longitude, $latitude])
                ->having('distance', '<=', $radius)
                ->orderBy('distance')
                ->get();

            return response()->json([
                'success' => true,
                'message' => "Coordinates within {$radius}km radius found",
                'data' => $coordinates,
                'count' => $coordinates->count(),
                'search_params' => [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'radius' => $radius
                ]
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to find nearby coordinates',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

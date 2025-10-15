<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Terms;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TermsController extends Controller
{
    /**
     * Get active terms and conditions
     */
    public function index(): JsonResponse
    {
        try {
            $terms = Terms::getActive();

            if (!$terms) {
                return response()->json([
                    'success' => false,
                    'message' => 'No active terms and conditions found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $terms->id,
                    'title' => $terms->title,
                    'content' => $terms->content,
                    'version' => $terms->version,
                    'updated_at' => $terms->updated_at->format('Y-m-d H:i:s')
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve terms and conditions',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

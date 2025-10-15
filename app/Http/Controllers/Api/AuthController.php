<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Register a new user
     */
    public function register(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'telephone' => 'required|string|max:20',
                'password' => 'required|string|min:8|confirmed',
                'device_name' => 'required|string'
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'telephone' => $request->telephone,
                'password' => Hash::make($request->password),
                'is_active' => false, // User needs admin approval
            ]);

            // Log successful registration
            Log::info('User registered successfully', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Registration successful! Your account is pending approval by an administrator.',
                // 'data' => [
                //     //'user' => $user->only(['id', 'name', 'email', 'telephone', 'is_active'])
                // ]
            ], 201);
        } catch (ValidationException $e) {
            // Log validation errors
            Log::warning('User registration validation failed', [
                'errors' => $e->errors(),
                'input' => $request->except(['password', 'password_confirmation']),
                'ip_address' => $request->ip()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // Log unexpected errors
            Log::error('User registration failed with exception', [
                'message' => $e->getMessage(),
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->except(['password', 'password_confirmation']),
                'ip_address' => $request->ip()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to register user',
                'error' => config('app.debug') ? $e->getMessage() : 'An error occurred during registration'
            ], 500);
        }
    }

    /**
     * Login user and issue token
     */
    public function login(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
                'device_name' => 'required|string'
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'The provided credentials are incorrect.'
                ], 401);
            }

            // Check if user account is active (approved by admin)
            if (!$user->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your account is pending approval.'
                ], 403);
            }

            // Revoke all existing tokens for this device (optional - for security)
            $user->tokens()->where('name', $request->device_name)->delete();

            $token = $user->createToken($request->device_name)->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'data' => [
                    'user' => $user,
                    'token' => $token,
                    'token_type' => 'Bearer'
                ]
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Login failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create API token for authentication (legacy method)
     */
    public function createToken(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
                'device_name' => 'required|string'
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            $token = $user->createToken($request->device_name)->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Token created successfully',
                'data' => [
                    'user' => $user,
                    'token' => $token,
                    'token_type' => 'Bearer'
                ]
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create token',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Revoke current token
     */
    public function revokeToken(Request $request): JsonResponse
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Token revoked successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to revoke token',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Revoke all tokens for the user
     */
    public function revokeAllTokens(Request $request): JsonResponse
    {
        try {
            $request->user()->tokens()->delete();

            return response()->json([
                'success' => true,
                'message' => 'All tokens revoked successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to revoke tokens',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

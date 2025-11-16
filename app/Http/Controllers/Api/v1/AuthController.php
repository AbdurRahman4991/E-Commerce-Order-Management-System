<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected $authService;
    public function __construct(AuthService $authService)
    {
    $this->authService = $authService;
    }


    public function register(RegisterRequest $request)
    {
    $data = $this->authService->register($request);
        return response()->json([
        'status' => true,
        'message' => 'Registration successful',
        'data' => $data
        ]);
    }


    public function login(LoginRequest $request)
    {
        $data = $this->authService->login($request);
        if (!$data) {
            return response()->json(['status' => false, 'message' => 'Invalid credentials'], 401);
        }
        return response()->json([
            'status' => true,
            'message' => 'Login successful',
            'data' => $data
        ]);
    }


    public function profile()
    {
        return response()->json(auth()->user());
    }


    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Logged out']);
    }


    public function refresh()
    {
        return response()->json(['token' => auth()->refresh()]);
    }
}

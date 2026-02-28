<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    public function showLogin(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'status_code' => 200,
                'data' => [
                    'csrf_token' => csrf_token(),
                ],
            ], 200);
        }

        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if ($request->expectsJson()) {
                return response()->json([
                    'status_code' => 200,
                    'data' => $request->user(),
                ], 200);
            }

            return redirect()->intended(route('dashboard'));
        }

        if ($request->expectsJson()) {
            return response()->json([
                'status_code' => 422,
                'reason' => 'The provided credentials do not match our records.',
            ], 422);
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->expectsJson()) {
            return response()->json([
                'status_code' => 200,
                'data' => 'Logged out successfully.',
            ], 200);
        }

        return redirect()->route('login');
    }
}
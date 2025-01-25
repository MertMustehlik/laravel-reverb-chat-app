<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;

class AuthController extends Controller
{
    public function login(): View
    {
        return view('auth.login');
    }

    public function loginPost(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return response()->json([
                'redirectUrl' => redirect()->route('dashboard.index')->getTargetUrl()
            ]);
        }

        return response()->json([
            "message" => 'Incorrect email or password.'
        ], 401);
    }

    public function logoutPost(): RedirectResponse
    {
        auth()->logout();

        return redirect()->route('auth.login');
    }
}

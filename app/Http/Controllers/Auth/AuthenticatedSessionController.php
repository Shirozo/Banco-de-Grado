<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{

    public function showForm()
    {

        if (Auth::user()) {
            if (Auth::user()->user_type != "1") {
                return redirect()->intended(route("subject.show"));
            }
            return redirect()->intended(route("user.show"));
        }

        return view("login");
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        try {
            $request->authenticate();

            $request->session()->regenerate();

            return redirect()->intended(route("user.show"));
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Invalid!"
            ], 403);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->intended(route("loginPage"));
    }
}

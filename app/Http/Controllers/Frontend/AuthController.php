<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\Frontend\AuthService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct(private readonly AuthService $authService)
    {
    }

    public function showRegister()
    {
        return view('frontend.auth.register');
    }

    public function register(Request $request)
    {
        try {
            $this->authService->register($request->all());
            return redirect()->route('frontend.home')->with('success', 'Registration successful!');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    }

    public function showLogin()
    {
        return view('frontend.auth.login');
    }

    public function login(Request $request)
    {
        try {
            $this->authService->login($request->only('email', 'password', 'remember'));
            return redirect()->intended(route('frontend.home'))->with('success', 'Logged in successfully!');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    }

    public function logout()
    {
        $this->authService->logout();
        return redirect()->route('frontend.home')->with('success', 'Logged out successfully!');
    }
}

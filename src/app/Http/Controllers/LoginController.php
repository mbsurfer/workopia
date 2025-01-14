<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Show the login form
     *
     * @return View
     * @route [GET] /login
     */
    public function login(): View
    {
        return view('auth.login');
    }

    /**
     * Authenticate the user
     *
     * @return RedirectResponse
     * @route [POST] /login
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Try to authenticate the user
        if (Auth::attempt($credentials)) {

            // IMPORTANT: Regenerate the session after login to prevent session fixation attacks
            $request->session()->regenerate();

            // Take the user to the route that they were trying to reach or home if none was provided
            return redirect()->intended(route('home'))->with('success', 'You have been logged in successfully.');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Log out the user
     *
     * @return View
     * @route [POST] /logout
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'You have been logged out successfully.');
    }
}

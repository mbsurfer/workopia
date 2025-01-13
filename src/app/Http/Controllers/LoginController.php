<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

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
}

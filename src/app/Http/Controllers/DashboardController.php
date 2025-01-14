<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show all the users job listings
     *
     * @return View
     * @route [GET] /dashboard
     */
    public function index(): View
    {
        // Get the logged in user
        $user = Auth::user();

        // Get the user's job listings
        $jobs = $user->jobs;

        return view('dashboard.index', compact('user', 'jobs'));
    }
}

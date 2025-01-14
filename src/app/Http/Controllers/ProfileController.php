<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Update the user's profile.
     *
     * @return RedirectResponse
     * @route [PUT] /profile
     */
    public function update(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        // Validate the request data
        $validatedData = request()->validate([
            'name' => 'required|string|max:255',
            // Make sure to exclude the current user's email from the unique check
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        // Update the user's profile
        $user->update($validatedData);

        return redirect()->route('dashboard')->with('success', 'Profile updated successfully!');
    }
}

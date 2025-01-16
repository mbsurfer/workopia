<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];

        // Check if the user uploaded a new avatar
        if ($request->hasFile('avatar')) {

            $file = $request->file('avatar');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filepath = $file->storeAs('users/avatars', $fileName, 'public');

            if ($filepath) {
                // Delete the old file is exists
                if ($user->avatar) {
                    Storage::disk('public')->delete('users/avatars/' . $user->avatar);
                }
                // Update validated data with the new file path
                $user->avatar = $fileName;
            } else {
                return redirect()->back()->with('error', 'Failed to upload avatar.');
            }
        }

        // Update the user's profile
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Profile updated successfully!');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Job;
use Illuminate\Http\RedirectResponse;

class BookmarkController extends Controller
{
    /**
     * Get all user bookmarks.
     * 
     * @route [GET] /bookmarks
     * @return void
     */
    public function index(): View
    {
        /** @var App\Models\User $user */
        $user = Auth::user();

        $bookmarks = $user->bookmarkedJobs()->orderBy('job_user_bookmarks.created_at', 'desc')->paginate(9);
        return view('jobs.bookmarked')->with('bookmarks', $bookmarks);
    }

    /**
     * Bookmark a job.
     * 
     * @route [POST] /bookmarks/{job}
     * @param App\Models\Job $job
     * @return void
     */
    public function store(Job $job): RedirectResponse
    {
        /** @var App\Models\User $user */
        $user = Auth::user();

        // Check if the job is already bookmarked
        if ($user->hasBookmarked($job)) {
            return back()->with('error', 'Job is already bookmarked.');
        }

        // Create the bookmark
        $user->bookmarkedJobs()->attach($job->id);

        return back()->with('success', 'Job bookmarked successfully!');
    }

    /**
     * Remove a bookmark.
     * 
     * @route [DELETE] /bookmarks/{job}
     * @param App\Models\Job $job
     * @return void
     */
    public function destroy(Job $job): RedirectResponse
    {
        /** @var App\Models\User $user */
        $user = Auth::user();

        // Check if the job is NOT bookmarked
        if (!$user->hasBookmarked($job)) {
            return back()->with('error', 'Job has not been bookmarked.');
        }

        // Delete the bookmark
        $user->bookmarkedJobs()->detach($job->id);

        return back()->with('success', 'Job bookmark removed successfuly!');
    }
}

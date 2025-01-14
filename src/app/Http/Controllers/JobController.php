<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Job;

class JobController extends Controller
{
    use AuthorizesRequests;

    private const FIELD_VALIDATION = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'salary' => 'required|integer',
        'tags' => 'nullable|string',
        'job_type' => 'required|string',
        'remote' => 'required|boolean',
        'requirements' => 'nullable|string',
        'benefits' => 'nullable|string',
        'address' => 'nullable|string',
        'city' => 'required|string',
        'state' => 'required|string',
        'zipcode' => 'nullable|string',
        'contact_email' => 'required|string',
        'contact_phone' => 'nullable|string',
        'company_name' => 'required|string',
        'company_description' => 'nullable|string',
        'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'company_website' => 'nullable|url',
    ];

    /**
     * Display a listing of the resource.
     * @route [GET] /jobs
     */
    public function index(): View
    {
        $jobs = Job::all();

        return view('jobs.index', compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     * @route [GET] /jobs/create
     */
    public function create()
    {
        return view('jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     * @route [POST] /jobs
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(self::FIELD_VALIDATION);

        // Upload file if exists
        if ($request->hasFile('company_logo')) {
            $file = $request->file('company_logo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filepath = $file->storeAs('jobs/company_logos', $fileName, 'public');

            if ($filepath) {
                // Update validated data with the new file path
                $validatedData['company_logo'] = $fileName;
            } else {
                return redirect()->back()->with('error', 'Failed to upload company logo.');
            }
        }

        Job::create($validatedData + ['user_id' => Auth::user()->id]);

        // When with() is used with redirect(), the data is stored in the session
        return redirect()->route('jobs.index')->with('success', 'Job listing created successfully.');
    }

    /**
     * Display the specified resource.
     * @route [GET] /jobs/{job}
     */
    public function show(Job $job)
    {
        return view('jobs.show')->with('job', $job);
    }

    /**
     * Show the form for editing the specified resource.
     * @route [GET] /jobs/{job}/edit
     */
    public function edit(Job $job): View
    {
        // Check if user is authorized
        $this->authorize('update', $job);

        return view('jobs.edit')->with('job', $job);
    }

    /**
     * Update the specified resource in storage.
     * @route [PUT] /jobs/{job}
     */
    public function update(Request $request, Job $job)
    {
        // Check if user is authorized
        $this->authorize('update', $job);

        $validatedData = $request->validate(self::FIELD_VALIDATION);

        // Upload file if exists
        if ($request->hasFile('company_logo')) {

            $file = $request->file('company_logo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filepath = $file->storeAs('jobs/company_logos', $fileName, 'public');

            if ($filepath) {
                // Update validated data with the new file path
                $validatedData['company_logo'] = $fileName;

                // Delete the old file is exists
                if ($job->company_logo) {
                    Storage::disk('public')->delete('jobs/company_logos/' . $job->company_logo);
                }
            } else {
                return redirect()->back()->with('error', 'Failed to upload company logo.');
            }
        }

        $job->update($validatedData);

        // When with() is used with redirect(), the data is stored in the session
        return redirect()->route('jobs.show', $job)->with('success', 'Job listing updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     * @route [DELETE] /jobs/{job}
     */
    public function destroy(Job $job): RedirectResponse
    {
        // Check if user is authorized
        $this->authorize('delete', $job);

        if ($job->company_logo) {
            Storage::disk('public')->delete('jobs/company_logos/' . $job->company_logo);
        }
        $job->delete();

        // Check if the request was from the dashboard
        if (request()->query('from') == 'dashboard') {
            return redirect()->route('dashboard')->with('success', 'Job listing deleted successfully.');
        }

        // Fallback redirect if we were on the job listing page
        return redirect()->route('jobs.index')->with('success', 'Job listing deleted successfully.');
    }

    /**
     * Show the saved jobs
     * @route [GET] /jobs/saved
     */
    public function saved()
    {
        return view('jobs.saved');
    }
}

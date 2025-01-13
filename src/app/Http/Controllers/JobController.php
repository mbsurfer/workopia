<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class JobController extends Controller
{
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
     */
    public function index(): View
    {
        $jobs = Job::all();

        return view('jobs.index', compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jobs.create');
    }

    /**
     * Store a newly created resource in storage.
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

        //todo: replace user_id with session user id
        Job::create($validatedData + ['user_id' => 1]);

        // When with() is used with redirect(), the data is stored in the session
        return redirect()->route('jobs.index')->with('success', 'Job listing created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        return view('jobs.show')->with('job', $job);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job): View
    {
        return view('jobs.edit')->with('job', $job);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Job $job)
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
     */
    public function destroy(Job $job): RedirectResponse
    {
        if ($job->company_logo) {
            Storage::disk('public')->delete('jobs/company_logos/' . $job->company_logo);
        }
        $job->delete();
        return Redirect::route('jobs.index')->with('success', 'Job listing deleted successfully.');
    }

    /**
     * Show the saved jobs
     */
    public function saved()
    {
        return view('jobs.saved');
    }
}

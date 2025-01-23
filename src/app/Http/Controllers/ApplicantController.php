<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicantController extends Controller
{
    /**
     * Store new job application.
     * @route [POST] /jobs/{job}/apply
     *
     * @param Request $request
     * @param Job $job
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Job $job): RedirectResponse
    {
        // Check is user has already applied
        if ($job->applicants()->where('user_id', Auth::id())->exists()) {
            return back()->with('error', 'You have already applied for this job.');
        }

        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'contact_phone' => 'string',
            'contact_email' => 'required|email',
            'message' => 'string',
            'location' => 'string',
            'resume' => 'required|file|mimes:pdf|max:2048'
        ]);

        // Hanlde resume upload
        if ($request->hasFile('resume')) {
            $file = $request->file('resume');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('applicants/resumes', $fileName, 'public');
            $validatedData['resume'] = $fileName;
        }

        $application  = new Applicant($validatedData);
        $application->job()->associate($job);
        $application->user()->associate(Auth::user());
        $application->save();

        return back()->with('success', 'Application submitted successfully.');
    }

    /**
     * Delete job application.
     *
     * @param Applicant $applicant
     * @return RedirectResponse
     */
    public function destroy(Applicant $applicant): RedirectResponse
    {
        // Delete resume file if it exists
        if ($applicant->resume) {
            $path = storage_path('app/public/applicants/resumes/' . $applicant->resume);
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $applicant->delete();

        return back()->with('success', 'Application deleted successfully.');
    }
}

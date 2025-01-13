<x-layout>
    <x-slot name="title">Edit Job Listing</x-slot>
    <div
        class="bg-white mx-auto p-8 rounded-lg shadow-md w-full md:max-w-3xl"
    >
        <h2 class="text-4xl text-center font-bold mb-4">
            Edit Job Listing
        </h2>
        <form
            method="POST"
            action="{{ route('jobs.update', $job) }}"
            enctype="multipart/form-data"
        >
            @csrf
            @method('PUT')
            <h2
                class="text-2xl font-bold mb-6 text-center text-gray-500"
            >
                Job Info
            </h2>

            <x-inputs.text id="title" name="title" placeholder="Software Engineer" label="Job Title" :value="$job->title" />

            <x-inputs.text-area id="description" name="description" :value="$job->description" placeholder="We are seeking a skilled and motivated Software Developer to join our growing development team..." label="Job Description" />

            <x-inputs.text id="salary" name="salary" type="number" :value="$job->salary" placeholder="90000" label="Annual Salary" />

            <x-inputs.text-area id="requirements" name="requirements" 
            placeholder="Bachelor's degree in Computer Science" label="Requirements" 
            rows="4" :value="$job->requirements" />

            <x-inputs.text-area id="benefits" name="benefits" 
            placeholder="Health insurance, 401k, paid time off" label="Benefits" 
            rows="2" :value="$job->benefits" />

            <x-inputs.text id="tags" name="tags" :value="$job->tags" placeholder="development,coding,java,python" label="Tags (comma-separated)" />

            <x-inputs.select id="job_type" name="job_type" label="Job Type" :options="[
                'Full-Time' => 'Full-Time',
                'Part-Time' => 'Part-Time',
                'Contract' => 'Contract',
                'Temporary' => 'Temporary',
                'Internship' => 'Internship',
                'Volunteer' => 'Volunteer',
                'On-Call' => 'On-Call',
            ]" :value="$job->job_type" />

            <x-inputs.select id="remote" name="remote" label="Remote" :options="[
                'No' => 0,
                'Yes' => 1,
            ]" :value="$job->remote" />

            <x-inputs.text id="address" name="address" :value="$job->address" placeholder="123 Main St" label="Address" />

            <x-inputs.text id="city" name="city" :value="$job->city" placeholder="Albany" label="City" />

            <x-inputs.text id="state" name="state" :value="$job->state" placeholder="NY" label="State" />
        
            <x-inputs.text id="zipcode" name="zipcode" :value="$job->zipcode" placeholder="12201" label="ZIP Code" />

            <h2
                class="text-2xl font-bold mb-6 text-center text-gray-500"
            >
                Company Info
            </h2>

            <x-inputs.text id="company_name" name="company_name" :value="$job->company_name" placeholder="Company name" label="Company Name" />

            <x-inputs.text-area id="company_description" name="company_description" 
            placeholder="Company description" label="Company Description" 
            rows="2" :value="$job->company_description" />

            <x-inputs.text id="company_website" name="company_website" :value="$job->company_website" placeholder="https://company.com" label="Company Website" type="url" />

            <x-inputs.text id="contact_phone" name="contact_phone" :value="$job->contact_phone" placeholder="Enter phone" label="Contact Phone" />

            <x-inputs.text id="contact_email" name="contact_email" :value="$job->contact_email" type="email" placeholder="Email where you want to receive applications" label="Contact Email" />

            <x-inputs.file id="company_logo" name="company_logo" label="Company Logo" :image="'jobs/company_logos/' . $job->company_logo" />

            <div class="flex space-x-3 ml-4">
                <button
                    type="submit"
                    class="flex-auto bg-green-500 hover:bg-green-600 text-white px-4 py-2 my-3 rounded focus:outline-none"
                >
                    Save
                </button>
                <a
                    href="{{ route('jobs.show', $job) }}"
                    class="flex-auto bg-red-500 hover:bg-red-600 text-white text-center px-4 py-2 my-3 rounded focus:outline-none"
                >
                    Cancel
                </a>
            </div>
            
        </form>
    </div>
</x-layout>
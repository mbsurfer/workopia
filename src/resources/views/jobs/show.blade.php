<x-layout>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Job Details Column -->
        <section class="md:col-span-3">
            <div class="rounded-lg shadow-md bg-white p-3 mb-5">
                <div class="flex justify-between items-center">
                    <a
                        class="block p-4 text-blue-700"
                        href="{{ route('jobs.index') }}"
                    >
                        <i class="fa fa-arrow-alt-circle-left"></i>
                        Back To Listings
                    </a>
                    @can('update', $job)
                        <div class="flex space-x-3 ml-4">
                            <a
                                href="{{ route('jobs.edit', $job) }}"
                                class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded"
                                >Edit</a
                            >
                            <!-- Delete Form -->
                            <form method="POST" action="{{ route('jobs.destroy', $job) }}" onsubmit="return confirm('Are you sure you want to delete this job?')">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded"
                                >
                                    Delete
                                </button>
                            </form>
                            <!-- End Delete Form -->
                        </div>
                    @endcan
                </div>
                <div class="p-4">
                    <h2 class="text-xl font-semibold">
                        {{ $job->title }}
                    </h2>
                    <p class="text-gray-700 text-lg mt-2">
                        {{ $job->description }}
                    </p>
                    <ul class="my-4 bg-gray-100 p-4">
                        <li class="mb-2">
                            <strong>Job Type:</strong> {{ $job->type }}
                        </li>
                        <li class="mb-2">
                            <strong>Remote:</strong> {{ $job->remote ? 'Yes' : 'No' }}
                        </li>
                        <li class="mb-2">
                            <strong>Salary:</strong> ${{ number_format($job->salary) }}
                        </li>
                        <li class="mb-2">
                            <strong>Site Location:</strong> {{ $job->city }}, {{ $job->state }}
                        </li>
                        <li @class(['mb-2', 'hidden' => !$job->tags])>
                            <strong>Tags:</strong>
                            {{ ucwords(str_replace(',', ', ', $job->tags)) }}
                        </li>
                    </ul>
                </div>
            </div>

            <h2 class="text-xl font-semibold mb-4">Job Details</h2>

            <div class="rounded-lg shadow-md bg-white p-4 mb-5">
                <h3
                    class="text-lg font-semibold mb-2 text-blue-500"
                >
                    Job Requirements
                </h3>
                <p>
                    {{ $job->requirements ?? 'No requirements provided' }}
                </p>
                <h3
                    class="text-lg font-semibold mt-4 mb-2 text-blue-500"
                >
                    Benefits
                </h3>
                <p>
                    {{ $job->benefits ?? 'No benefits provided' }}
                </p>
            </div>

            @auth
                @if ($hasApplied)
                    <p class="bg-green-200 rounded-lg p-3 text-center">
                        You have already applied for this job. Good luck!
                    </p>
                @else
                    <div x-data="{ open: {{ $errors->any() ? 'true' : 'false' }} }" id="applicant-form">
                    
                        <button x-on:click="open = true" class="block w-full text-center px-5 py-2.5 shadow-sm rounded border text-base font-medium cursor-pointer text-indigo-700 bg-indigo-100 hover:bg-indigo-200">
                            Apply Now
                        </button>

                        <div x-show="open" x-cloak class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
                            <div x-on:click.away="open = false" class="bg-white p-6 rounded-lg shadow-md w-full max-w-md">
                                <h3 class="text-lg font-semibold mb-4">
                                    Apply for {{ $job->title }}
                                </h3>
                                <form method="POST" action={{ route('applicants.store', $job) }} enctype="multipart/form-data">
                                    @csrf
                                    <x-inputs.text id="full_name" name="full_name" label="Full Name" placeholder="John Smith" :required="true" />
                                    <x-inputs.text id="contact_phone" name="contact_phone" label="Contact Phone" placeholder="(555) 555-5555" />
                                    <x-inputs.text id="contact_email" name="contact_email" label="Contact Email" placeholder="jsmith@gmail.com" type="email" :required="true" />
                                    <x-inputs.text-area id="message" name="message" label="Message" placeholder="" />
                                    <x-inputs.text id="location" name="location" label="Location" placeholder="Los Angeles, CA" />
                                    <x-inputs.file id="resume" name="resume" label="Upload Your Resume (pdf)" :required="true" />

                                    <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md">Submit Application</button>
                                    <button x-on:click="open = false" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-md">Cancel</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <p class="bg-gray-200 rounded-lg p-3">
                    <i class="fa fa-info-circle mr-3"></i>
                    <a href="{{ route('login') }}" class="text-blue-500">Log in</a> to apply for this job!
                </p>
            @endauth

            <div class="bg-white p-6 rounded-lg shadow-md mt-6">
                <div id="map"></div>
            </div>
        </section>

        <!-- Sidebar -->
        <aside class="bg-white rounded-lg shadow-md p-3">
            <h3 class="text-xl text-center mb-4 font-bold">
                Company Info
            </h3>
            @if($job->company_logo)
                <img
                    src="{{ Storage::url('jobs/company_logos/' . $job->company_logo) }}"
                    alt="{{ $job->company_name }} Logo"
                    class="w-full rounded-lg mb-4 m-auto"
                />
            @endif
            <h4 class="text-lg font-bold">{{ $job->company_name }}</h4>
            <p class="text-gray-700 text-lg my-3">
                {{ $job->company_description }}
            </p>
            <a
                href="{{ $job->company_website }}"
                target="_blank"
                class="text-blue-500"
                >Visit Website</a
            >
            @auth
                @if ($isBookmarked)
                    <form action="{{ route('bookmarks.destroy', $job) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button
                            type="submit"
                            class="mt-10 bg-red-500 hover:bg-red-600 text-white font-bold w-full py-2 px-4 rounded-full flex items-center justify-center"
                            ><i class="fas fa-close mr-3"></i> Remove Bookmark
                        </button>
                    </form>
                @else
                    <form action="{{ route('bookmarks.store', $job) }}" method="POST">
                        @method('POST')
                        @csrf
                        <button
                            type="submit"
                            class="mt-10 bg-blue-500 hover:bg-blue-600 text-white font-bold w-full py-2 px-4 rounded-full flex items-center justify-center"
                            ><i class="fas fa-bookmark mr-3"></i> Bookmark
                            Listing
                        </button>
                    </form>
                @endif
            @else
                <p class="mt-10 bg-gray-200 text-grey-700 font-bold with-full py-2 px-4 rounded-full text-center">
                    <i class="fas fa-info-circle mr-3"></i> Log in to bookmark a job
                </p>
            @endauth
        </aside>
    </div>
</x-layout>

<link href="https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.css" rel="stylesheet" />
<script src="https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Mapbox PUBLIC access token
    mapboxgl.accessToken = "{{ config('services.mapbox.key') }}";

    // Initialize the map
    const map = new mapboxgl.Map({
      container: 'map', // ID of the container element
      style: 'mapbox://styles/mapbox/streets-v11', // Map style
      center: [-74.5, 40], // Default center
      zoom: 9, // Default zoom level
    });

    console.log(map);

    // Get address from Laravel view
    const city = '{{ $job->city }}';
    const state = '{{ $job->state }}';
    const address = city + ', ' + state;

    // Geocode the address
    fetch(`/geocode?address=${encodeURIComponent(address)}`)
      .then((response) => response.json())
      .then((data) => {
        if (data.features.length > 0) {

          const [longitude, latitude] = data.features[0]['geometry']['coordinates'];

          // Center the map and add a marker
          map.setCenter([longitude, latitude]);
          map.setZoom(14);

          new mapboxgl.Marker().setLngLat([longitude, latitude]).addTo(map);
        } else {
          console.error('No results found for the address.');
        }
      })
      .catch((error) => console.error('Error geocoding address:', error));
  });
</script>
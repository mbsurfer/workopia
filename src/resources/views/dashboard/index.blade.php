<x-layout>
    <section class="flex flex-col md:flex-row gap-6">
        <!-- Profile Info -->
        <div class="bg-white p-8 rounded-lg shadow-md w-full md:w-1/2">
            <h3 class="text-3xl text-center font-bold mb-4">
                Profile Info
            </h3>
            <form
                method="POST"
                action="{{ route('profile.update') }}"
                enctype="multipart/form-data"
            >
                @csrf
                @method('PUT')
                <x-inputs.text id="name" name="name" label="Name" placeholder="John Doe" :value="$user->name" />
                    <x-inputs.text id="email" name="email" label="Email" placeholder="john@gmail.com" :value="$user->email" />
                <button
                    type="submit"
                    class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 my-3 rounded focus:outline-none"
                >
                    Save
                </button>
            </form>
        </div>

        <!-- My Job Listings -->
        <div class="bg-white p-8 rounded-lg shadow-md w-full">
            <h3 class="text-3xl text-center font-bold mb-4">
                My Job Listings
            </h3>
            <!-- Listing 1 -->
            @forelse ($jobs as $job)
                <div class="flex justify-between items-center border-b-2 border-gray-200 py-2">
                    <div>
                        <h3 class="text-xl font-semibold">
                            <a href="{{ route('jobs.show', $job) }}">{{ $job->title }}</a>
                        </h3>
                        <p class="text-gray-700">{{ $job->job_type }}</p>
                    </div>
                    <div class="flex gap-3">
                        <a
                            href="{{ route('jobs.edit', $job) }}"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm"
                            >Edit</a
                        >
                        <form method="POST" action="{{ route('jobs.destroy', $job) }}?from=dashboard">
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded text-sm"
                                onclick="return confirm('Are you sure you want to delete this job listing?');"
                            >
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-gray-700 text-center">You do not own any job listings</p>
            @endforelse
        </div>
    </section>
    <x-bottom-banner />
</x-layout>
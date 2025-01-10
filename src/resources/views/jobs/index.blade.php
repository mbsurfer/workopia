<x-layout>
    <h1>Hot Jobs!</h1>
    <ul>
        @forelse($jobs as $job)
        <li style="background-color: {{ $loop->even ? 'lightgrey' : 'white' }};">
            <a href="{{route('jobs.show', $job->id)}}">{{ $job->title }}: {{ $job->description }}</a>
        </li>
        @empty
        <li>No jobs available</li>
        @endforelse
    </ul>
</x-layout>
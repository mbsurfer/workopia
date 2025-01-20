@php
    $navigation = [
        'auth' => [
            ['jobs','All Jobs'],
            ['bookmarks','Saved Jobs'],
        ],
        'unauth' => [
            ['login','Login'],
            ['register','Register'],
        ],
    ]
@endphp
<header class="bg-blue-900 text-white p-4" x-data="{ open: false }">
    <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-3xl font-semibold">
            <a href="{{url('/')}}">Workopia</a>
        </h1>
        <nav class="hidden md:flex items-center space-x-4">
            @auth
                @foreach($navigation['auth'] as $nav)
                    <x-nav-link url="{{$nav[0]}}" :active="request()->is($nav[0])" :icon="$nav[2] ?? null">{{$nav[1]}}</x-nav-link>
                @endforeach
                <x-logout-button />
                    <a href="{{route('dashboard')}}">
                        <img
                            src="{{ (Auth::user()->avatar) ? asset('storage/users/avatars/'. Auth::user()->avatar) : asset('images/default-avatar.png') }}"
                            alt="{{ Auth::user()->name }}"
                            class="w-10 h-10 rounded-full"
                        >
                    </a>
                <x-button-link url="/jobs/create" icon="edit">Create Job</x-button-link>
            @else
                @foreach($navigation['unauth'] as $nav)
                    <x-nav-link url="{{$nav[0]}}" :active="request()->is($nav[0])" :icon="$nav[2] ?? null">{{$nav[1]}}</x-nav-link>
                @endforeach
            @endauth
            
        </nav>
        <button
            id="hamburger"
            class="text-white md:hidden flex items-center"
            @click="open = !open"
        >
            <i class="fa fa-bars text-2xl"></i>
        </button>
    </div>
    <!-- Mobile Menu -->
    <nav
        id="mobile-menu"
        class="md:hidden bg-blue-900 text-white mt-5 pb-4 space-y-2"
        x-show="open"
        @click.away="open = false"
    >
        @auth
            @foreach($navigation['auth'] as $nav)
                <x-nav-link url="{{$nav[0]}}" :active="request()->is($nav[0])" :mobile="true" :icon="$nav[2] ?? null">{{$nav[1]}}</x-nav-link>
            @endforeach
            <x-nav-link url="dashboard" :active="request()->is('dashboard')" :mobile="true" icon="gauge">Dashboard</x-nav-link>
            <x-logout-button :mobile="true" />
            <x-button-link url="/jobs/create" icon="edit" :block="true">Create Job</x-button-link>
        @else
            @foreach($navigation['unauth'] as $nav)
                <x-nav-link url="{{$nav[0]}}" :active="request()->is($nav[0])" :mobile="true" :icon="$nav[2] ?? null">{{$nav[1]}}</x-nav-link>
            @endforeach
        @endauth
        
    </nav>
</header>
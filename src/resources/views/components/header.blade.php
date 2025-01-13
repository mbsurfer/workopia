@php
    $navigation = [
        ['/jobs','All Jobs'],
        ['/jobs/saved','Saved Jobs'],
        ['/login','Login'],
        ['/register','Register'],
        ['/dashboard','Dashboard'],
    ]
@endphp
<header class="bg-blue-900 text-white p-4" x-data="{ open: false }">
    <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-3xl font-semibold">
            <a href="{{url('/')}}">Workopia</a>
        </h1>
        <nav class="hidden md:flex items-center space-x-4">
            @foreach($navigation as $nav)
                <x-nav-link url="{{$nav[0]}}" :active="request()->is($nav[0])">{{$nav[1]}}</x-nav-link>
            @endforeach
            <x-button-link url="/jobs/create" icon="edit">Create Job</x-button-link>
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
        @foreach($navigation as $nav)
            <x-nav-link url="{{$nav[0]}}" :active="request()->is($nav[0])" :mobile="true">{{$nav[1]}}</x-nav-link>
        @endforeach
        <x-button-link url="/jobs/create" icon="edit" :block="true">Create Job</x-button-link>
    </nav>
</header>
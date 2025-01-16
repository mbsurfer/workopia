@props(['mobile' => false])

<form action="{{ route('logout') }}" method="POST">
    @csrf
    @if($mobile)
        <button
            type="submit"
            class="w-full px-4 py-2 hover:bg-blue-700 text-left"
        >
            <i class="fa fa-sign-out"></i> Logout
        </button>
    @else
        <button
            type="submit"
            class=" text-white"
        >
            <i class="fa fa-sign-out"></i> Logout
        </button>
    @endif
</form>
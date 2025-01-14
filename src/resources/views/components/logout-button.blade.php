<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button
        type="submit"
        class=" text-white px-4"
    >
        <i class="fa fa-sign-out"></i> Logout
    </button>
</form>
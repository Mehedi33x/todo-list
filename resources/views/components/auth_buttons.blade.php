<div class="d-flex justify-content-end">
    @if (auth()->hasUser())
        <a href="{{ route('auth.logout') }}" class="btn btn-primary">Logout</a>
    @else
        <a href="{{ route('auth.login') }}" class="btn btn-primary me-2">Login</a>
    @endif
</div>

{{-- <div class="btn-group">
    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        Login/Register
    </button>
    <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="{{ route('auth.login') }}">Login</a></li>
        <li><a class="dropdown-item" href="{{ route('auth.register') }}">Register</a></li>
    </ul>
</div> --}}

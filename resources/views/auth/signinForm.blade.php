<div class="col align-items-center flex-col sign-in">
    <div class="form-wrapper align-items-center">
        <div class="form sign-in">
            <form action="{{ route('do.login') }}" method="POST">
                @csrf
                <div class="input-group">
                    <i class='bx bxs-user'></i>
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="input-group">
                    <i class='bx bxs-lock-alt'></i>
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit">Sign in</button>
            </form>
            <p><a href="{{route('forget.password')}}">Forgot password?</a></p>
            <p>
                <span>Don't have an account?</span>
                <b onclick="toggle()" class="pointer">Sign up here</b>
            </p>
            {{-- social login --}}
            @include('auth.socialAuth')
        </div>
    </div>
    <div class="form-wrapper"></div>
</div>
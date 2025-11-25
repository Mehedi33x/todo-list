<div class="col align-items-center flex-col sign-up">
    <div class="form-wrapper align-items-center">
        <div class="form sign-up">
            <form action="{{ route('do.register') }}" method="POST">
                @csrf
                <div class="input-group">
                    <i class='bx bxs-user'></i>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Username"
                        required>
                </div>
                <div class="input-group">
                    <i class='bx bx-mail-send'></i>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Email"
                        required>
                </div>
                <div class="input-group">
                    <i class='bx bxs-lock-alt'></i>
                    <input type="password" name="password" value="{{ old('password') }}"
                        placeholder="Password" required>
                </div>
                <div class="input-group">
                    <i class='bx bxs-lock-alt'></i>
                    <input type="password" name="confirm_password" value="{{ old('confirm_password') }}"
                        placeholder="Confirm password" required>
                </div>
                <button type="submit">Sign up</button>
            </form>
            <p>
                <span>Already have an account?</span>
                <b onclick="toggle()" class="pointer">Sign in here</b>
            </p>
            {{-- social login --}}
            @include('auth.socialAuth')
        </div>
    </div>
</div>
@extends('auth.verification')
@section('heading')
    Reset Password
@endsection
@section('form_section')
    <div class="form-wrapper align-items-center">
        <div class="form sign-up">
            <form action="{{ route('reset.password') }}" method="POST">
                @csrf
                <p><b>Reset your password</b></p>
                <div class="input-group">
                    <i class='bx bx-mail-send'></i>
                    <input type="password" name="password" value="{{ old('password') }}" placeholder="Password" required>
                    <input type="password" name="confirm_password" value="{{ old('confirm_password') }}" placeholder="Confirm Password" required>
                </div>

                <button type="submit">Reset Password</button>
            </form>

        </div>
    </div>
@endsection

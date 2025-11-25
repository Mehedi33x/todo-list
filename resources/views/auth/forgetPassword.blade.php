@extends('auth.verification')
@section('heading')
    Reset Password
@endsection
@section('form_section')
    <div class="form-wrapper align-items-center">
        <div class="form sign-up">
            <form action="{{ route('forgot.password.send') }}" method="POST">
                @csrf
                <p><b>Forget your password?</b></p>
                <div class="input-group">
                    <i class='bx bx-mail-send'></i>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" required>
                </div>

                <button type="submit">Reset Password</button>
            </form>

        </div>
    </div>
@endsection

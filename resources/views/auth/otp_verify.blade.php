@extends('auth.verification')
@section('heading')
    Verify OTP
@endsection
@section('form_section')
    <div class="form-wrapper align-items-center">
        <div class="form sign-up">
            <form action="{{ route('verify.otp') }}" method="POST">
                @csrf
                <p><b>OTP Verifciation</b></p>
                <div class="input-group">
                    <i class='bx bx-mail-send'></i>
                    <input type="text" name="otp" value="{{ old('otp') }}" placeholder="Enter the otp" required>
                </div>

                <button type="submit">Verify</button>
            </form>

        </div>
    </div>
@endsection
@extends('layouts.auth')

@section('body')
<div class="d-flex flex-column flex-root">
    <!--begin::Login-->
    <div class="login login-4 login-signup-on d-flex flex-row-fluid" id="kt_login">
        <div class="d-flex flex-center flex-row-fluid bgi-size-cover bgi-position-top bgi-no-repeat"
            style="background-image: url('assets/media/bg/bg-3.jpg');">
            <div class="login-form text-center p-7 position-relative overflow-hidden">
                <!--begin::Login Header-->
                <div class="d-flex flex-center mb-15">
                    <a href="#">
                        <img src="assets/media/logos/logo-letter-13.png" class="max-h-75px" alt="" />
                    </a>
                </div>
                <!--end::Login Header-->

                <!--begin::Login Sign up form-->
                <div class="login-signup">
                    <div class="mb-20">
                        <h3>RESET PASSWORD</h3>
                        <div class="text-muted font-weight-bold">Enter your new password</div>
                    </div>
                    <div>
                        @if ($errors->any())
                        <div class="alert alert-danger">

                            @foreach ($errors->all() as $error)
                            {{ $error }}</br>
                            @endforeach

                        </div>
                        @endif

                    </div>
                    <form class="form" id="registerform" method="post" action="/reset-password">
                        @csrf
                        <input type="hidden" value="{{ request()->route('token') }}" name="token">
                        <div class="form-group mb-5">
                            <input class="form-control h-auto form-control-solid py-4 px-8" type="text"
                                placeholder="Email" name="email" id="email" value="{{ request()->email }}"
                                autocomplete="off" />
                            @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-5">
                            <input class="form-control h-auto form-control-solid py-4 px-8" type="password"
                                placeholder="Password" name="password" id="password" />
                        </div>
                        @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <div class=" form-group mb-5">
                            <input class="form-control h-auto form-control-solid py-4 px-8" type="password"
                                placeholder="Confirm Password" name="password_confirmation"
                                id="password_confirmation" />
                        </div>
                        @error('password_confirmation')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <div class="form-group d-flex flex-wrap flex-center mt-10">
                            <button id="kt_login_signup_submit"
                                class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-2">Reset Password</button>

                        </div>
                    </form>
                </div>
                <!--end::Login Sign up form-->
            </div>
        </div>
    </div>
    <!--end::Login-->
</div>
@endsection

@push('script')
<script src="assets/js/pages/custom/login/login-register.js?v=7.0.6"></script>
@endpush
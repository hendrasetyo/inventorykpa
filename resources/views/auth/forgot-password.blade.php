@extends('layouts.auth')

@section('body')
<div class="d-flex flex-column flex-root">
    <!--begin::Login-->
    <div class="login login-4 login-forgot-on d-flex flex-row-fluid" id="kt_login">
        <div class="d-flex flex-center flex-row-fluid bgi-size-cover bgi-position-top bgi-no-repeat"
            style="background-image: url('assets/media/bg/bg-3.jpg');">
            <div class="login-form text-center p-7 position-relative overflow-hidden">
                <!--begin::Login Header-->
                <div class="d-flex flex-center mb-15">
                    <a href="#">
                        <img src="{{ asset('assets/media/logos/logo-letter-13.png') }}" class="max-h-75px" alt="" />
                    </a>
                </div>
                <!--end::Login Header-->

                <!--begin::Login forgot password form-->
                <div class="login-forgot">
                    <div class="mb-20">
                        <h3>Forgotten Password ?</h3>
                        <div class="text-muted font-weight-bold">Enter your email to reset your password</div>
                    </div>
                    <div class="mb-10">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif
                    </div>
                    <form class="form" action="/forgot-password" method="post" id="kt_login_forgot_form">
                        @csrf
                        <div class="form-group mb-10">
                            <input
                                class="form-control form-control-solid h-auto py-4 px-8 @error('email') is-invalid @enderror"
                                type="email" placeholder="Email" name="email" id="email" autocomplete="off" />
                            @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group d-flex flex-wrap flex-center mt-10">
                            <button id="kt_login_forgot_submit"
                                class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-2">Request</button>
                            <a href="/login" id="kt_login_forgot_cancel"
                                class="btn btn-light-primary font-weight-bold px-9 py-4 my-3 mx-2">Cancel</a>
                        </div>
                    </form>
                </div>
                <!--end::Login forgot password form-->
            </div>
        </div>
    </div>
    <!--end::Login-->
</div>
@endsection

@push('script')
<script src="assets/js/pages/custom/login/login-forgot.js?v=7.0.6"></script>
@endpush
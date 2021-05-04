@extends('layouts.auth')

@section('body')
<div class="d-flex flex-column flex-root">
    <!--begin::Login-->
    <div class="login login-4 login-signin-on d-flex flex-row-fluid" id="kt_login">
        <div class="d-flex flex-center flex-row-fluid bgi-size-cover bgi-position-top bgi-no-repeat"
            style="background-image: url('assets/media/bg/bg-3.jpg');">
            <div class="login-form text-center p-7 position-relative overflow-hidden" style="max-width: 80%">
                <!--begin::Login Header-->
                <div class="d-flex flex-center mb-15">
                    <a href="#">
                        <img src="assets/media/logos/logo-letter-13.png" class="max-h-75px" alt="" />
                    </a>
                </div>
                <!--end::Login Header-->
                <!--begin::Login Sign in form-->
                <div class="login-signin">

                    <div class="mb-10">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            Email Verification Already Sent, Please check your Inbox !
                        </div>
                        @endif
                        @if ($errors->any())

                        <div class="alert alert-danger">

                            @foreach ($errors->all() as $error)
                            {{ $error }}</br>
                            @endforeach

                        </div>
                        @endif
                    </div>


                    <div class="card card-custom wave wave-animate-fast wave-success">
                        <div class="card-body">
                            <div class="d-flex align-items-center p-5">
                                <div class="mr-6">

                                    <span class="svg-icon svg-icon-primary svg-icon-6x">
                                        <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo2\dist/../src/media/svg/icons\Code\Info-circle.svg--><svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                            viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10" />
                                                <rect fill="#000000" x="11" y="10" width="2" height="7" rx="1" />
                                                <rect fill="#000000" x="11" y="7" width="2" height="2" rx="1" />
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon--></span>
                                </div>
                                <div class="d-flex flex-column" style="text-align: left">
                                    <a href="#" class="text-dark text-hover-primary font-weight-bold font-size-h4 mb-3">
                                        <h3>Email Verification</h3>
                                    </a>
                                    <div class="text-dark-75">
                                        <div>
                                            <h4>You have not verified your account !</h4>
                                            <p>
                                                Please check your email to verified your account. If you didn't receive
                                                your verification email :
                                                <form action="/email/verification-notification" method="post">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary"> Send Email
                                                        Verification</button>
                                                </form>


                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <!--end::Login Sign in form-->

            </div>
        </div>
    </div>
    <!--end::Login-->
</div>
@endsection


@push('script')
<script src="assets/js/pages/custom/login/login-general.js?v=7.0.6"></script>
@endpush
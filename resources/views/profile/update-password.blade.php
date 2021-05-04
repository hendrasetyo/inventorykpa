@extends('layouts.app', ['title' => 'Update Profile'])

@section('content')
<div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-12  subheader-transparent " id="kt_subheader">
        <div class=" container  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <!--begin::Mobile Toggle-->
                <button class="burger-icon burger-icon-left mr-4 d-inline-block d-lg-none"
                    id="kt_subheader_mobile_toggle">
                    <span></span>
                </button>
                <!--end::Mobile Toggle-->

                <!--begin::Heading-->
                <div class="d-flex flex-column">
                    <!--begin::Title-->
                    <h2 class="text-white font-weight-bold my-2 mr-5">
                        My Profile</h2>
                    <!--end::Title-->

                    <!--begin::Breadcrumb-->
                    <div class="d-flex align-items-center font-weight-bold my-2">
                        <!--begin::Item-->
                        <a href="#" class="opacity-75 hover-opacity-100">
                            <i class="flaticon2-shelter text-white icon-1x"></i>
                        </a>
                        <!--end::Item-->

                        <!--begin::Item-->
                        <span class="label label-dot label-sm bg-white opacity-75 mx-3"></span>
                        <a href="" class="text-white text-hover-white opacity-75 hover-opacity-100">
                            Profile </a>
                        <!--end::Item-->

                        <!--begin::Item-->
                        <span class="label label-dot label-sm bg-white opacity-75 mx-3"></span>
                        <a href="" class="text-white text-hover-white opacity-75 hover-opacity-100">
                            Personal Information </a>
                        <!--end::Item-->
                    </div>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Heading-->

            </div>
            <!--end::Info-->


        </div>
    </div>
    <!--end::Subheader-->

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class=" container ">
            @if (session('status'))
            <div class="alert alert-custom alert-success fade show pb-2 pt-2" role="alert">
                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                <div class="alert-text">{{ session('status') }}</div>
                <div class="alert-close">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="ki ki-close"></i></span>
                    </button>
                </div>
            </div>

            @endif
            <!--begin::Profile Personal Information-->
            <div class="d-flex flex-row">
                <!--begin::Aside-->
                <x-sideprofile type="3"></x-sideprofile>
                <!--end::Aside-->
                <!--begin::Content-->
                <div class="flex-row-fluid ml-lg-8">
                    <!--begin::Card-->
                    <div class="card card-custom card-stretch">
                        <!--begin::Header-->
                        <div class="card-header py-3">
                            <div class="card-title align-items-start flex-column">
                                <h3 class="card-label font-weight-bolder text-dark">Change Password
                                </h3>
                                <span class="text-muted font-weight-bold font-size-sm mt-1">Change your
                                    current password.</span>
                            </div>
                            <div class="card-toolbar">
                                <button
                                    onclick="event.preventDefault(); document.getElementById('update-form').submit()"
                                    class="btn btn-success mr-2">Save Changes</button>

                            </div>
                        </div>

                        <!--end::Header-->

                        <!--begin::Form-->
                        <form class="form" action="{{ route('password.edit') }}" method="post" id="update-form">
                            <!--begin::Body-->
                            <div class="card-body">
                                @csrf
                                @method('put')

                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label text-right">Current Password</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <input
                                            class="form-control form-control-lg form-control-solid @error('current_password') is-invalid @enderror"
                                            type="password" id="current_password" name="current_password"
                                            value="{{ old('current_password') ?? Auth::user()->current_password }}" />
                                        @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label text-right">New Password</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <input
                                            class="form-control form-control-lg form-control-solid @error('password') is-invalid @enderror"
                                            type="password" id="password" name="password" value="" />
                                        @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label text-right">Password
                                        Confirmation</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <input
                                            class="form-control form-control-lg form-control-solid @error('password_confirmation') is-invalid @enderror"
                                            type="password" id="password_confirmation" name="password_confirmation"
                                            value="{{ old('password_confirmation') ?? Auth::user()->password_confirmation }}" />
                                        @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                </div>


                            </div>
                            <!--end::Body-->
                        </form>
                        <!--end::Form-->
                    </div>
                </div>
                <!--end::Content-->
            </div>
            <!--end::Profile Personal Information-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>
@endsection
@push('script')
<script src="{{ asset('assets/js/pages/widgets.js?v=7.0.6"') }}></script>
<script src=" {{ asset('assets/js/pages/custom/profile/profile.js?v=7.0.6') }}"></script>
@endpush
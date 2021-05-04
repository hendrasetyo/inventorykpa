@extends('layouts.app', ['title' => $title])

@section('content')
<!--begin::Content-->
<div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->

    <!--end::Subheader-->

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid mt-10">
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
            <div class="row">

                <div class="col-lg-12">
                    <!--begin::Card-->
                    <div class="card card-custom gutter-b example example-compact">
                        <div class="card-header ">
                            <div class="card-title">
                                <span class="card-icon">
                                    <span class="svg-icon svg-icon-primary svg-icon-2x">
                                        <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo2\dist/../src/media/svg/icons\Communication\Shield-user.svg--><svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                            viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <path
                                                    d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z"
                                                    fill="#000000" opacity="0.3" />
                                                <path
                                                    d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z"
                                                    fill="#000000" opacity="0.3" />
                                                <path
                                                    d="M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 C14.5228466,17 11.463736,17 7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z"
                                                    fill="#000000" opacity="0.3" />
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon--></span>
                                </span>
                                <h3 class="card-label">Company</h3>
                            </div>

                            <div class="card-toolbar">
                                {{-- <a href="{{ route('assignpermission.index') }}"
                                class="btn btn-light-danger font-weight-bold mr-2">
                                <i class="flaticon2-left-arrow-1"></i> Back
                                </a> --}}
                            </div>
                        </div>
                        <!--begin::Form-->
                        <div class="card-body">

                            <form class="form" method="post" action="{{ route('company.update') }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Nama Perusahaan</label>
                                        <div class="col-lg-6">
                                            <input type="text" name="nama" value="{{ old('nama') ?? $company->nama }}"
                                                class="form-control @error('nama') is-invalid @enderror"
                                                placeholder="Masukkan Nama Perusahaan" />
                                            @error('nama')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Alamat</label>
                                        <div class="col-lg-6">
                                            <textarea name="alamat"
                                                class="form-control @error('alamat') is-invalid @enderror" rows="3"
                                                placeholder="Masukkan Alamat Customer">{{ old('alamat') ?? $company->alamat }}</textarea>
                                            @error('alamat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Telepon</label>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control @error('tlp') is-invalid @enderror"
                                                name="tlp" value="{{ old('tlp') ?? $company->tlp }}" />
                                            @error('tlp')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Fax</label>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control @error('fax') is-invalid @enderror"
                                                name="fax" value="{{ old('fax') ?? $company->fax }}" />
                                            @error('fax')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Email</label>
                                        <div class="col-lg-6">
                                            <input type="email"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                value="{{ old('email') ?? $company->email }}" />
                                            @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Website</label>
                                        <div class="col-lg-6">
                                            <input type="text"
                                                class="form-control @error('website') is-invalid @enderror"
                                                name="website" value="{{ old('website') ?? $company->website }}" />
                                            @error('website')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">NPWP</label>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control @error('npwp') is-invalid @enderror"
                                                name="npwp" value="{{ old('npwp') ?? $company->npwp }}" />
                                            @error('npwp')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Latitude</label>
                                        <div class="col-lg-6">
                                            <input type="text"
                                                class="form-control @error('latitude') is-invalid @enderror"
                                                name="latitude" value="{{ old('latitude') ?? $company->latitude }}" />
                                            @error('latitude')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Longitude</label>
                                        <div class="col-lg-6">
                                            <input type="text"
                                                class="form-control @error('longitude') is-invalid @enderror"
                                                name="longitude"
                                                value="{{ old('longitude') ?? $company->longitude }}" />
                                            @error('longitude')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Logo Perusahaan
                                        </label>
                                        <div class="col-lg-9 col-xl-6">
                                            <div class="image-input image-input-outline" id="kt_profile_avatar"
                                                style="background-image: url({{ asset('assets/media/users/blank.png') }})">
                                                <div class="image-input-wrapper"
                                                    style="background-image: url({{ asset('storage/'.$company->logo) }})">
                                                </div>

                                                <label
                                                    class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                    data-action="change" data-toggle="tooltip" title=""
                                                    data-original-title="Change Logo">
                                                    <i class="fa fa-pen icon-sm text-muted"></i>
                                                    <input type="file" name="logo" id="logo"
                                                        accept=".png, .jpg, .jpeg" />
                                                    <input type="hidden" id="profile_logo_remove"
                                                        name="profile_logo_remove" value='0' />
                                                </label>

                                                <span
                                                    class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                    data-action="cancel" data-toggle="tooltip" title="Cancel logo">
                                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                </span>

                                                <span
                                                    class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                    data-action="remove" data-toggle="tooltip" title="Remove Logo">
                                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                </span>
                                            </div>
                                            <span class="form-text text-muted">Allowed file types: .PNG</span>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Form-->
                                <div class="card-footer text-right">
                                    <div class="row">
                                        <div class="col-lg-12 ">
                                            <button type="submit" class="btn btn-success font-weight-bold mr-2"><i
                                                    class="flaticon2-paperplane"></i>
                                                Save</button>

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!--end::Card-->


                    </div>
                </div>

            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
    <!--end::Content-->
    <div id="modal-confirm-delete"></div>
    @endsection
    @push('script')
    <script src="{{ asset('/assets/js/pages/crud/forms/widgets/select2.js?v=7.0.6"') }}"></script>
    <script src="{{ asset('/assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.6') }}"></script>
    <script src="{{ asset('/assets/js/pages/crud/datatables/extensions/responsive.js?v=7.0.6') }}"></script>
    <script src="{{ asset('assets/js/pages/custom/profile/profile.js?v=7.0.6') }}"></script>


    <script type="text/javascript">


    </script>
    @endpush
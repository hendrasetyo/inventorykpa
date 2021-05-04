@extends('layouts.app', ['title' => 'Role And Permissions'])

@section('content')
<!--begin::Content-->
<div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-12  subheader-transparent " id="kt_subheader">
        <div class=" container  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">

                <!--begin::Heading-->
                <div class="d-flex flex-column">
                    <!--begin::Title-->
                    <h2 class="text-white font-weight-bold my-2 mr-5">
                        Role & Permission </h2>
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
                        <a href="#" class="text-white text-hover-white opacity-75 hover-opacity-100">
                            Role & Permission </a>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <span class="label label-dot label-sm bg-white opacity-75 mx-3"></span>
                        <a href="#" class="text-white text-hover-white opacity-75 hover-opacity-100">
                            Edit Permissions </a>
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
            <div class="row">
                <div class="col-lg-4">
                    <!--begin::Card-->
                    <div class="card card-custom gutter-b example example-compact">
                        <div class="card-header">
                            <h3 class="card-title">
                                Edit Permissions
                            </h3>
                            <div class="card-toolbar">
                                <div class="example-tools justify-content-center">

                                </div>
                            </div>
                        </div>
                        <!--begin::Form-->
                        <form class="form" method="post" action="{{ route('permissions.update', $permission) }}">
                            @csrf
                            @method('put')
                            @include('permissions.permission.partials.form-control', ['submit' => 'Update'])
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Card-->


                </div>
                <div class="col-lg-8">
                    <!--begin::Card-->
                    <div class="card card-custom gutter-b example example-compact">
                        <div class="card-header">
                            <h3 class="card-title">
                                Tables of Permissions
                            </h3>
                            <div class="card-toolbar">
                                <div class="example-tools justify-content-center">

                                </div>
                            </div>
                        </div>
                        <!--begin::Form-->
                        <div class="card-body">
                            <table class="table table-hover">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Guard Name</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                                @foreach ($permissions as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->guard_name }}</td>
                                    <td>{{ $item->created_at->format("d F Y") }}</td>
                                    <td><a href="{{ route('permissions.edit', $item) }}"
                                            class="btn btn-primary btn-sm">Edit</a></td>


                                </tr>
                                @endforeach
                            </table>
                        </div>
                        <!--end::Form-->
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

@endsection
@push('script')
<script src="{{ asset('assets/js/pages/widgets.js?v=7.0.6"') }}></script>
@endpush
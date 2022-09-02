@extends('layouts.app', ['title' => $title])

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
                        Stok Produk Berdasarkan Expired Date</h2>
                    <!--end::Title-->


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

                <div class="col-lg-12">
                    <!--begin::Card-->
                    <div class="card card-custom gutter-b example example-compact">
                        <div class="card-header">
                            <h3 class="card-title">
                                Expired Date Stok</i>
                            </h3>
                            <div class="card-toolbar">
                                <div class="example-tools justify-content-center">
                                    <a href="{{ route('laporanstok.expstok') }}"
                                        class="btn btn-danger font-weight-bolder ">
                                        <i class="flaticon2-fast-back"></i>
                                        Back
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!--begin::Form-->
                        <div class="card-body">
                            <table class="table table-striped table-bordered  table-hover kt_table_1">
                                <thead>
                                    <tr>
                                        <th style="width:5%;">No.</th>
                                        <th style="width:15%;">Expired Date</th>
                                        <th>Nama Produk</th>
                                        <th style="width:10%;">Kode Produk</th>
                                        <th style="width:10%;">Sorted Date</th>
                                        <th style="width:5%;">Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    

                                    @foreach ($stok as $index => $a)
                                    
                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                        <td>{{ $a->tanggal->format("d-m-Y")  }}</td>

                                        <td>{{ $a->products->nama }}</td>
                                        <td>{{ $a->products->kode }}</td>
                                        <td>{{ $a->tanggal->format("Ymd")  }}</td>
                                        <td>{{ $a->qty }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
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
<script src="{{ asset('assets/js/pages/widgets.js?v=7.0.6"') }}"></script>
<script src="{{ asset('/assets/js/pages/crud/forms/widgets/select2.js?v=7.0.6') }}"></script>
<script src="{{ asset('/assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.6') }}"></script>
<script src="{{ asset('/assets/js/pages/crud/datatables/extensions/responsive.js?v=7.0.6') }}"></script>
<script src="{{ asset('/assets/js/pages/crud/datatables/basic/paginations.js') }}"></script>

<script type="text/javascript">




</script>
@endpush
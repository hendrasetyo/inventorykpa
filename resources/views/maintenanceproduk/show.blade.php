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
            <!-- begin::Card-->
            <div class="card card-custom overflow-hidden">
                <div class="card-body p-0">
                    <!-- begin: Invoice-->
                    <!-- begin: Invoice header-->
                    <div class="row justify-content-center py-8 px-8 py-md-27 px-md-0">
                        <div class="col-md-9">
                            <div class="d-flex justify-content-between pb-10 pb-md-20 flex-column flex-md-row">
                                <h1 class="display-4 font-weight-boldest mb-10">PERAWATAN / MAINTENANCE</h1>
                                <div class="d-flex flex-column align-items-md-end px-0">
                                    <!--begin::Logo-->
                                    <a href="#" class="mb-5">
                                        <img src="assets/media/logos/logo-dark.png" alt="" />
                                    </a>
                                    <!--end::Logo-->
                                    <span class=" d-flex flex-column align-items-md-end opacity-70">
                                        <span>{{ \Carbon\Carbon::parse($maintenance->tanggal)->format('d F Y') }}</span>
                                        <span>{{ $maintenance->creator->name }}</span>

                                    </span>
                                </div>
                            </div>
                            <div class="border-bottom w-100"></div>
                            <div class="d-flex justify-content-between pt-6">
                                <div class="d-flex flex-column flex-root">
                                    <span class="font-weight-bolder mb-2">NAMA LAB/RS</span>
                                    <span class="opacity-70">{{ $maintenance->nama_lab }}</span>
                                </div>
                                <div class="d-flex flex-column flex-root">
                                    <span class="font-weight-bolder mb-2">PEMOHON</span>
                                    <span class="opacity-70">{{ $maintenance->pemohon }}</span>
                                </div>
                                <div class="d-flex flex-column flex-root">
                                    <span class="font-weight-bolder mb-2">BAGIAN</span>
                                    <span class="opacity-70">{{ $maintenance->bagian }}</span>
                                </div>
                                <div class="d-flex flex-column flex-root">
                                    <span class="font-weight-bolder mb-2">TELEPON</span>
                                    <span class="opacity-70">{{ $maintenance->telepon }}</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between pt-6">
                                <div class="d-flex flex-column flex-root">
                                    <span class="font-weight-bolder mb-2">TANGGAL PENGERJAAN</span>
                                    <span class="opacity-70">{{ \Carbon\Carbon::parse($maintenance->tanggal_pengerjaan)->format('d F Y')  }}</span>
                                </div>
                                <div class="d-flex flex-column flex-root">
                                    <span class="font-weight-bolder mb-2">Tanggal SELESAI PENGERJAAN</span>
                                    <span class="opacity-70">{{ \Carbon\Carbon::parse($maintenance->tanggal_selesai_pengerjaan)->format('d F Y')  }}</span>
                                </div>
                                <div class="d-flex flex-column flex-root">
                                    <span class="font-weight-bolder mb-2">TEMPAT PENGERJAAN</span>
                                    <span class="opacity-70">{{ $maintenance->tempat_pengerjaan }} </span>
                                </div>
                                <div class="d-flex flex-column flex-root">
                                    <span class="font-weight-bolder mb-2">SARAN</span>
                                    <span class="opacity-70">{{ $maintenance->saran }} </span>
                                </div>
                            </div>                
                        </div>
                    </div>
                    <!-- end: Invoice header-->

                    <!-- begin: Invoice body-->
                    <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                        <div class="col-md-9">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="pl-0 font-weight-bold text-muted  text-uppercase">Nama Alat
                                            </th>
                                            <th class="text-left font-weight-bold text-muted text-uppercase">No Seri
                                            </th>
                                            <th class="text-left font-weight-bold text-muted text-uppercase">Keluhan
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($maintenance->sebelumKondisi as $a)
                                        <tr class="font-weight-boldest">
                                            <td class="pl-0 pt-7">{{ $a->nama_alat }}</td>
                                            <td class="text-left pt-7">{{ $a->no_seri }}</td>
                                            <td class="text-left pt-7">{{ $a->keluhan }}</td>                                           
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- end: Invoice body-->

                      <!-- begin: Invoice body-->
                      <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                        <div class="col-md-9">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="pl-0 font-weight-bold text-muted  text-uppercase">Nama Sparepart
                                            </th>
                                            <th class="text-left font-weight-bold text-muted text-uppercase">QTY
                                            </th>
                                            <th class="text-left font-weight-bold text-muted text-uppercase">Pekerjaan </th>                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($maintenance->setelahKondisi as $a)
                                        <tr class="font-weight-boldest">
                                            <td class="pt-7">{{ $a->nama_sparepart }}</td>
                                            <td class="text-left pt-7">{{ $a->qty }}</td>
                                            <td class="text-left pt-7">{{ $a->pekerjaan }}</td>                                           
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- end: Invoice body-->

                    <!-- begin: Invoice footer-->
                   
                    <!-- end: Invoice footer-->
                    <!-- begin: Invoice footer-->
                    <div class="row justify-content-center  py-8 px-8 py-md-10 px-md-0">
                        <div class="col-md-9">
                            <div class="border-bottom w-100"></div>


                            <div class="card card-custom gutter-b">
                                <div class="card-header">
                                    <div class="card-title justify-content-center">
                                        <h3 class="card-label  ">
                                            Info

                                        </h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="font-weight-bold text-muted  text-uppercase">Created at</th>
                                                <th class="font-weight-bold text-muted  text-uppercase">Created by </th>
                                                <th class="font-weight-bold text-muted  text-uppercase">Updated At</th>
                                                <th class="font-weight-bold text-muted  text-uppercase">Updated By</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="font-weight-bolder">
                                                <td>{{ $maintenance->created_at }}</td>
                                                <td>{{ $maintenance->creator->name }}</td>
                                                <td>{{ $maintenance->updated_at }}</td>
                                                <td>{{ $maintenance->updater->name }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                        </div>
                    </div>
                    <!-- end: Invoice footer-->

                    <!-- begin: Invoice action-->
                    <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">

                        <div class="col-md-9">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('maintenanceproduk.print', ['maintenanceproduk'=> $maintenance->id])  }}"
                                       class="btn btn-primary " target="_blank">
                                    <i class="flaticon2-print font-weight-bold"></i> Download & Print
                               </a>
                                <a class="btn btn-danger font-weight-bold"
                                    href="{{ route('maintenanceproduk.index') }}">Back </a>
                            </div>
                        </div>
                    </div>
                    <!-- end: Invoice action-->

                    <!-- end: Invoice-->
                </div>
            </div>
            <!-- end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>
<!--end::Content-->

@endsection
@push('script')
<script src="{{ asset('/assets/js/pages/crud/forms/widgets/select2.js?v=7.0.6"') }}"></script>
<script src="{{ asset(' /assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.6') }}"></script>
<script src="{{ asset('/assets/js/pages/crud/datatables/extensions/responsive.js?v=7.0.6') }}"></script>
<script src="{{ asset('/assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js?v=7.0.6') }}"></script>


<script type="text/javascript">


</script>
@endpush
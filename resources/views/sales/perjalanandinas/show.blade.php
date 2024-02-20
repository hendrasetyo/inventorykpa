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
                                <h1 class="display-4 font-weight-boldest mb-10">PERJALANAN DINAS</h1>
                                <div class="d-flex flex-column align-items-md-end px-0">
                                    <!--begin::Logo-->
                                    <a href="#" class="mb-5">
                                        <img src="assets/media/logos/logo-dark.png" alt="" />
                                    </a>
                                    <!--end::Logo-->
                                    <span class=" d-flex flex-column align-items-md-end opacity-70">
                                        <span>{{ \Carbon\Carbon::parse($dinas->created_At)->format('d F Y') }}</span>
                                        <span>{{ $dinas->user->name }}</span>

                                    </span>
                                </div>
                            </div>
                            <div class="border-bottom w-100"></div>
                            <div class="d-flex justify-content-between pt-6">
                                <div class="d-flex flex-column flex-root">
                                    <span class="font-weight-bolder mb-2">NAMA</span>
                                    <span class="opacity-70">{{ $dinas->user->name }}</span>
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
                                            <th class="pl-0 font-weight-bold text-muted  text-uppercase">Tanggal
                                            </th>
                                            <th class="text-left font-weight-bold text-muted text-uppercase">Perjalanan
                                            </th>
                                            <th class="text-left font-weight-bold text-muted text-uppercase">Waktu Mulai - Selesai
                                            </th>
                                            <th class="text-left font-weight-bold text-muted text-uppercase">Jenis Transportasi
                                            </th>
                                            <th class="text-left font-weight-bold text-muted text-uppercase">Waktu Berangkat
                                            </th>
                                            <th class="text-left font-weight-bold text-muted text-uppercase">Nama Hotel
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dinas->perjalanandinas as $item)
                                                <tr>
                                                    <td>{{\Carbon\Carbon::parse($item->tanggal)->format('d/m/Y')}}</td>
                                                    <td>{{ $item->asal_mana . '-' . $item->tujuan }}</td>
                                                    <td>{{\Carbon\Carbon::parse($item->waktu_mulai)->format('H:i') . '-' . \Carbon\Carbon::parse($item->waktu_selesai)->format('H:i')}}</td>
                                                    <td>{{ $item->jenis_transportasi }}</td>
                                                    <td>{{\Carbon\Carbon::parse($item->waktu_berangkat)->format('H:i')}}</td>
                                                    <td>{{ $item->nama_hotel }}</td>                                                    
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
                                            <th class="pl-0 font-weight-bold text-muted  text-uppercase">Perusahaan / Institusi
                                            </th>
                                            <th class="text-left font-weight-bold text-muted text-uppercase">Nama
                                            </th>
                                            <th class="text-left font-weight-bold text-muted text-uppercase">Jenis Entertainment </th>                                                                                    
                                            <th class="text-left font-weight-bold text-muted text-uppercase">Tujuan Entertainment </th>                                            
                                        </tr>
                                    </thead>
                                    <tbody> 

                                        @foreach ($dinas->entertaindinas as $item)
                                            <tr>
                                                <td>{{$item->nama_perusahaan}}</td>
                                                <td>{{$item->nama}}</td>
                                                <td>{{$item->jenis_entertainment}}</td>
                                                <td>{{$item->tujuan_entertainment}}</td>
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
                                                <td>{{ $dinas->created_at }}</td>
                                                <td>{{ $dinas->creator->name }}</td>
                                                <td>{{ $dinas->updated_at }}</td>
                                                <td>{{ $dinas->updater->name }}</td>
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
                                <a href="{{ route('perjalanandinas.print', ['id'=>$dinas->id]) }}"
                                       class="btn btn-primary " target="_blank">
                                    <i class="flaticon2-print font-weight-bold"></i> Download & Print
                               </a>
                                <a class="btn btn-danger font-weight-bold"
                                    href="{{ route('perjalanandinas.index') }}">Back </a>
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
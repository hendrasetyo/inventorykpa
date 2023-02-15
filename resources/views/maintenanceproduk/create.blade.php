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
            @if (session('error'))
            <div class="alert alert-custom alert-success fade show pb-2 pt-2" role="alert">
                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                <div class="alert-text">{{ session('error') }}</div>
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
                                <h3 class="card-label">Perawatan Produk</h3>
                            </div>

                            <div class="card-toolbar">                               
                            </div>
                        </div>
                        <!--begin::Form-->
                        <div class="card-body">

                            <form class="form" method="post" action="{{ route('maintenanceproduk.store') }}">
                                @csrf
                                @include('maintenanceproduk.partial._form-add')
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
    <div id="modal-confirm-delete">
        <!-- Modal-->
        <div class="modal fade" id="detailDeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="destroy-form" action="#">
                        <input type="hidden" id="id_detail" name="id_detail" value="">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Are You Sure?</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i aria-hidden="true" class="ki ki-close"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <span class="svg-icon svg-icon-primary svg-icon-4x">
                                        <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo2\dist/../src/media/svg/icons\Code\Warning-2.svg--><svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                            viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <path
                                                    d="M11.1669899,4.49941818 L2.82535718,19.5143571 C2.557144,19.9971408 2.7310878,20.6059441 3.21387153,20.8741573 C3.36242953,20.9566895 3.52957021,21 3.69951446,21 L21.2169432,21 C21.7692279,21 22.2169432,20.5522847 22.2169432,20 C22.2169432,19.8159952 22.1661743,19.6355579 22.070225,19.47855 L12.894429,4.4636111 C12.6064401,3.99235656 11.9909517,3.84379039 11.5196972,4.13177928 C11.3723594,4.22181902 11.2508468,4.34847583 11.1669899,4.49941818 Z"
                                                    fill="#000000" opacity="0.3" />
                                                <rect fill="#000000" x="11" y="9" width="2" height="7" rx="1" />
                                                <rect fill="#000000" x="11" y="17" width="2" height="2" rx="1" />
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon--></span>
                                </div>
                                <div class="col-md-10 " style="display: inline;">
                                    <div class="align-middle">
                                        Deleting Detail Data, will be permanently removed from
                                        system.
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-primary font-weight-bold"
                                data-dismiss="modal">Cancel</button>
                            <button type="button" onClick="javascript:destroy_detail();"
                                class="btn btn-danger font-weight-bold">Yes, Delete Now !</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal-->
    </div>
    <div id="modal-caribarang"></div>
    <div id="modal-before"></div>
    <div id="modal-after"></div>
    @include('maintenanceproduk.modal._form-before-action')
    @include('maintenanceproduk.modal._form-after-action')


    @endsection
    @push('script')
    <script src="{{ asset('/assets/js/pages/crud/forms/widgets/select2.js?v=7.0.6"') }}"></script>
    <script src="{{ asset('/assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.6') }}"></script>
    <script src="{{ asset('/assets/js/pages/crud/datatables/extensions/responsive.js?v=7.0.6') }}"></script>
    <script src="{{ asset('/assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js?v=7.0.6') }}"></script>


    <script type="text/javascript">
      
    function htmlDecode(data){
        var txt = document.createElement('textarea');
        txt.innerHTML=data;
        return txt.value;
    }
    function modalbefore(){
        $('#modalbefore').modal('show');
    }
    function modalafter(){
        $('#modalafter').modal('show');
        
    }

    function submitBefore() {
        var nama_alat = document.getElementById('nama_alat').value;
        var no_seri = document.getElementById('no_seri').value;
        var keluhan = document.getElementById('keluhan').value;

        $.ajax({
                type: 'POST',
                url: '{{ route('maintenanceproduk.submitbefore') }}',
                dataType: 'html',
                headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
                data: {
                    'nama_alat':nama_alat,
                    'no_seri' : no_seri,
                    'keluhan':keluhan, 
                    "_token": "{{ csrf_token() }}"},
                
                success: function (data){
                    $('#modalbefore').modal('hide');
                    $('#nama_alat').val('');
                    $('#no_seri').val('');
                    $('#keluhan').val('');

                    loadData();
                },
                error: function(data){
                    console.log(data);
                }
        });
    }

    function deletebefore(id) {
        Swal.fire({
        title: "Apakah Anda Yakin ?",
        text: "Kamu Tidak Akan Bisa Mengembalikan Data Ini !",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, Hapus!"
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('maintenanceproduk.deletebefore') }}',
                    dataType: 'html',
                    headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
                    data: {
                        'id_temp':id,
                        "_token": "{{ csrf_token() }}"},
                    
                    success: function (data){
                        Swal.fire(
                                "Terhapus!",
                                "Anda Berhasil menghapus Data",
                                "success"
                                 )
                        loadData();
                    },
                    error: function(data){
                        console.log(data);
                    }
                });

               
            }
        });
    }

    function editBefore(id) {
        $.ajax({
                type: 'POST',
                url: '{{ route('maintenanceproduk.editbefore') }}',
                dataType: 'html',
                headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
                data: {id:id, "_token": "{{ csrf_token() }}"},                
                success: function (data){
                    $('#modal-before').html(data);
                    $('#modalbeforeedit').modal('show');
                },
                error: function(data){
                    console.log(data);
                }
        });
    }

    function updateBefore(id) {
        var nama_alat = document.getElementById('nama_alat').value;
        var no_seri = document.getElementById('no_seri').value;
        var keluhan = document.getElementById('keluhan').value;

        $.ajax({
                type: 'POST',
                url: '{{ route('maintenanceproduk.updatebefore') }}',
                dataType: 'html',
                headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
                data: {
                    'id' : id,
                    'nama_alat':nama_alat,
                    'no_seri' : no_seri,
                    'keluhan':keluhan, 
                    "_token": "{{ csrf_token() }}"},
                
                success: function (data){
                    $('#modalbeforeedit').modal('hide');
                    $('#nama_alat').val('');
                    $('#no_seri').val('');
                    $('#keluhan').val('');

                    loadData();
                },
                error: function(data){
                    console.log(data);
                }
        });
    }

    function tabelBefore(){
        $.ajax({
                type: 'POST',
                url: '{{ route('maintenanceproduk.tabelbefore') }}',
                dataType: 'html',
                headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
                data: {
                     "_token": "{{ csrf_token() }}"
                    },
                
                success: function (data){
                    console.log(data);
                    $('#tabel_detil').html(data);

                },
                error: function(data){
                    console.log(data);
                }
        });
    }
    // ################################################# AFTER #############################################################
    function submitAfter() {
        var nama_sparepart = document.getElementById('nama_sparepart').value;
        var qty = document.getElementById('qty').value;
        var pekerjaan = document.getElementById('pekerjaan').value;

        $.ajax({
                type: 'POST',
                url: '{{ route('maintenanceproduk.submitafter') }}',
                dataType: 'html',
                headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
                data: {
                    'nama_sparepart':nama_sparepart,
                    'qty' : qty,
                    'pekerjaan':pekerjaan, 
                    "_token": "{{ csrf_token() }}"},
                
                success: function (data){
                    $('#modalafter').modal('hide');
                    $('#nama_sparepart').val('');
                    $('#qty').val('');
                    $('#pekerjaan').val('');
                    loadData();
                },
                error: function(data){
                    console.log(data);
                }
        });
    }

    function tabelAfter(){
        $.ajax({
                type: 'POST',
                url: '{{ route('maintenanceproduk.tabelafter') }}',
                dataType: 'html',
                headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
                data: {
                     "_token": "{{ csrf_token() }}"
                    },
                
                success: function (data){
                    console.log(data);
                    $('#tabel_detil_after').html(data);

                },
                error: function(data){
                    console.log(data);
                }
        });
    }

    function deleteAfter(id) {
        Swal.fire({
        title: "Apakah Anda Yakin ?",
        text: "Kamu Tidak Akan Bisa Mengembalikan Data Ini !",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, Hapus!"
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('maintenanceproduk.deleteafter') }}',
                    dataType: 'html',
                    headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
                    data: {
                        'id_temp':id,
                        "_token": "{{ csrf_token() }}"},
                    
                    success: function (data){
                        Swal.fire(
                                "Terhapus!",
                                "Anda Berhasil menghapus Data",
                                "success"
                                 )
                        loadData();
                    },
                    error: function(data){
                        console.log(data);
                    }
                });               
            }
        });
    }

    function editAfter(id) {
        $.ajax({
                type: 'POST',
                url: '{{ route('maintenanceproduk.editafter') }}',
                dataType: 'html',
                headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
                data: {id:id, "_token": "{{ csrf_token() }}"},                
                success: function (data){
                    $('#modal-after').html(data);
                    $('#modalafteredit').modal('show');
                },
                error: function(data){
                    console.log(data);
                }
        });
    }

    function updateAfter() {
        var nama_sparepart = document.getElementById('nama_sparepart').value;
        var qty = document.getElementById('qty').value;
        var pekerjaan = document.getElementById('pekerjaan').value;
        var id = document.getElementById('id_temp_after').value;

        $.ajax({
                type: 'POST',
                url: '{{ route('maintenanceproduk.updateafter') }}',
                dataType: 'html',
                headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
                data: {
                    'id' : id,
                    'nama_sparepart':nama_sparepart,
                    'qty' : qty,
                    'pekerjaan':pekerjaan, 
                    "_token": "{{ csrf_token() }}"},
                
                success: function (data){
                    $('#modalafteredit').modal('hide');
                    $('#nama_sparepart').val('');
                    $('#qty').val('');
                    $('#pekerjaan').val('');
                    loadData();
                },
                error: function(data){
                    console.log(data);
                }
        });
    }

  
    
    

    function loadData() {
        tabelBefore();
        tabelAfter();
    }

    </script>
    @endpush
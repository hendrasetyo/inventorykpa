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
                        <div class="card card-custom">
                            <div class="card-header py-3">
                                <div class="card-title">
                                    <span class="card-icon">
                                        <span class="svg-icon svg-icon-md svg-icon-primary">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Shopping/Chart-bar1.svg--><svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                                viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24" />
                                                    <rect fill="#000000" opacity="0.3" x="12" y="4" width="3"
                                                        height="13" rx="1.5" />
                                                    <rect fill="#000000" opacity="0.3" x="7" y="9" width="3"
                                                        height="8" rx="1.5" />
                                                    <path
                                                        d="M5,19 L20,19 C20.5522847,19 21,19.4477153 21,20 C21,20.5522847 20.5522847,21 20,21 L4,21 C3.44771525,21 3,20.5522847 3,20 L3,4 C3,3.44771525 3.44771525,3 4,3 C4.55228475,3 5,3.44771525 5,4 L5,19 Z"
                                                        fill="#000000" fill-rule="nonzero" />
                                                    <rect fill="#000000" opacity="0.3" x="17" y="11" width="3"
                                                        height="6" rx="1.5" />
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon--></span> </span>
                                    <h3 class="card-label">Data Absensi</h3>
                                </div>
                                <div class="card-toolbar">
                                    <div class="">
                                        <a href="{{ route('settingcuti.index') }}" class="btn btn-success mr-2">
                                            <i class="flaticon2-gear"></i> Setting Cuti
                                        </a>
                                    </div>

                                    <div class="">
                                        <button type="button" class="btn btn-info mr-2" data-toggle="modal"
                                            data-target="#export">
                                            <i class="flaticon2-printer"></i> Export
                                        </button>
                                    </div>

                                    <div class="">
                                        <button type="button" class="btn btn-warning mr-2" data-toggle="modal"
                                            data-target="#import">
                                            <i class="flaticon2-hourglass"></i> Import
                                        </button>
                                    </div>
                                    @can('absensi-create')
                                        <a href="{{ route('absensi.create') }}" class="btn btn-primary font-weight-bolder ">
                                            <i class="flaticon2-add"></i>
                                            Absensi
                                        </a>
                                    @endcan
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Tahun</label>
                                            <select name="chart_year" class="form-control" id="kt_select2_1"
                                                onchange="filterabsensiyear()">
                                                @php
                                                    $year = 2020;
                                                @endphp
                                                @foreach (range(date('Y'), $year) as $x)
                                                    <option value="{{ $x }}">{{ $x }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Bulan</label>
                                            <select name="chart_year" class="form-control" id="kt_select2_11"
                                                onchange="filterabsensimonth()">
                                                <option value="All" selected>Semua</option>
                                                @foreach ($bulan as $item)
                                                    <option value="{{ $item['id'] }}">{{ $item['nama'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Nama Karyawan</label>
                                            <select name="chart_year" class="form-control" id="kt_select2_2"
                                                onchange="filterabsensikaryawan()">
                                                <option value="All" selected>Semua</option>
                                                @foreach ($karyawan as $item)
                                                    <option value="{{ $item['id'] }}">{{ $item['nama'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Status</label>
                                            <select name="chart_year" class="form-control" id="kt_select2_3"
                                                onchange="filterabsensistatus()">
                                                <option value="All" selected>Semua</option>
                                                <option value="ontime">Ontime</option>
                                                <option value="ijin">Ijin</option>
                                                <option value="terlambat">Terlambat</option>
                                                <option value="cuti bersama">Cuti Bersama</option>
                                                <option value="error">Error</option>
                                            </select>
                                        </div>
                                    </div>



                                </div>
                                <!--begin: Datatable-->
                                <table class="table yajra-datatable collapsed ">
                                    <thead class="datatable-head">
                                        <tr>
                                            <th>Nama</th>
                                            <th>Tanggal</th>
                                            <th>Clock In</th>
                                            <th>Clock Out</th>
                                            <th>Work Time</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <!--end: Datatable-->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
    <!--end::Content-->
    <div id="modal-confirm-delete"></div>

    @include('hrd.absensi.modal._import')
    @include('hrd.absensi.modal._export')
@endsection
@push('script')
    <script src="{{ asset('/assets/js/pages/crud/forms/widgets/select2.js?v=7.0.6') }}"></script>
    <script src="{{ asset('/assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.6') }}"></script>
    <script src="{{ asset('/assets/js/pages/crud/datatables/extensions/responsive.js?v=7.0.6') }}"></script>




    <script type="text/javascript">
        let year = {{ now()->format('Y') }};
        let month = 'All';
        let karyawan = 'All';
        let status ='';
        let status_1 = 'All';


        $(function() {
            datatable();
        });




        function datatable() {
            var table = $('.yajra-datatable').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: {
                    url: "{{ route('absensi.datatable') }}",
                    type: "POST",
                    data: function(params) {
                        params.year = year;
                        params.month = month;
                        params.karyawan = karyawan;
                        params._token = "{{ csrf_token() }}";
                        params.status = status_1;
                        return params;
                    }
                },
                columns: [
                    //   {data: 'DT_RowIndex', name: 'DT_RowIndex'},                
                    {
                        data: 'nama',
                        name: 'nama'
                    },

                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'clock_in',
                        name: 'clock_in'
                    },
                    {
                        data: 'clock_out',
                        name: 'clock_out'
                    },
                    {
                        data: 'work_time',
                        name: 'work_time'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        render: function(data) {
                            return htmlDecode(data);
                        },
                        className: "nowrap",
                    },


                ],
                columnDefs: [

                    {
                        responsivePriority: 3,
                        targets: 2,

                    },
                    {
                        responsivePriority: 10001,
                        targets: 3
                    },
                    {
                        responsivePriority: 2,
                        targets: -1
                    },


                ],
            });
        }

        function htmlDecode(data) {
            var txt = document.createElement('textarea');
            txt.innerHTML = data;
            return txt.value;
        }

        function show_confirm(data_id) {
            $.ajax({
                type: 'POST',
                url: '{{ route('customer.delete') }}',
                dataType: 'html',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: data_id,
                    "_token": "{{ csrf_token() }}"
                },

                success: function(data) {
                    console.log(data);
                    $('#modal-confirm-delete').html(data);
                    $('#exampleModal').modal('show');
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        function show_detail(data_id) {
            $.ajax({
                type: 'POST',
                url: '{{ route('customer.detail') }}',
                dataType: 'html',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: data_id,
                    "_token": "{{ csrf_token() }}"
                },

                success: function(data) {
                    console.log(data);
                    $('#modal-show-detail').html(data);
                    $('#detailModal').modal('show');
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }


        function deleteData(id) {
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
                        url: '{{ route('absensi.delete') }}',
                        dataType: 'html',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            'id': id,
                            "_token": "{{ csrf_token() }}"
                        },

                        success: function(data) {
                            Swal.fire(
                                "Terhapus!",
                                "Anda Berhasil menghapus Data",
                                "success"
                            )

                            $('.yajra-datatable').DataTable().ajax.reload(null, false);
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    });
                }
            });
        }

        function filterabsensiyear() {
            let e = document.getElementById("kt_select2_1");
            year = e.options[e.selectedIndex].value;
            $('.yajra-datatable').DataTable().ajax.reload(null, false);
        }

        function filterabsensimonth() {
            let e = document.getElementById("kt_select2_11");
            month = e.options[e.selectedIndex].value;
            $('.yajra-datatable').DataTable().ajax.reload(null, false);
        }

        function filterabsensikaryawan() {
            let e = document.getElementById("kt_select2_2");
            karyawan = e.options[e.selectedIndex].value;
            $('.yajra-datatable').DataTable().ajax.reload(null, false);
        }

        function filterabsensistatus() {
            let e = document.getElementById("kt_select2_3");
            status_1 = e.options[e.selectedIndex].value;
            $('.yajra-datatable').DataTable().ajax.reload(null, false);
        }

        function updateStatus(id) {
            console.log('1');

            $.ajax({
                type: 'POST',
                url: '{{ route('absensi.status') }}',
                dataType: 'html',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: id,
                    "_token": "{{ csrf_token() }}"
                },

                success: function(data) {
                    console.log(data);
                    $('#modal-confirm-delete').html(data);
                    $('#status').modal('show');
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }


        function submitItem() {        

            let  status = $('#status').find(":selected").val();
            var id = document.getElementById('id_status').value;                        
            $.ajax({
                type: 'POST',
                url: '{{ route('absensi.inputstatus') }}',
                dataType: 'html',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    "status": status,  
                    "id" : id,  
                    "_token": "{{ csrf_token() }}"
                },               
                success: function(data) {                
                    $('#status').modal('hide');  

                    Swal.fire(
                                "Terhapus!",
                                "Anda Berhasil menghapus Data",
                                "success"
                            )

                    $('.yajra-datatable').DataTable().ajax.reload(null, false);                  
                }
            });
        }
    </script>
@endpush

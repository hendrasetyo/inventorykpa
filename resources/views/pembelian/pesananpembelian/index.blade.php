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
                @if (session('gagal'))
                    <div class="alert alert-custom alert-danger fade show pb-2 pt-2" role="alert">
                        <div class="alert-icon"><i class="flaticon-warning"></i></div>
                        <div class="alert-text">{{ session('gagal') }}</div>
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
                                    <h3 class="card-label">Data Pesanan Pembelian</h3>
                                </div>
                                <div class="card-toolbar">
                                    <!--begin::Button-->

                                    @can('pesananpembelian-create')
                                        <a href="{{ route('pesananpembelian.create') }}"
                                            class="btn btn-primary font-weight-bolder ">
                                            <i class="flaticon2-add"></i>
                                            Pesanan Pembelian
                                        </a>
                                    @endcan

                                    <!--end::Button-->
                                </div>
                            </div>
                            <div class="card-body">
                                <!--begin: Datatable-->
                                <div class="row">

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Tgl Awal :</label>
                                            <input type="text" class="form-control" name="tgl1" readonly value=""
                                                id="tgl1" onchange="filerTanggalMulai()"/>
    
                                        </div>                                             
                                    </div>
                                    <div class="col-md-3">
                                        <div class=" form-group">
                                            <label>Tanggal Akhir :</label>
                                            <input type="text" class="form-control" name="tgl2" readonly value=""
                                                id="tgl2" onchange="filterTanggalSelesai()"/>
                                        </div>
                                    </div>                                       
                                    <div class="col-md-3">
                                        <div class="form-group">    
                                            <label for="">Kategori Pesanan</label>                                                    
                                            <select name="chart_kategori" class="form-control" id="kt_select2_3" onchange="filterKategori()">   
                                                <option value="all" selected>Semua</option>     
                                                
                                                @foreach ($kategoripesanan as $item)
                                                <option value="{{$item->id}}">{{$item->nama}}</option>
                                                @endforeach
                                              
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">    
                                            <label for="">User</label>                                                    
                                            <select name="chart_kategori" class="form-control" id="kt_select2_2" onchange="filterUser()">   
                                                <option value="all" selected>Semua</option>     
                                                
                                                @foreach ($user as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                              
                                            </select>
                                        </div>
                                    </div>
                              </div>


                                <table class="table yajra-datatable collapsed ">
                                    <thead class="datatable-head">
                                        <tr>
                                            <th>Kode</th>
                                            <th>No KPA</th>
                                            <th>Tanggal</th>
                                            <th>Supplier</th>
                                            <th>Pembuat</th>
                                            <th>Status</th>
                                            <th style="width: 15%">Action</th>
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
    <div id="modal-show-detail"></div>
@endsection
@push('script')
    <script src="{{ asset('/assets/js/pages/crud/forms/widgets/select2.js?v=7.0.6') }}"></script>
    <script src="{{ asset('/assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.6') }}"></script>
    <script src="{{ asset('/assets/js/pages/crud/datatables/extensions/responsive.js?v=7.0.6') }}"></script>
    <script src="{{ asset('/assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js?v=7.0.6') }}"></script>

    <script type="text/javascript">
        let tanggalMulai = 'all';
        let tanggalAkhir = 'all';
        let kategoripesanan = 'all';
        let user = 'all';
        
        
        $(function() {
            datatable();
        });

        function datatable() {
            var tablepesananpembelian = $('.yajra-datatable').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: {
                    url: "{{ route('pesananpembelian.datatable') }}",
                    type: "POST",
                    data: function(params) {       
                        params.tanggalAkhir = tanggalAkhir;
                        params.tanggalMulai = tanggalMulai;
                        params.kategoripesanan = kategoripesanan;
                        params.user = user;                 
                        params._token = "{{ csrf_token() }}";                                            
                        return params;
                    }
                },
                columns: [{
                        data: 'kode',
                        name: 'kode'
                    },
                    {
                        data: 'no_so',
                        name: 'no_so'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'supplier',
                        name: 'suppliers.nama'
                    },
                    {
                        data: 'creator',
                        name: 'creator'
                    },
                    {
                        data: 'status',
                        name: 'statusPO.nama'
                    },
                    {
                        data: 'action',
                        render: function(data) {
                            return htmlDecode(data);
                        },
                        className: "nowrap",
                    },
                ],
                columnDefs: [{
                        responsivePriority: 3,
                        targets: 2,

                    },
                    {
                        responsivePriority: 10001,
                        targets: 4
                    },
                    {
                        responsivePriority: 2,
                        targets: -1
                    },
                ]
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
                url: '{{ route('pesananpembelian.delete') }}',
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

        function show_posting(data_id) {
            $.ajax({
                type: 'POST',
                url: '{{ route('pesananpembelian.posting') }}',
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


        function filterKategori() {
            let e = document.getElementById("kt_select2_3");
            kategoripesanan = e.options[e.selectedIndex].value; 

            $('.yajra-datatable').DataTable().ajax.reload(null,false);

        }

        function filterUser() {
            let e = document.getElementById("kt_select2_2");
            user = e.options[e.selectedIndex].value; 

            $('.yajra-datatable').DataTable().ajax.reload(null,false);
            
        }

        function filerTanggalMulai() {
            let e = document.getElementById("tgl1");
            tanggalMulai = e.value;             
            $('.yajra-datatable').DataTable().ajax.reload(null,false);
            
        }

        function filterTanggalSelesai() {
            let e = document.getElementById("tgl2");
            tanggalAkhir = e.value; 

            $('.yajra-datatable').DataTable().ajax.reload(null,false);            
        }


    </script>
@endpush

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
                                                <rect fill="#000000" opacity="0.3" x="12" y="4" width="3" height="13"
                                                    rx="1.5" />
                                                <rect fill="#000000" opacity="0.3" x="7" y="9" width="3" height="8"
                                                    rx="1.5" />
                                                <path
                                                    d="M5,19 L20,19 C20.5522847,19 21,19.4477153 21,20 C21,20.5522847 20.5522847,21 20,21 L4,21 C3.44771525,21 3,20.5522847 3,20 L3,4 C3,3.44771525 3.44771525,3 4,3 C4.55228475,3 5,3.44771525 5,4 L5,19 Z"
                                                    fill="#000000" fill-rule="nonzero" />
                                                <rect fill="#000000" opacity="0.3" x="17" y="11" width="3" height="6"
                                                    rx="1.5" />
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon--></span> </span>
                                <h3 class="card-label">Pilih Piutang Yang Dibayarkan</h3>
                            </div>
                            <div class="card-toolbar">
                                <!--begin::Button-->


                                <!--end::Button-->
                            </div>
                        </div>
                        <div class="card-body">
                            <!--begin: Datatable-->
                            <table class="table yajra-datatable collapsed ">
                                <thead class="datatable-head">
                                    <tr>
                                        <th>Faktur No.</th>
                                        <th>No KPA</th>
                                        <th>Tanggal</th>
                                        <th>Customer</th>
                                        <th>Total</th>
                                        <th>Terbayar</th>
                                        <th>Sisa</th>
                                        <th>Tanggal TOP</th>
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


<script type="text/javascript">
    $(function () {
   
          var table = $('.yajra-datatable').DataTable({
              responsive: true,
              processing: true,
              serverSide: true,
              autoWidth: false,
              ajax: {
                type : 'POST',
                url :"{{ route('piutang.datatable') }}",
                data: function(params) {
                        params._token = "{{ csrf_token() }}";                
                        return params;
                       }
              },
              columns: [
                //   {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                  {data: 'kode', name: 'fakturpenjualan.kode',},
                  {data: 'no_kpa', name: 'fakturpenjualan.no_kpa'},
                  {data: 'tanggal', name: 'tanggal'},
                  {data: 'customers', name: 'customers.nama',searchable:true},
                  {data: 'total', name: 'total'},
                  {data: 'dibayar', name: 'dibayar'},
                  {data: 'sisa', name: 'sisa'},
                  {data: 'tanggal_top', name: 'tanggal_top'},
                  {
                      data: 'action', 
                      render: function(data){
                          return htmlDecode(data);
                      },
                      className:"nowrap",
                  },
              ],
              columnDefs: [
                
                {
                    responsivePriority: 3,
                    targets: 2,
                    
                },
                {responsivePriority: 10001, targets: 4},
                {
                    responsivePriority: 2,
                    targets: -1
                },
               
                
            ],
        });
          
    });
   

    function htmlDecode(data){
        var txt = document.createElement('textarea');
        txt.innerHTML=data;
        return txt.value;
    }

    

    
</script>
@endpush
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
                        <div class="card-header py-3 d-flex justify-content-between ">
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
                                <h3 class="card-label">Data Stok Produk</h3>
                            
                            </div>

                            <div>
                                <a href="{{ route('laporanstok.singkronisasi') }}" class="btn btn-danger mr-2" >
                                    <i class="flaticon-technology"></i>                                  
                                    Download Sinkronisasi</a>
                            </div>

                            <div>
                                <a href="#" class="btn btn-primary mr-2" data-toggle="modal" data-target="#modalexport">
                                    <i class="flaticon-technology"></i>                                  
                                    Export to Excel</a>
                            </div>
                                                       
                        </div>
                        <div class="card-body">
                            <!--begin: Datatable-->
                            <table class="table yajra-datatable collapsed ">
                                <thead class="datatable-head">
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama Barang</th>
                                        <th>Stok</th>
                                        <th>Kategori</th>
                                        <th>Sub Kategori</th>

                                        <th>Action</th>
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


 <!-- Modal -->
<div class="modal fade" id="modalexport" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Export Product</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('laporanstok.export') }}" method="post">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Kategori : </label> <br>
                    <select name="kategori_id" class="form-control" id="kt_select2_1" >
                        <option value="all" selected>Semua</option>
                        @foreach ($kategory as $item)
                            <option value="{{$item->id}}">{{$item->nama}}</option>
                        @endforeach
                    </select>
                </div>                
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
       </form>
      </div>
    </div>
</div>

@endsection
@push('script')
<script src="{{ asset('/assets/js/pages/crud/forms/widgets/select2.js?v=7.0.6') }}"></script>
<script src="{{ asset('/assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.6') }}"></script>
<script src="{{ asset('/assets/js/pages/crud/datatables/extensions/responsive.js?v=7.0.6') }}"></script>




<script type="text/javascript">
    $(function () {
        $('#provinsi').on('change', function () {
        // Kode untuk ajax request disini 

        });
   
          var table = $('.yajra-datatable').DataTable({
              responsive: true,
              processing: true,
              serverSide: true,
              autoWidth: false,
              ajax: "{{ route('laporanstok.stokproduk') }}",
              columns: [
                //   {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'kode', name: 'kode'},
                  {data: 'nama', name: 'nama'},
                  {data: 'stok', name: 'stok'},

                  {data: 'kategori', name: 'categories.nama'},
                  {data: 'subkategori', name: 'subcategories.nama'},
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

    
    function show_detail(data_id){
        $.ajax({
                type: 'POST',
                url: '{{ route('customer.detail') }}',
                dataType: 'html',
                headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
                data: {id:data_id, "_token": "{{ csrf_token() }}"},
                
                success: function (data){
                    console.log(data);
                    $('#modal-show-detail').html(data);
                    $('#detailModal').modal('show');
                },
                error: function(data){
                    console.log(data);
                }
        });
    }
</script>
@endpush
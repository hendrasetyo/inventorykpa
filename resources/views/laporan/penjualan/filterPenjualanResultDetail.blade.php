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
                        <div class="card-header py-3 d-flex justify-content-between">
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
                                    <h3 class="card-label">Laporan Penjualan Detail</h3>
                                

                            </div>                           
                            
                            <div>
                                <form action="{{ route('laporanpenjualan.exportpenjualandetail') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="tgl1" value="{{$form['tgl1']}}"> 
                                    <input type="hidden" name="tgl2" value="{{$form['tgl2']}}"> 
                                    <input type="hidden" name="customer" value="{{$form['customer']}}"> 
                                    <input type="hidden" name="sales" value="{{$form['sales']}}"> 
                                    <input type="hidden" name="produk" value="{{$form['produk']}}"> 
                                    <input type="hidden" name="merk" value="{{$form['merk']}}"> 

                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <span class="svg-icon svg-icon-default svg-icon-1x"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo2\dist/../src/media/svg/icons\Files\Import.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 7.000000) rotate(-180.000000) translate(-12.000000, -7.000000) " x="11" y="1" width="2" height="12" rx="1"/>
                                                <path d="M17,8 C16.4477153,8 16,7.55228475 16,7 C16,6.44771525 16.4477153,6 17,6 L18,6 C20.209139,6 22,7.790861 22,10 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,9.99305689 C2,7.7839179 3.790861,5.99305689 6,5.99305689 L7.00000482,5.99305689 C7.55228957,5.99305689 8.00000482,6.44077214 8.00000482,6.99305689 C8.00000482,7.54534164 7.55228957,7.99305689 7.00000482,7.99305689 L6,7.99305689 C4.8954305,7.99305689 4,8.88848739 4,9.99305689 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,10 C20,8.8954305 19.1045695,8 18,8 L17,8 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                <path d="M14.2928932,10.2928932 C14.6834175,9.90236893 15.3165825,9.90236893 15.7071068,10.2928932 C16.0976311,10.6834175 16.0976311,11.3165825 15.7071068,11.7071068 L12.7071068,14.7071068 C12.3165825,15.0976311 11.6834175,15.0976311 11.2928932,14.7071068 L8.29289322,11.7071068 C7.90236893,11.3165825 7.90236893,10.6834175 8.29289322,10.2928932 C8.68341751,9.90236893 9.31658249,9.90236893 9.70710678,10.2928932 L12,12.5857864 L14.2928932,10.2928932 Z" fill="#000000" fill-rule="nonzero"/>
                                            </g>
                                        </svg><!--end::Svg Icon--></span>    
                                    Export to Excel</button>
                                
                                </form>
                                
                        </div>
                        <div class="card-body">
                            <!--begin: Datatable-->
                            <table class="table table-separate table-head-custom table-checkable" id="kt_datatable1">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>Kode Faktur</th>
                                        <th>Kode SO</th>
                                        <th>Kode SJ</th>
                                        <th>No Pajak</th>
                                        <th>No KPA</th>
                                        <th>Customer</th>                                        
                                        <th>Diskon Rupiah</th>
                                        <th>Diskon Persen</th>
                                        <th>Subtotal</th>
                                        <th>Total Diskon Detail</th>
                                        <th>Total Diskon Header</th>
                                        <th>Total</th>
                                        <th>PPN</th>
                                        <th>Ongkir</th>                                         
                                        <th>Grand Total</th>                                        
                                        <th>Nama Produk</th>    
                                        <th>Kode Produk</th>
                                        <th>Merk</th>
                                        <th>Qty</th>
                                        <th>Satuan</th>
                                        <th>Harga Jual Produk</th>
                                        <th>Diskon Persen Produk</th>
                                        <th>Diskon Rupiah Produk</th>
                                        <th>Subtotal Produk</th>
                                        <th>Total Diskon Produk</th>
                                        <th>Total Produk</th>
                                        <th>Ongkir Produk</th>
                                        <th>Sales</th>
                                        <th>Pembuat</th>                                        
                                        <th>Keterangan</th>                                          
                                        <th>Keterangan Produk</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no=1;
                                    @endphp
                                    @foreach ($penjualan as $item)
                                        <tr>
                                            <td>{{$no++}}</td>
                                            <td>{{ date('d/m/Y', strtotime($item->tanggal)) }}</td>
                                            <td>{{$item->kode}}</td>
                                            <td>{{$item->kode_SP}}</td>
                                            <td>{{$item->kode_SJ}}</td>
                                            <td>{{$item->no_seri_pajak ? $item->no_seri_pajak : '' .'-'. $item->no_pajak}}</td>
                                            <td>{{$item->no_kpa}}</td>
                                            <td>{{$item->nama_customer}}</td>
                                            <td>{{$item->diskon_rupiah}}</td>
                                            <td>{{$item->diskon_persen}}</td>
                                            <td>{{$item->subtotal}}</td>
                                            <td>{{$item->total_diskon_detail}}</td>
                                            <td>{{$item->total_diskon_header}}</td>
                                            <td>{{$item->total}}</td>       
                                            <td>{{$item->ppn}}</td>
                                            <td>{{$item->ongkir}}</td>                                     
                                            <td>{{$item->grandtotal}}</td>                                              
                                            <td>{{$item->nama_produk}}</td>
                                            <td>{{$item->kode_produk}}</td>
                                            <td>{{$item->nama_merk}}</td>
                                            <td>{{$item->qty_det}}</td>
                                            <td>{{$item->satuan_det}}</td>
                                            <td>{{$item->hargajual_det}}</td>
                                            <td>{{$item->dikson_persen_det}}</td>
                                            <td>{{$item->diskon_rp_det}}</td>
                                            <td>{{$item->subtotal_det}}</td>
                                            <td>{{$item->total_diskon_det}}</td>
                                            <td>{{$item->total_det}}</td>
                                            <td>{{$item->ongkir_det}}</td>
                                            <td>{{$item->nama_sales}}</td>
                                            <td>{{$item->nama_pembuat}}</td>
                                            <td>{{$item->keterangan}}</td>                                            
                                            <td>{{$item->keterangan_det}}</td>
                                        </tr>
                                    @endforeach
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
<script src="{{ asset('/assets/js/pages/crud/forms/widgets/select2.js?v=7.0.6"') }}"></script>
<script src="{{ asset('/assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.6') }}"></script>
<script src="{{ asset('/assets/js/pages/crud/datatables/extensions/responsive.js?v=7.0.6') }}"></script>

@endpush

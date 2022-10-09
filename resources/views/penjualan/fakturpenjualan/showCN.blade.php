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
                                <h1 class="display-4 font-weight-boldest mb-10">FAKTUR PENJUALAN</h1>
                                <div class="d-flex flex-column align-items-md-end px-0">
                                    <!--begin::Logo-->
                                    <a href="#" class="mb-5">
                                        <img src="assets/media/logos/logo-dark.png" alt="" />
                                    </a>
                                    <!--end::Logo-->
                                    <span class=" d-flex flex-column align-items-md-end opacity-70">
                                        <span>{{ $fakturpenjualan->tanggal->format("d F Y") }}</span>
                                        <span>{{ $fakturpenjualan->creator->name }}</span>
                                        <span class="font-weight-bold font-italic text-primary font-size-h3">{{
                                            $fakturpenjualan->kode }}</span>
                                    </span>
                                </div>
                            </div>
                            <div class="border-bottom w-100"></div>
                            <div class="d-flex justify-content-between pt-6">
                                <div class="d-flex flex-column flex-root">
                                    <span class="font-weight-bolder mb-2">CUSTOMER</span>
                                    <span class="opacity-70">{{ $fakturpenjualan->customers->nama }}</span>
                                </div>

                                <div class="d-flex flex-column flex-root">
                                    <span class="font-weight-bolder mb-2">PENGIRIMAN BARANG</span>
                                    <span class="opacity-70">{{ $fakturpenjualan->SJ->kode }}</span>
                                </div>
                                <div class="d-flex flex-column flex-root">
                                    <span class="font-weight-bolder mb-2">SURAT PESANAN</span>
                                    <span class="opacity-70">{{ $fakturpenjualan->SO->kode }}</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between pt-6">
                                <div class="d-flex flex-column flex-root">
                                    <span class="font-weight-bolder mb-2">No. Invoice KPA</span>
                                    <span class="opacity-70">{{ $fakturpenjualan->no_kpa }}</span>
                                </div>                                                           
                                <div class="d-flex flex-column flex-root">
                                    <span class="font-weight-bolder mb-2">No. Faktur Pajak</span>
                                    <span class="opacity-70">{{ $fakturpenjualan->nopajak && $fakturpenjualan->no_seri_pajak ? $fakturpenjualan->no_seri_pajak.'-'. $fakturpenjualan->nopajak->no_pajak : '-'}}</span>
                                </div>
                                <div class="d-flex flex-column flex-root">
                                    <span class="font-weight-bolder mb-2">SO Customer</span>
                                    <span class="opacity-70">{{ $fakturpenjualan->SO->no_so }}</span>
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
                                            <th class="pl-0 font-weight-bold text-muted  text-uppercase">Kode
                                            </th>
                                            <th class="text-left font-weight-bold text-muted text-uppercase">Produk
                                            </th>
                                            <th class="text-left font-weight-bold text-muted text-uppercase">Satuan
                                            </th>
                                            <th class="text-left font-weight-bold text-muted text-uppercase">Qty</th>
                                            <th class="text-left font-weight-bold text-muted text-uppercase">Harga</th>
                                            {{-- <th class="text-left font-weight-bold text-muted text-uppercase">Disk.(%)
                                            </th>
                                            <th class="text-left font-weight-bold text-muted text-uppercase">
                                                Disk.(Rp.)</th> --}}
                                            <th class="text-left font-weight-bold text-muted text-uppercase">Subtotal
                                            </th>
                                            {{-- <th class="text-left font-weight-bold text-muted text-uppercase">Total
                                                Disc.</th> --}}
                                            <th class="text-left font-weight-bold text-muted text-uppercase">Total</th>                                            
                                            <th class="text-left font-weight-bold text-muted text-uppercase">CN</th>                                            
                                            <th class="text-left font-weight-bold text-muted text-uppercase">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @foreach($fakturpenjualandetails as $a)
                                        
                                        <tr class="font-weight-boldest">                                            
                                            <td class="pl-0 pt-7">{{ $a->products->kode }}</td>
                                            <td class="text-left pt-7">{{ $a->products->nama }}</td>
                                            <td class="text-left pt-7">{{ $a->satuan }}</td>
                                            <td class=" pt-7 text-left">{{ $a->qty }}</td>
                                            <td class=" pt-7 text-left">{{ number_format($a->hargajual, 2, ',', '.') }}
                                            </td>
                                            {{-- <td class=" pt-7 text-left">{{ $a->diskon_persen }}</td>
                                            <td class=" pt-7 text-left">{{ $a->diskon_rp }}</td> --}}
                                            <td class=" pt-7 text-left">{{ number_format($a->subtotal, 2, ',', '.') }}
                                            </td>
                                            {{-- <td class=" pt-7 text-left">
                                                {{ number_format($a->total_diskon, 0, ',', '.') }}</td> --}}
                                            <td class="text-danger pr-0 pt-7 text-right">
                                                {{ number_format($a->total, 2, ',', '.') }}</td>

                                                <td class=" pr-0 pt-7 text-right">
                                                    {{$a->cn_persen ? $a->cn_persen : 0 }}%</td>
                                            <td  class=" pt-7 text-left">
                                                @if ($a->cn_persen)
                                                <a type="button" data-toggle="modal" data-target="#edit{{$a->id}}">
                                                    <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo2\dist/../src/media/svg/icons\Design\Edit.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24"/>
                                                            <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "/>
                                                            <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"/>
                                                        </g>
                                                    </svg><!--end::Svg Icon--></span>
                                                    
                                                </a>                                                                                  
                                                @else                                                    
                                                <a type="button" data-toggle="modal" data-target="#tambah{{$a->id}}">
                                                    <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo2\dist/../src/media/svg/icons\Design\Edit.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24"/>
                                                            <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "/>
                                                            <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"/>
                                                        </g>
                                                    </svg><!--end::Svg Icon--></span>
                                                    
                                                </a>
                                                @endif
                                                
                                            </td>
                                                  
                                            
                                            

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- end: Invoice body-->

                    <!-- begin: Invoice footer-->
                    <div class="row justify-content-center bg-gray-100 py-8 px-8 py-md-10 px-md-0">
                        <div class="col-md-9">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="font-weight-bold text-muted  text-uppercase">SUBTOTAL</th>
                                            <th class="font-weight-bold text-muted  text-uppercase">DISKON TAMBAHAN</th>
                                            <th class="font-weight-bold text-muted  text-uppercase">TOTAL</th>
                                            <th class="font-weight-bold text-muted  text-uppercase">PPN</th>
                                            <th class="font-weight-bold text-muted  text-uppercase">ONGKIR</th>
                                            <th class="font-weight-bold text-muted  text-uppercase">BIAYA LAIN-LAIN</th>
                                            <th class="font-weight-bold text-muted  text-uppercase">GRANDTOTAL</th>
                                        </tr>

                                        
                                    </thead>
                                    <tbody>
                                        <tr class="font-weight-bolder">
                                            <td>{{ number_format($fakturpenjualan->subtotal, 0, ',', '.') }}</td>
                                            <td>{{ number_format($fakturpenjualan->total_diskon_header, 0, ',', '.') }}
                                            </td>
                                            <td>{{ number_format($fakturpenjualan->total, 0, ',', '.') }}</td>
                                            <td>{{ number_format($fakturpenjualan->ppn, 0, ',', '.') }}</td>
                                            <td>{{ number_format($fakturpenjualan->ongkir, 0, ',', '.') }}</td>
                                            <td>{{ number_format($fakturpenjualan->biaya_lain, 0, ',', '.') }}</td>
                                            <td class="text-danger font-size-h5 font-weight-boldest">
                                                {{ number_format($fakturpenjualan->grandtotal, 0, ',', '.') }}</td>
                                        </tr>                                        
                                    </tbody>

                                </table>
                                {{-- @dd($fakturpenjualandetails) --}}

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="font-weight-bold text-muted  text-uppercase">JUMLAH CN</th>                                          
                                            <th class="font-weight-bold text-muted  text-uppercase">Saldo Harga Bersih</th>                                              
                                        </tr>                                        
                                        <tr>
                                            <td>{{ $fakturpenjualan->total_cn ? number_format($fakturpenjualan->total_cn, 0, ',', '.') : '0'}}</td>
                                           
                                            <td>
                                                {{ number_format($fakturpenjualan->grandtotal - $fakturpenjualan->total_cn, 0, ',', '.') }}                                           
                                            </td>                                        
                                        </tr>                                        
                                    </thead>
                                    {{-- <tbody>
                                        <tr class="font-weight-bolder">
                                            
                                            {{ number_format($fakturpenjualan->grandtotal - $fakturpenjualan->total_cn, 0, ',', '.') }}</td>                                      
                                        </tr>                                        
                                       
                                    </tbody> --}}
                                </table>
                                <br />
                                <h4>Keterangan :</h4>
                                <p>{{ $fakturpenjualan->keterangan }} </p>
                            </div>
                        </div>
                    </div>


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
                                                <td>{{ $fakturpenjualan->created_at }}</td>

                                                <td>{{ $fakturpenjualan->creator->name }}</td>
                                                <td>{{ $fakturpenjualan->updated_at }}</td>
                                                <td>{{ $fakturpenjualan->updater->name }}</td>

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
                                {{-- <div class="d-flex justify-content-between">
                                    <a href="{{ route('fakturpenjualan.print_a4', $fakturpenjualan) }}"
                                        class="btn btn-primary " target="_blank">
                                        <i class="flaticon2-print font-weight-bold"></i> Download & Print
                                    </a>                                   

                                </div> --}}
                            
                                <a class="btn btn-danger font-weight-bold"
                                    href="{{ url('penjualan/fakturpenjualan') }}">Back
                                </a>
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
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <path
                                                d="M11.1669899,4.49941818 L2.82535718,19.5143571 C2.557144,19.9971408 2.7310878,20.6059441 3.21387153,20.8741573 C3.36242953,20.9566895 3.52957021,21 3.69951446,21 L21.2169432,21 C21.7692279,21 22.2169432,20.5522847 22.2169432,20 C22.2169432,19.8159952 22.1661743,19.6355579 22.070225,19.47855 L12.894429,4.4636111 C12.6064401,3.99235656 11.9909517,3.84379039 11.5196972,4.13177928 C11.3723594,4.22181902 11.2508468,4.34847583 11.1669899,4.49941818 Z"
                                                fill="#000000" opacity="0.3" />
                                            <rect fill="#000000" x="11" y="9" width="2" height="7" rx="1" />
                                            <rect fill="#000000" x="11" y="17" width="2" height="2" rx="1" />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
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


{{-- modal edit CN --}}
<!-- Modal -->
@foreach($fakturpenjualandetails as $a)
<div class="modal fade" id="tambah{{$a->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="{{ route('fakturpenjualan.editCN', ['fakturpenjualandetail'=> $a->id]) }}" method="POST">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Masukan Data CN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="form-group">
                    <label for="">Persen CN</label>
                    <input type="number" name="cn_persen" class="form-control" placeholder="Masukan CN persen disini !">
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
            </div>
        </form>
        
    </div>
  </div>

  <div class="modal fade" id="edit{{$a->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="{{ route('fakturpenjualan.updateCN', ['fakturpenjualandetail'=> $a->id]) }}" method="POST" >
            @method('PUT')
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Masukan Data CN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="form-group">
                    <label for="">Persen CN</label>
                    <input type="number" name="cn_persen"  class="form-control" value="{{$a->cn_persen}}">
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
            </div>
        </form>
        
    </div>
  </div>
@endforeach
  


@endsection
@push('script')
<script src="{{ asset('/assets/js/pages/crud/forms/widgets/select2.js?v=7.0.6"') }}"></script>
<script src="{{ asset(' /assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.6') }}"></script>
<script src="{{ asset('/assets/js/pages/crud/datatables/extensions/responsive.js?v=7.0.6') }}"></script>
<script src="{{ asset('/assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js?v=7.0.6') }}"></script>


<script type="text/javascript">


</script>
@endpush
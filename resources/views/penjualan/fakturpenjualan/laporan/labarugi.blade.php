@extends('layouts.app', ['title' => $title])

@section('content')
<!--begin::Content-->
<div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->

    <!--end::Subheader-->

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid mt-10">
        <!--begin::Container-->
        <div class="container">
            <!-- begin::Card-->
            <div class="card card-custom overflow-hidden">
                <div class="card-body p-0">
                    <!-- begin: Invoice-->
                    <!-- begin: Invoice header-->
                    <div class="row justify-content-center py-8 px-8 py-md-27 px-md-0">
                        <div class="col-md-9">
                            <div class="d-flex justify-content-between pb-10 pb-md-20 flex-column flex-md-row">
                                <h1 class="display-4 font-weight-boldest mb-10">LABA  / RUGI</h1>
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
                        <div class="col-md-11">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            {{-- <th class="pl-0 font-weight-bold text-muted  text-uppercase">Kode
                                            </th> --}}
                                            <th class="text-left font-weight-bold text-muted text-uppercase">Produk
                                            </th>
                                            <th class="text-left font-weight-bold text-muted text-uppercase">Satuan
                                            </th>
                                            <th class="text-left font-weight-bold text-muted text-uppercase">Qty</th>
                                            <th class="text-left font-weight-bold text-muted text-uppercase">Harga</th>
                                            <th class="text-left font-weight-bold text-muted text-uppercase">Subtotal
                                            </th>                                             
                                            <th class="text-left font-weight-bold text-muted text-uppercase">
                                                Disk.</th> 
                                            <th class="text-left font-weight-bold text-muted text-uppercase">
                                                    PPN.</th>     
                                            <th class="text-left font-weight-bold text-muted text-uppercase">
                                                Total.</th>                                           
                                            <th class="text-left font-weight-bold text-muted text-uppercase">CN</th>                                            
                                            <th class="text-left font-weight-bold text-muted text-uppercase">Harga Bersih</th>        
                                            <th class="text-left font-weight-bold text-muted text-uppercase">Harga Beli</th>      
                                            <th class="text-left font-weight-bold text-muted text-uppercase">PPN (11 %)</th>
                                            <th class="text-left font-weight-bold text-muted text-uppercase">HPP</th>
                                            <th class="text-left font-weight-bold text-muted text-uppercase">Laba Kotor</th>                                                                                                                                                                                                                    
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @foreach($labarugi as $a)
                                        
                                        <tr class="font-weight-boldest">                                            
                                            {{-- <td class="pl-0 pt-7">{{ $a['kode'] }}</td> --}}
                                            <td class="text-left pt-7">{{ $a['nama'] }}</td>
                                            <td class="text-left pt-7">{{ $a['satuan'] }}</td>
                                            <td class=" pt-7 text-left">{{ $a['qty'] }}</td>
                                            <td class=" pt-7 text-left">{{ number_format($a['hargajual'], 2, ',', '.') }}
                                            </td>
                                           
                                            <td class=" pt-7 text-left">{{ number_format($a['subtotal'], 2, ',', '.') }}
                                            </td>
                                            <td class=" pt-7 text-left">{{ number_format($a['diskon_rp'], 2, ',', '.') }}
                                            </td>
                                            <td class=" pt-7 text-left">{{ number_format($a['ppnJual'], 2, ',', '.') }}
                                            </td>
                                           
                                           
                                            <td class="pr-0 pt-7 text-right">
                                                {{ number_format($a['total'], 2, ',', '.') }}</td>
                                            <td class="pr-0 pt-7 text-right">
                                                {{ number_format($a['cn_rupiah'], 2, ',', '.') }}</td>
                                            <td class="pr-0 pt-7 text-right">
                                                    {{ number_format($a['harga_bersih'], 2, ',', '.') }}</td>
                                            <td class="pr-0 pt-7 text-right">
                                                {{ number_format($a['harga_beli'], 2, ',', '.') }}</td>
                                            <td class="pr-0 pt-7 text-right">
                                                {{ number_format($a['ppnBeli'], 2, ',', '.') }}</td>
                                            <td class="pr-0 pt-7 text-right">
                                                {{ number_format($a['hpp'], 2, ',', '.') }}</td>
                                            <td class="text-danger pr-0 pt-7 text-right">
                                                {{ number_format($a['labaKotor'], 2, ',', '.') }}</td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                           
                        </div>
                      

                        <div class="col-md-9">
                            <hr>
                            <h3>Laporan Biaya Lain-Lain</h3><hr><br>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="pl-0 font-weight-bold text-muted  text-uppercase">Jenis Biaya
                                            </th>
                                            <th class="text-left font-weight-bold text-muted text-uppercase">Nominal
                                            </th>
                                            <th class="text-left font-weight-bold text-muted text-uppercase">Keterangan
                                            </th>                                                                                                                                                                                                                                                
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @foreach($biayalain as $a)
                                        
                                        <tr class="font-weight-boldest">                                            
                                            <td class="pl-0 pt-7">{{ $a->jenisbiaya->nama }}</td>
                                            <td class="text-left pt-7">{{ number_format($a->nominal, 2, ',', '.') }}</td>
                                            <td class="text-left pt-7">{{ $a->keterangan }}</td>
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
                                            <th class="font-weight-bold text-muted  text-uppercase">Biaya Lain-Lain</th>  
                                                                                    
                                          
                                               
                                           
                                        </tr>                                        
                                        <tr>
                                            <td>{{ $fakturpenjualan->total_cn ? number_format($fakturpenjualan->total_cn, 0, ',', '.') : '0'}}</td>
                                           
                                            <td>
                                                {{ number_format($fakturpenjualan->grandtotal - $fakturpenjualan->total_cn, 0, ',', '.') }}                                           
                                            </td> 
                                            <td>
                                                {{ number_format($totalbiayaLain, 0, ',', '.') }} 
                                            </td>     
                                           <td></td>
                                           <td></td>
                                           

                                                                          
                                           
                                           
                                        </tr>                                        
                                    </thead>                                   
                                </table>

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="font-weight-bold text-muted  text-uppercase">Total Harga Beli</th>                                          
                                            <th class="font-weight-bold text-muted  text-uppercase">Total Ppn</th>  
                                            <th class="font-weight-bold text-muted  text-uppercase">Total HPP</th> 
                                            <th class="font-weight-bold text-muted  text-uppercase">Total Laba Kotor</th> 
                                            <th></th>   
                                            <th></th>                                          
                                            <th></th> 
                                            <th></th>   
                                            
                                                                                        
                                        </tr>                                        
                                        <tr>
                                            <td>{{  number_format($totalHargaBeli, 0, ',', '.') }}</td>
                                           
                                            <td>
                                                {{ number_format($totalPpnBeli, 0, ',', '.') }}                                           
                                            </td> 
                                            <td>
                                                {{ number_format($totalHpp, 0, ',', '.') }} 
                                            </td>  
                                            <td class="text-danger font-size-h5 font-weight-boldest">
                                                {{ number_format($totalLaba, 0, ',', '.') }} 
                                            </td>       
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                              
                                                                            
                                        </tr>                                        
                                    </thead>                                   
                                </table>

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="ftext-danger font-size-h5 font-weight-boldest">Total Laba </th>                                                                                     
                                            <th></th>   
                                            <th></th>                                          
                                            <th></th> 
                                            <th></th>   
                                            
                                                                                        
                                        </tr>                                        
                                        <tr>
                                            <td class="text-danger font-size-h5 font-weight-boldest">{{  number_format($grandTotalLaba, 0, ',', '.') }}</td>
                                           
                                           
                                           <td></td>
                                           <td></td>
                                           <td></td>
                                           <td></td>

                                                                            
                                        </tr>                                        
                                    </thead>                                   
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



  


@endsection
@push('script')
<script src="{{ asset('/assets/js/pages/crud/forms/widgets/select2.js?v=7.0.6"') }}"></script>
<script src="{{ asset(' /assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.6') }}"></script>
<script src="{{ asset('/assets/js/pages/crud/datatables/extensions/responsive.js?v=7.0.6') }}"></script>
<script src="{{ asset('/assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js?v=7.0.6') }}"></script>


<script type="text/javascript">


</script>
@endpush
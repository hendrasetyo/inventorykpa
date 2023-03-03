@extends('layouts.app')

@section('content')
<div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-12  subheader-transparent " id="kt_subheader">
        <div class=" container  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">

                <!--begin::Heading-->
                <div class="d-flex flex-column">
                    <!--begin::Title-->
                    <h2 class="text-white font-weight-bold my-2 mr-5">
                        Dashboard </h2>
                    <!--end::Title-->

                    <!--begin::Breadcrumb-->
                    <div class="d-flex align-items-center font-weight-bold my-2">
                        <!--begin::Item-->
                        <a href="#" class="opacity-75 hover-opacity-100">
                            <i class="flaticon2-shelter text-white icon-1x"></i>
                        </a>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <span class="label label-dot label-sm bg-white opacity-75 mx-3"></span>
                        <a href="" class="text-white text-hover-white opacity-75 hover-opacity-100">
                            Dashboard </a>
                        <!--end::Item-->
                        <!--begin::Item-->
                       
                        
                        <!--end::Item-->
                    </div>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Heading-->

            </div>
            <!--end::Info-->

            <!--begin::Toolbar-->

            <!--end::Toolbar-->
        </div>
    </div>
    <!--end::Subheader-->

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class=" container ">
            <!--begin::Dashboard-->
            <div class="row">
                <div class="col-lg-12">
                    <!--begin::Card-->
                    <div class="card card-custom gutter-b">
                        <!--begin::Header-->
                        <div class="card-header h-auto d-flex justify-content-between">
                            <!--begin::Title-->
                            <div class="card-title py-5">                               
                                <h3 class="card-label">
                                    Grafik Penjualan
                                </h3>
                            </div>

                            
                            <!--end::Title-->
                        </div>
                        <!--end::Header-->
                        <div class="card-body">
                          <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">    
                                    <label for="">Tipe Grafik</label>                                                    
                                    <select name="chart_year" class="form-control" id="kt_select2_4" onchange="filterType()">                               
                                        <option value="tahun" selected>Tahunan</option>
                                        <option value="bulan">Bulanan</option>                                        
                                    </select>
                                </div>
                            </div>
                                <div class="col-md-4">
                                    <div class="form-group">    
                                        <label for="">Tahun</label>                                                    
                                        <select name="chart_year" class="form-control" id="kt_select2_1" onchange="filterYear()">                               
                                            @php
                                            $year = 2020;
                                            @endphp
                                            @foreach (range(date('Y'), $year) as $x)
                                                <option value="{{$x}}">{{$x}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">    
                                        <label for="">Kategori Pesanan</label>                                                    
                                        <select name="chart_kategori" class="form-control" id="kt_select2_2" onchange="filterKategori()">   
                                            <option value="All" selected>Semua</option>                                                                    
                                            @foreach ($kategori as $x)
                                                <option value="{{$x->id}}">{{$x->nama}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                          </div>

                          <div class="row d-none">
                            <div class="col-md-4">
                                <div class="form-group">    
                                    <label for="">Bulan</label>                                                    
                                    <select name="chart_year" class="form-control" id="kt_select2_4" onchange="filterType()">  
                                            <option value="All" selected>Semua</option>                             
                                       @foreach ($bulan as $item)
                                            <option value="{{$item['id']}}">{{$item['bulan']}}</option>                                    
                                       @endforeach
                                    </select>                                
                                </div>
                           </div>
                          </div>
                          
                            <!--begin::Chart-->
                            <div id="penjualanchart"></div>
                            <!--end::Chart-->
                        </div>
                    </div>
                    <!--end::Card-->
                </div>
            </div>

            <!--begin::Row-->
            <div class="row">
                <div class="col-xl-4">
                    <!--begin::Tiles Widget 1-->
                    <div class="card card-custom gutter-b card-stretch">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-5">
                            <div class="card-title">
                                <div class="card-label">
                                    <div class="font-weight-bolder">Weekly Sales Stats</div>
                                    <div class="font-size-sm text-muted mt-2">xxx,xxx Sales</div>
                                </div>
                            </div>

                        </div>
                        <!--end::Header-->

                        <!--begin::Body-->
                        <div class="card-body d-flex flex-column px-0">
                            <!--begin::Chart-->
                            <div id="kt_tiles_widget_1_chart" data-color="danger" style="height: 125px">
                            </div>
                            <!--end::Chart-->

                            <!--begin::Items-->
                            <div class="flex-grow-1 card-spacer-x">
                                <!--begin::Item-->
                                <div class="d-flex align-items-center justify-content-between mb-10">
                                    <div class="d-flex align-items-center mr-2">
                                        <div class="symbol symbol-50 symbol-light mr-3 flex-shrink-0">
                                            <div class="symbol-label">
                                                <img src="assets/media/svg/misc/006-plurk.svg" alt="" class="h-50" />
                                            </div>
                                        </div>
                                        <div>
                                            <a href="#"
                                                class="font-size-h6 text-dark-75 text-hover-primary font-weight-bolder">Top
                                                Authors</a>
                                            <div class="font-size-sm text-muted font-weight-bold mt-1">
                                                Coming Soon</div>
                                        </div>
                                    </div>
                                    <div
                                        class="label label-light label-inline font-weight-bold text-dark-50 py-4 px-3 font-size-base">
                                        +00$</div>
                                </div>
                                <!--end::Item-->

                                <!--begin::Item-->
                                <div class="d-flex align-items-center justify-content-between mb-10">
                                    <div class="d-flex align-items-center mr-2">
                                        <div class="symbol symbol-50 symbol-light mr-3 flex-shrink-0">
                                            <div class="symbol-label">
                                                <img src="assets/media/svg/misc/015-telegram.svg" alt="" class="h-50" />
                                            </div>
                                        </div>
                                        <div>
                                            <a href="#"
                                                class="font-size-h6 text-dark-75 text-hover-primary font-weight-bolder">Bestsellers</a>
                                            <div class="font-size-sm text-muted font-weight-bold mt-1">
                                                Pitstop Email Marketing</div>
                                        </div>
                                    </div>
                                    <div
                                        class="label label-light label-inline font-weight-bold text-dark-50 py-4 px-3 font-size-base">
                                        000$</div>
                                </div>
                                <!--end::Item-->

                                <!--begin::Item-->
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center mr-2">
                                        <div class="symbol symbol-50 symbol-light mr-3 flex-shrink-0">
                                            <div class="symbol-label">
                                                <img src="assets/media/svg/misc/003-puzzle.svg" alt="" class="h-50" />
                                            </div>
                                        </div>
                                        <div>
                                            <a href="#"
                                                class="font-size-h6 text-dark-75 text-hover-primary font-weight-bolder">Top
                                                Engagement</a>
                                            <div class="font-size-sm text-muted font-weight-bold mt-1">
                                                solution provider</div>
                                        </div>
                                    </div>
                                    <div
                                        class="label label-light label-inline font-weight-bold text-dark-50 py-4 px-3 font-size-base">
                                        +00$</div>
                                </div>
                                <!--end::Item-->
                            </div>
                            <!--end::Items-->
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Tiles Widget 1-->
                </div>
                <div class="col-xl-8">
                    <div class="row">
                        <div class="col-xl-3">
                            <!--begin::Tiles Widget 3-->
                            <div class="card card-custom bgi-no-repeat bgi-no-repeat bgi-size-cover gutter-b"
                                style="height: 150px; background-image: url(assets/media/bg/bg-9.jpg)">
                                <!--begin::Body-->
                                <div class="card-body d-flex flex-column">
                                    <!--begin::Title-->
                                    <a href="#"
                                        class="text-dark-75 text-hover-primary font-weight-bolder font-size-h3">Properties</a>
                                    <!--end::Title-->
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Tiles Widget 3-->
                        </div>
                        <div class="col-xl-9">
                            <!--begin::Mixed Widget 10-->
                            <div class="card card-custom gutter-b" style="height: 150px">
                                <!--begin::Body-->
                                <div class="card-body d-flex align-items-center justify-content-between flex-wrap">
                                    <div class="mr-2">
                                        <h3 class="font-weight-bolder">Create CRM Reports</h3>
                                        <div class="text-dark-50 font-size-lg mt-2">
                                            Generate the latest CRM Report
                                        </div>
                                    </div>
                                    <a href="#" class="btn btn-primary font-weight-bold py-3 px-6">Coming Soon</a>
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Mixed Widget 10-->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-6">
                            <!--begin::Tiles Widget 13-->
                            <div class="card card-custom bgi-no-repeat gutter-b"
                                style="height: 175px; background-color: #663259; background-position: calc(100% + 0.5rem) 100%; background-size: 100% auto; background-image: url(assets/media/svg/patterns/taieri.svg)">

                                <!--begin::Body-->
                                <div class="card-body d-flex align-items-center">
                                    <div>
                                        <h3 class="text-white font-weight-bolder line-height-lg mb-5">
                                            Create SaaS<br />Based Reports</h3>
                                        <a href='#' class="btn btn-success font-weight-bold px-6 py-3">Coming Soon</a>
                                    </div>
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Tiles Widget 13-->

                            <div class="row">
                                <div class="col-xl-6">
                                    <!--begin::Tiles Widget 11-->
                                    <div class="card card-custom bg-primary gutter-b" style="height: 150px">
                                        <div class="card-body">
                                            <span class="svg-icon svg-icon-3x svg-icon-white ml-n2">
                                                <!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg--><svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                    height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <rect fill="#000000" x="4" y="4" width="7" height="7"
                                                            rx="1.5" />
                                                        <path
                                                            d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z"
                                                            fill="#000000" opacity="0.3" />
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon--></span>
                                            <div class="text-inverse-primary font-weight-bolder font-size-h2 mt-3">
                                                0000</div>

                                            <a href="#"
                                                class="text-inverse-primary font-weight-bold font-size-lg mt-1">New
                                                Products</a>
                                        </div>
                                    </div>
                                    <!--end::Tiles Widget 11-->
                                </div>
                                <div class="col-xl-6">
                                    <!--begin::Tiles Widget 12-->
                                    <div class="card card-custom gutter-b" style="height: 150px">
                                        <div class="card-body">
                                            <span class="svg-icon svg-icon-3x svg-icon-success">
                                                <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Group.svg--><svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                    height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <polygon points="0 0 24 0 24 24 0 24" />
                                                        <path
                                                            d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z"
                                                            fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                        <path
                                                            d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z"
                                                            fill="#000000" fill-rule="nonzero" />
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon--></span>
                                            <div class="text-dark font-weight-bolder font-size-h2 mt-3">
                                                000</div>

                                            <a href="#"
                                                class="text-muted text-hover-primary font-weight-bold font-size-lg mt-1">New
                                                Customers</a>
                                        </div>
                                    </div>
                                    <!--end::Tiles Widget 12-->
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <!--begin::Mixed Widget 14-->
                            <div class="card card-custom bgi-no-repeat bgi-size-cover gutter-b card-stretch"
                                style="background-image: url(assets/media/stock-600x600/img-16.jpg)">
                                <!--begin::Body-->
                                <div class="card-body d-flex flex-column align-items-start justify-content-start">
                                    <div class="p-1 flex-grow-1">
                                        <h3 class="text-white font-weight-bolder line-height-lg mb-5">
                                            Create Reports<br />With App</h3>
                                    </div>

                                    <a href='#' class="btn btn-link btn-link-warning font-weight-bold">
                                        Coming Soon
                                        <span class="svg-icon svg-icon-lg svg-icon-warning">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg--><svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                                viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24" />
                                                    <rect fill="#000000" opacity="0.3"
                                                        transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000) "
                                                        x="11" y="5" width="2" height="14" rx="1" />
                                                    <path
                                                        d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z"
                                                        fill="#000000" fill-rule="nonzero"
                                                        transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997) " />
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon--></span> </a>
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Mixed Widget 14-->
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Row-->



            <!--end::Dashboard-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>
@endsection

@push('script')
<script src="{{ asset('/assets/js/pages/crud/forms/widgets/select2.js?v=7.0.6"') }}"></script>
<script src="{{ asset('/assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.6') }}"></script>
<script src="{{ asset('/assets/js/pages/crud/datatables/extensions/responsive.js?v=7.0.6') }}"></script>
<script src="{{ asset('/assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js?v=7.0.6') }}"></script>
    
<script>
        let year = {{now()->format('Y')}};
        let kategori = 'All';
        let dataRange = null;
        let tipe = 'tahunan';
        let bulan = 13;
        let dataBulan=null;

        const apexChart = "#penjualanchart";                   
        var options = {
            series: [{
                name: "Penjualan",
                data: dataRange
            }],
            chart: {
                height: 350,
                type: 'line',
                zoom: {
                    enabled: false
                }
            },
            dataLabels: { 	
                enabled: false
            },
            stroke: {
                curve: 'straight'
            },
            grid: {
                row: {
                    colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                    opacity: 0.5
                },
            },
            xaxis: {
                categories: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September','Oktober','November','Desember'],
            },
            colors: [primary]
        };

        var optionsMonth = {
            series: [{
                name: "Penjualan",
                data: dataRange
            }],
            chart: {
                height: 350,
                type: 'line',
                zoom: {
                    enabled: false
                }
            },
            dataLabels: { 	
                enabled: false
            },
            stroke: {
                curve: 'straight'
            },
            grid: {
                row: {
                    colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                    opacity: 0.5
                },
            },
            xaxis: {
                categories: dataBulan,
            },
            colors: [primary]
        };
          
     $(document).ready(function() {
        chartyear();        
     })

     function chartyear() {        
           $.ajax({
                type: 'POST',
                url: '{{ route('chart.year') }}',
                dataType: 'html',
                headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
                data: {
                    'year' : year,
                    'kategori' : kategori,
                    'tipe' : tipe,
                    'bulan' : bulan,
                    "_token": "{{ csrf_token() }}"},
                
                success: function (data){
                   res = JSON.parse("[" + data + "]");
                   dataRes = res[0].laba;
                   options.series[0].data=dataRes;
                   
                   var chart = new ApexCharts(document.querySelector(apexChart), options);   
	               chart.render();                         
                },
                error: function(data){
                    console.log(data);
                }
            });	   
	}

    function chartbulan() {
        $.ajax({
                type: 'POST',
                url: '{{ route('chart.year') }}',
                dataType: 'html',
                headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
                data: {
                    'year' : year,
                    'kategori' : kategori,
                    'tipe' : tipe,
                    'bulan' : bulan,
                    "_token": "{{ csrf_token() }}"},
                
                success: function (data){
                   res = JSON.parse("[" + data + "]");
                   dataRes = res[0].laba;
                   dataBulan = res[0].bulan;
                   
                //    console.log(optionsMonth.xaxis.categories);
                   optionsMonth.series[0].data=dataRes;
                   optionsMonth.xaxis.categories=dataBulan;


                   var chart = new ApexCharts(document.querySelector(apexChart), optionsMonth);   
	               chart.render();

                },
                error: function(data){
                    console.log(data);
                }
            });	  
    }

    function filterYear() {
        let e = document.getElementById("kt_select2_1");
        year = e.options[e.selectedIndex].value; 
        chartyear();
    }

    function filterKategori() {
        let e = document.getElementById("kt_select2_2");
        kategori = e.options[e.selectedIndex].value;         
        chartyear();
    }

    function filterType(params) {
        let e = document.getElementById("kt_select2_4");
        tipe = e.options[e.selectedIndex].value;         
        chartbulan();
    }

   


</script>
@endpush

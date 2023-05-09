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

                       
                          
                            <!--begin::Chart-->
                            {{-- <div id="penjualanchart"></div> --}}
                              <div>
                                 <canvas id="myChart" height="100"></canvas>
                              </div>
                            <!--end::Chart-->
                        </div>
                    </div>
                    
                    
                    <!--end::Card-->
                </div>
            </div>

            <!--begin::Row-->
            <div class="row">
                <div class="col-xl-8">
                    <!--begin::Tiles Widget 1-->
                    <div class="card card-custom gutter-b card-stretch">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-5">
                            <div class="card-title">
                                <div class="card-label">
                                    <div class="font-weight-bolder">Grafik Per Kategori</div>                                
                                </div>
                            </div>
                        </div>
                        <!--end::Header-->

                        {{-- Grafik --}}
                            <div class="card-body">
                                <div class="form-group">    
                                    <label for="">Tahun</label>                                                    
                                    <select name="chart_year" class="form-control" id="kt_select2_7" onchange="filterYearKategori()">                               
                                        @php
                                        $year = 2020;
                                        @endphp
                                        @foreach (range(date('Y'), $year) as $x)
                                            <option value="{{$x}}">{{$x}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <canvas id="KategoriChart" height="100"></canvas>
                            </div>

                        {{-- end Of Grafik --}}
                      
                    </div>
                    <!--end::Tiles Widget 1-->
                </div>              
            </div>
            <!--end::Row-->

            {{-- GRAFIK UNTUK PRODUK --}}
            <div class="row">
                <div class="col-xl-12">
                    <!--begin::Tiles Widget 1-->
                    <div class="card card-custom gutter-b card-stretch">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-5">
                            <div class="card-title">
                                <div class="card-label">
                                    <div class="font-weight-bolder">Grafik Penjualan Produk</div>                                
                                </div>
                            </div>
                        </div>
                        <!--end::Header-->

                        {{-- Grafik --}}
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">    
                                            <label for="">Tahun</label>                                                    
                                            <select name="chart_year" class="form-control" id="kt_select2_5" onchange="filteryearproduk()">                               
                                                @php
                                                $year = 2020;
                                                @endphp
                                                @foreach (range(date('Y'), $year) as $x)
                                                    <option value="{{$x}}">{{$x}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">    
                                            <label for="">Produk</label>                                                    
                                            <select name="chart_year" class="form-control" id="kt_select2_3" onchange="filterProduk()">                                                                           
                                                @foreach ($produk as $item)
                                                    <option value="{{$item->id}}">{{$item->kode}} - {{$item->nama}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                              

                                <canvas id="produkChart" height="100"></canvas>
                            </div>

                        {{-- end Of Grafik --}}
                      
                    </div>
                    <!--end::Tiles Widget 1-->
                </div>              
            </div>
            {{-- END OF GRAFIK PRODUK --}}


            {{--  BEST PRODUK --}}
            <div class="row">
                <div class="col-xl-12">
                    <!--begin::Tiles Widget 1-->
                    <div class="card card-custom gutter-b card-stretch">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-5">
                            <div class="card-title">
                                <div class="card-label">
                                    <div class="font-weight-bolder">Top Produk</div>                                
                                </div>
                            </div>
                        </div>
                        <!--end::Header-->

                        {{-- Grafik --}}
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">    
                                            <label for="">Tahun</label>                                                    
                                            <select name="chart_year" class="form-control" id="kt_select2_8" onchange="filteryearbestproduk()">                               
                                                @php
                                                $year = 2020;
                                                @endphp
                                                @foreach (range(date('Y'), $year) as $x)
                                                    <option value="{{$x}}">{{$x}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-6">
                                        <div class="form-group">    
                                            <label for="">Bulan</label>                                                    
                                            <select name="chart_year" class="form-control" id="kt_select2_4" onchange="filterbulanbestproduk()">   
                                                <option value="All" selected>Semua</option>                                                                        
                                                @foreach ($bulan as $item)
                                                    <option value="{{$item['id']}}">{{$item['nama']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                              

                                <canvas id="chartbestproduk" height="100"></canvas>
                            </div>

                        {{-- end Of Grafik --}}
                      
                    </div>
                    <!--end::Tiles Widget 1-->
                </div>              
            </div>
            {{-- END OF BEST PRODUK --}}

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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
   

        const ctx = document.getElementById('myChart');
        const chartKategori = document.getElementById('KategoriChart');
        const produk_chart = document.getElementById('produkChart');
        const best_produk = document.getElementById('chartbestproduk');

        let year = {{now()->format('Y')}};
        let kategori = 'All';
        let dataRange = null;
        let tipe = 'tahunan';
        let bulan = 'All';
        let dataBulan=null;
        let chart = null;
        let produk = {{$produk[0]->id}};
        // var bulan = @json($bulan);
    

        $(document).ready(function() {
            chartyear();
            chart_kategori();
            chartProduk();
            chartbestproduk();
        })

        // chart Bar Pejualan
         let options= {
                    type: 'line',
                    data: {
                        labels: null ,
                        datasets: [{
                            label: 'Penjualan',
                            data : null,
                            pointStyle: 'circle',
                            pointRadius: 10,
                            pointHoverRadius: 15,                            
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: (ctx) => 'Data Dalam Persen Rupiah ',
                            },
                            legend: {
                                labels: {
                                    // This more specific font property overrides the global property
                                    font: {
                                        size: 11
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                stacked: true,
                                ticks: {
                                    font: {
                                        size: 12,
                                    }
                                }
                            },
                            x: {
                                ticks: {
                                    font: {
                                        size: 12,
                                    }
                                }
                              }
                        }
                    },
                    interaction: {
                         intersect: false,
                    }
                }

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
                    dataLaba = res[0].laba;
                    dataBulan = res[0].bulan;
                    
                    options.data.labels =  dataBulan;
                    options.data.datasets[0].data = dataLaba;
                    chart = new Chart(ctx,options);                                                                                      
                    },
                    error: function(data){
                        console.log(data);
                    }
                });	   
        }

        function filterYear() {
            let e = document.getElementById("kt_select2_1");
            year = e.options[e.selectedIndex].value; 
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
                    dataLaba = res[0].laba;
                    dataBulan = res[0].bulan;
                    options.data.labels =  dataBulan;
                    options.data.datasets[0].data = dataLaba;

                    chart.destroy();
                    chart = new Chart(ctx,options);                                                                                      
                    chart.update();
                    },
                    error: function(data){
                        console.log(data);
                    }
                });	   
        }

        function filterKategori() {
            let e = document.getElementById("kt_select2_2");
            kategori = e.options[e.selectedIndex].value;         
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
                    dataLaba = res[0].laba;
                    dataBulan = res[0].bulan;
                    options.data.labels =  dataBulan;
                    options.data.datasets[0].data = dataLaba;

                    chart.destroy();
                    chart = new Chart(ctx,options);                                                                                      
                    chart.update();
                    },
                    error: function(data){
                        console.log(data);
                    }
                });	 
        }

    // end of Chart Penjualan Bar
    
            let dougnut= {
                    type: 'bar',
                    data: {
                        labels: null ,
                        datasets: [{
                            label: 'Grafik Penjualan Per Kategori',
                            data: null,
                            borderWidth: 1,
                            backgroundColor: ['#FF6384','#36A2EB'],
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: (ctx) => 'Data Dalam Persen Rupiah ',
                            },
                           
                        },
                        scales: {
                            y: {
                                stacked: true
                            }
                        }
                    },
                    interaction: {
                         intersect: false,
                    }
                }

    // Chart dougnut Kategori Penjualan
    function chart_kategori() {        
            $.ajax({
                    type: 'POST',
                    url: '{{ route('chart.kategori') }}',
                    dataType: 'html',
                    headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
                    data: {
                        'year' : year,
                        "_token": "{{ csrf_token() }}"},
                    
                    success: function (data){
                            res = JSON.parse("[" + data + "]");
                            datakategori  = res[0].datakategori;
                            datapenjualan = res[0].datapenjualan;

                            dougnut.data.labels =  datakategori;
                            dougnut.data.datasets[0].data = datapenjualan;
                            chartkategori = new Chart(chartKategori,dougnut);                                                                                      
                    },
                    error: function(data){
                        console.log(data);
                    }
                });	   
        }

        function filterYearKategori() {
            let e = document.getElementById("kt_select2_7");
            year = e.options[e.selectedIndex].value; 
            $.ajax({
                    type: 'POST',
                    url: '{{ route('chart.kategori') }}',
                    dataType: 'html',
                    headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
                    data: {
                        'year' : year,                      
                        "_token": "{{ csrf_token() }}"},
                    
                    success: function (data){
                    res = JSON.parse("[" + data + "]");
                    datakategori  = res[0].datakategori;
                    datapenjualan = res[0].datapenjualan;

                    dougnut.data.labels =  datakategori;
                    dougnut.data.datasets[0].data = datapenjualan;

                    chartkategori.destroy();
                    chartkategori = new Chart(chartKategori,dougnut);                                                                                      
                    chartkategori.update();

                    },
                    error: function(data){
                        console.log(data);
                    }
                });	   
        }


        // untuk Forecast Produk
        let produkchart= {
                    type: 'line',
                    data: {
                        labels: null ,
                        datasets: [{
                            label: 'Penjualan per Produk',
                            data : null,
                            pointStyle: 'circle',
                            pointRadius: 10,
                            pointHoverRadius: 15,                            
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: (ctx) => 'Data Dalam Persen Rupiah ',
                            },
                            legend: {
                                labels: {
                                    // This more specific font property overrides the global property
                                    font: {
                                        size: 11
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                stacked: true,
                                ticks: {
                                    font: {
                                        size: 12,
                                    }
                                }
                            },
                            x: {
                                ticks: {
                                    font: {
                                        size: 12,
                                    }
                                }
                              }
                        }
                    },
                    interaction: {
                         intersect: false,
                    }
                }

        function chartProduk() {        
            $.ajax({
                    type: 'POST',
                    url: '{{ route('chart.produk') }}',
                    dataType: 'html',
                    headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
                    data: {
                        'year' : year,
                        'produk' : produk,   
                        "_token": "{{ csrf_token() }}"},
                    
                    success: function (data){
                        res = JSON.parse("[" + data + "]");
                        dataStok  = res[0].stok;
                        dataBulan = res[0].bulan;

                        produkchart.data.labels =  dataBulan;
                        produkchart.data.datasets[0].data = dataStok;
                        grafikProduk = new Chart(produk_chart,produkchart);                                                                           
                    },
                    error: function(data){
                        console.log(data);
                    }
                });	   
        }

        function filteryearproduk() {
            let e = document.getElementById("kt_select2_5");
            year = e.options[e.selectedIndex].value; 

            $.ajax({
                    type: 'POST',
                    url: '{{ route('chart.produk') }}',
                    dataType: 'html',
                    headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
                    data: {
                        'year' : year,   
                        'produk' : produk,                      
                        "_token": "{{ csrf_token() }}"},
                    
                    success: function (data){
                    res = JSON.parse("[" + data + "]");
                    dataStok  = res[0].stok;
                    dataBulan = res[0].bulan;

                    produkchart.data.labels =  dataBulan;
                    produkchart.data.datasets[0].data = dataStok;

                    grafikProduk.destroy();
                    grafikProduk = new Chart(produk_chart,produkchart);                                                                                      
                    grafikProduk.update();

                    },
                    error: function(data){
                        console.log(data);
                    }
                });	   
        }

        function filterProduk() {
            let e = document.getElementById("kt_select2_3");
            produk = e.options[e.selectedIndex].value; 

            $.ajax({
                    type: 'POST',
                    url: '{{ route('chart.produk') }}',
                    dataType: 'html',
                    headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
                    data: {
                        'year' : year,  
                        'produk' : produk,                   
                        "_token": "{{ csrf_token() }}"},
                    
                    success: function (data){
                    res = JSON.parse("[" + data + "]");
                    dataStok  = res[0].stok;
                    dataBulan = res[0].bulan;

                    produkchart.data.labels =  dataBulan;
                    produkchart.data.datasets[0].data = dataStok;

                    grafikProduk.destroy();
                    grafikProduk = new Chart(produk_chart,produkchart);                                                                                      
                    grafikProduk.update();

                    },
                    error: function(data){
                        console.log(data);
                    }
                });	   
        }


        // GRAFIK PRODUK DENGAN PENJUALAN TERBAIK 
         let bestproduk= {
            type: 'bar',
            data: {
                labels: null ,
                datasets: [
                    {
                        label: 'Grafik Performa Customer',
                        data: null,
                        borderWidth: 1,                        
                        borderColor :['#ff6384','#36a2eb','#cc65fe','#ffce56'],
                        backgroundColor :['#ff6384','#36a2eb','#cc65fe','#ffce56']                
                    },                                           
                ],
            },
            options: {
                indexAxis: 'y',                
                elements: {
                    bar: {
                        borderWidth: 2,
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                    },                    
                },
                scales: {
                    y: {
                        stacked: true,
                        ticks: {
                            font: {
                                size: 9,
                            }
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 10,
                            }
                        }
                        }
                }
            },
        }

        function chartbestproduk() {        
            $.ajax({
                    type: 'POST',
                    url: '{{ route('chart.bestproduk') }}',
                    dataType: 'html',
                    headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
                    data: {
                        'year' : year,    
                        'bulan' : bulan,                   
                        "_token": "{{ csrf_token() }}"},
                    
                    success: function (data){
                        res = JSON.parse("[" + data + "]");
                        dataNamaProduk  = res[0].nama_produk;
                        dataStokProduk = res[0].stok;

                        bestproduk.data.labels =  dataNamaProduk;
                        bestproduk.data.datasets[0].data = dataStokProduk;
                        grafikbestproduk = new Chart(best_produk,bestproduk);                                                                           
                    },
                    error: function(data){
                        console.log(data);
                    }
                });	   
        }


        function filteryearbestproduk() {
            let e = document.getElementById("kt_select2_8");
            year = e.options[e.selectedIndex].value; 

            $.ajax({
                    type: 'POST',
                    url: '{{ route('chart.bestproduk') }}',
                    dataType: 'html',
                    headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
                    data: {
                        'year' : year, 
                        'bulan' : bulan,                      
                        "_token": "{{ csrf_token() }}"},
                    
                    success: function (data){
                        res = JSON.parse("[" + data + "]");
                        dataNamaProduk  = res[0].nama_produk;
                        dataStokProduk = res[0].stok;
                       
                        
                        if (dataStokProduk.length > 0) {
                                bestproduk.data.labels =  dataNamaProduk;
                                bestproduk.data.datasets[0].data = dataStokProduk;

                                grafikbestproduk.destroy();
                                grafikbestproduk = new Chart(best_produk,bestproduk);                                                                           
                                grafikbestproduk.update();
                            }else{
                                grafikbestproduk.destroy();
                            }
                     
                    },
                    error: function(data){
                        console.log(data);
                    }
                });	   
        }

        function filterbulanbestproduk() {
            let e = document.getElementById("kt_select2_4");
            bulan = e.options[e.selectedIndex].value; 

            $.ajax({
                    type: 'POST',
                    url: '{{ route('chart.bestproduk') }}',
                    dataType: 'html',
                    headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
                    data: {
                        'year' : year, 
                        'bulan' : bulan,                      
                        "_token": "{{ csrf_token() }}"},
                    
                    success: function (data){
                        res = JSON.parse("[" + data + "]");
                        dataNamaProduk  = res[0].nama_produk;
                        dataStokProduk = res[0].stok;

                        if (dataStokProduk.length > 0) {
                                bestproduk.data.labels =  dataNamaProduk;
                                bestproduk.data.datasets[0].data = dataStokProduk;

                                grafikbestproduk.destroy();
                                grafikbestproduk = new Chart(best_produk,bestproduk);                                                                           
                                grafikbestproduk.update();
                        }else{
                               grafikbestproduk.destroy();
                        }
                    },
                    error: function(data){
                        console.log(data);
                    }
                });	   
        }

    
  </script>
@endpush

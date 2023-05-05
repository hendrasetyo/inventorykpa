@extends('layouts.app', ['title' => $title])

@section('content')
<!--begin::Content-->
<div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->

    {{-- GRAFIK PERFORMA SALES --}}

    <div class="container ">
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
                            <h3 class="card-label">Grafik Performa Sales</h3>

                           
                        </div>                            
                    </div>
                    
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">    
                                    <label for="">Tahun</label>                                                    
                                    <select name="chart_year" class="form-control" id="kt_select2_3" onchange="filteryeargrafik()">                               
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
                                    <label for="">Kategori</label>                                                    
                                    <select name="chart_year" class="form-control" id="kt_select2_4" onchange="filteryearkategori()">    
                                        <option value="All" selected>Semua</option>                                                                    
                                            @foreach ($kategori as $x)
                                                <option value="{{$x->id}}">{{$x->nama}}</option>
                                            @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                            <canvas class="row" height="100" id="chartperformasales">
                                    
                            </canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- END GRAFIK PERFORMA SALES --}}

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid mt-10">

        
        <!--begin::Container-->
        <div class="container ">
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
                                <h3 class="card-label">Data Penjualan Customer</h3>
                               

                               
                            </div>                            
                        </div>
                        
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">    
                                        <label for="">Tahun</label>                                                    
                                        <select name="chart_year" class="form-control" id="kt_select2_1" onchange="filtercustomeryear()">                               
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
                                        <label for="">Bulan</label>                                                    
                                        <select name="chart_year" class="form-control" id="kt_select2_2" onchange="filtercustomerkategori()"> 
                                            <option value="All" selected>Semua</option> 
                                                @foreach ($kategori as $x)
                                                    <option value="{{$x->id}}">{{$x->nama}}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                                <canvas class="row" height="200" id="performasalesCustomer">
                                        
                                </canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>

@endsection
@push('script')
<script src="{{ asset('/assets/js/pages/crud/forms/widgets/select2.js?v=7.0.6') }}"></script>
<script src="{{ asset('/assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.6') }}"></script>
<script src="{{ asset('/assets/js/pages/crud/datatables/extensions/responsive.js?v=7.0.6') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const idperformasales = document.getElementById('chartperformasales'); 
    const grafikcustomer = document.getElementById('performasalesCustomer');   

    let year = {{now()->format('Y')}};
    let month = {{now()->format('m')}};
    let kategori = 'All';


    // untuk customer
    let yearCustomer = {{now()->format('Y')}};
    let kategoriCustomer = 'All';
    // end of customer

    let sales_id = {{$sales_id}};

    $(document).ready(function() {
        grafikperformasalesdetail();
        grafikperformacustomer();
    })

    let barPerformaSales= {
            type: 'bar',
            data: {
                labels: null ,
                datasets: [{
                    label: 'Grafik Performa Sales',
                    data: null,
                    borderWidth: 1,   
                    stack: 'combined',                 
                },            
                {
                    label: 'Target Tertinggi Perbulan Sales',
                    data: [575000000,575000000,575000000,575000000,575000000,575000000,575000000,575000000,575000000,575000000,575000000,575000000,575000000],
                    borderWidth: 4,                        
                    type: 'line',
                    color:'#36A2EB',   
                    borderDash: [5, 5],                                                      
                },
                
                ],
                

            },
            options: {
                responsive: true,
                plugins: {
                title: {
                    display: true,
                    text: (ctx) => 'Data Dalam Rupiah ',
                }
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

 

    function grafikperformasalesdetail() {
        $.ajax({
                    type: 'POST',
                    url: '{{ route('performasales.dataperformasales.detailgrafik') }}',
                    dataType: 'html',
                    headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
                    data: {                       
                        "_token": "{{ csrf_token() }}",
                        'year' : year,
                        'kategori' : kategori,
                        'id' : sales_id                       
                    },                    
                    success: function (data){
                        
                        res = JSON.parse("[" + data + "]");
                        let bulan = res[0].bulan;
                        let dataPenjualan = res[0].laba;

                        barPerformaSales.data.labels =  bulan;
                        barPerformaSales.data.datasets[0].data = dataPenjualan;

                        chartkategori = new Chart(idperformasales,barPerformaSales);   
                                                                                      
                    },
                    error: function(data){
                        console.log(data);
                    }
                });	   
    }


    function filteryeargrafik() {
        let e = document.getElementById("kt_select2_3");
            year = e.options[e.selectedIndex].value; 
            
            $.ajax({
                    type: 'POST',
                    url: '{{ route('performasales.dataperformasales.detailgrafik') }}',
                    dataType: 'html',
                    headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
                    data: {                       
                        "_token": "{{ csrf_token() }}",
                        'year' : year,
                        'kategori' : kategori,
                        'id' : sales_id 
                       
                    },                    
                    success: function (data){
                        
                        res = JSON.parse("[" + data + "]");
                        let bulan = res[0].bulan;
                        let dataPenjualan = res[0].laba;

                        barPerformaSales.data.labels =  bulan;
                        barPerformaSales.data.datasets[0].data = dataPenjualan;

                        chartkategori.destroy();
                        chartkategori = new Chart(idperformasales,barPerformaSales);   
                        chartkategori.update();
                                                                                      
                    },
                    error: function(data){
                        console.log(data);
                    }
                });	   
    }

    function filteryearkategori() {
                let e = document.getElementById("kt_select2_4");
                kategori = e.options[e.selectedIndex].value; 
            
            $.ajax({
                    type: 'POST',
                    url: '{{ route('performasales.dataperformasales.detailgrafik') }}',
                    dataType: 'html',
                    headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
                    data: {                       
                        "_token": "{{ csrf_token() }}",
                        'year' : year,
                        'kategori' : kategori,
                        'id' : sales_id 
                       
                    },                    
                    success: function (data){
                        
                        res = JSON.parse("[" + data + "]");
                        let bulan = res[0].bulan;
                        let dataPenjualan = res[0].laba;

                        barPerformaSales.data.labels =  bulan;
                        barPerformaSales.data.datasets[0].data = dataPenjualan;

                        chartkategori.destroy();
                        chartkategori = new Chart(idperformasales,barPerformaSales);   
                        chartkategori.update();
                                                                                      
                    },
                    error: function(data){
                        console.log(data);
                    }
                });	   
    }



    // ================================ GRAFIK TOP PENCAPAIAN CUSTOMER =====================

    let barCustomer= {
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
    

    
        function grafikperformacustomer() {
            $.ajax({
                        type: 'POST',
                        url: '{{ route('performasales.dataperformasales.performasalesCustomer') }}',
                        dataType: 'html',
                        headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
                        data: {                       
                            "_token": "{{ csrf_token() }}",
                            'year' : yearCustomer,
                            'kategori' : kategoriCustomer,
                            'id' : sales_id                       
                        },                    
                        success: function (data){
                            
                            res = JSON.parse("[" + data + "]");
                            let customer = res[0].customer;
                            let penjualan = res[0].laba;

                            barCustomer.data.labels =  customer;
                            barCustomer.data.datasets[0].data = penjualan;

                            chartCustomer = new Chart(grafikcustomer,barCustomer);  
                           

                            
                                                                                        
                        },
                        error: function(data){
                            console.log(data);
                        }
                    });	   
    }

    function filtercustomeryear() {

        let e = document.getElementById("kt_select2_1");
        yearCustomer = e.options[e.selectedIndex].value; 

        $.ajax({
                        type: 'POST',
                        url: '{{ route('performasales.dataperformasales.performasalesCustomer') }}',
                        dataType: 'html',
                        headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
                        data: {                       
                            "_token": "{{ csrf_token() }}",
                            'year' : yearCustomer,
                            'kategori' : kategoriCustomer,
                            'id' : sales_id                       
                        },                    
                        success: function (data){
                            
                            res = JSON.parse("[" + data + "]");
                            let customer = res[0].customer;
                            let penjualan = res[0].laba;

                            barCustomer.data.labels =  customer;
                            barCustomer.data.datasets[0].data = penjualan;


                            chartCustomer.destroy();
                            chartCustomer = new Chart(grafikcustomer,barCustomer);  
                            chartCustomer.update()
                                                                                                                
                        },
                        error: function(data){
                            console.log(data);
                        }
                    });	   
    }

    function filtercustomerkategori() {
        let e = document.getElementById("kt_select2_2");
        kategoriCustomer = e.options[e.selectedIndex].value; 

        $.ajax({
                        type: 'POST',
                        url: '{{ route('performasales.dataperformasales.performasalesCustomer') }}',
                        dataType: 'html',
                        headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
                        data: {                       
                            "_token": "{{ csrf_token() }}",
                            'year' : yearCustomer,
                            'kategori' : kategoriCustomer,
                            'id' : sales_id                       
                        },                    
                        success: function (data){
                            
                            res = JSON.parse("[" + data + "]");
                            let customer = res[0].customer;
                            let penjualan = res[0].laba;

                            barCustomer.data.labels =  customer;
                            barCustomer.data.datasets[0].data = penjualan;

                            chartCustomer.destroy();
                            chartCustomer = new Chart(grafikcustomer,barCustomer);  
                            chartCustomer.update()
                                                                                                                                       
                        },
                        error: function(data){
                            console.log(data);
                        }
                    });	   
    }
    
</script>

@endpush
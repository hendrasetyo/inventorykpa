<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <base href="">
    <meta charset="utf-8" />
    <title>{{ $title ?? config('app.name') }}</title>
    <meta name="description" content="Updates and statistics" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->

    <!--begin::Page Vendors Styles(used by this page)-->
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css?v=7.0.6') }}" rel="stylesheet"
        type="text/css" />
    <!--end::Page Vendors Styles-->

    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css?v=7.0.6') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.css?v=7.0.6') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css?v=7.0.6') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles-->

    <!--begin::Layout Themes(used by all pages)-->
    <!--end::Layout Themes-->
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/logo_kpa_putih.png') }}" />


    {{-- Custom Layout --}}
    <link href="{{ asset('style.css') }}" rel="stylesheet" type="text/css" />

    <style type="text/css">
        .signature-pad {
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
            height: 260px;
        }
    </style>

</head>
<!--end::Head-->

<!--begin::Body-->

<body id="kt_body" style="background-image: url({{ asset('assets/media/bg/bg-10.jpg') }})"
    class="quick-panel-right demo-panel-right offcanvas-right header-fixed subheader-enabled page-loading">
    <!--begin::Main-->
    <!--begin::Header Mobile-->
    <div id="kt_header_mobile" class="header-mobile ">
        <!--begin::Logo-->
        <a href="/">
            <img alt="Logo" src="{{ asset('assets/media/logos/logo_kpa_main.png') }}"
                class="logo-default max-h-30px" />
        </a>
        <!--end::Logo-->

        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">

            <button class="btn p-0 burger-icon burger-icon-left ml-4" id="kt_header_mobile_toggle">
                <span></span>
            </button>

            <button class="btn btn-icon btn-hover-transparent-white p-0 ml-3" id="kt_header_mobile_topbar_toggle">
                <span class="svg-icon svg-icon-xl">
                    <!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg--><svg
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                        height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24" />
                            <path
                                d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z"
                                fill="#000000" fill-rule="nonzero" opacity="0.3" />
                            <path
                                d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z"
                                fill="#000000" fill-rule="nonzero" />
                        </g>
                    </svg>
                    <!--end::Svg Icon--></span> </button>
        </div>
        <!--end::Toolbar-->
    </div>
    <!--end::Header Mobile-->
    <div class="d-flex flex-column flex-root">

        {{-- loader  --}}
        <div id="overlay">
            <div class="cv-spinner">
                <span class="spinner"></span>
            </div>
        </div>

        <!--begin::Page-->
        <div class="d-flex flex-row flex-column-fluid page">
            <!--begin::Wrapper-->
            <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                <!--begin::Content-->
                @yield('body')
                <!--end::Content-->

                <!--begin::Footer-->
                <div class="footer bg-white py-4 d-flex flex-lg-column " id="kt_footer">
                    <!--begin::Container-->
                    <div class=" container  d-flex flex-column flex-md-row align-items-center justify-content-between">
                        <!--begin::Copyright-->
                        <div class="text-dark order-2 order-md-1">
                            <span class="text-muted font-weight-bold mr-2">2021 &copy; PT KARYA PUTRA ANDALAN</span>
                            <a href="http://keenthemes.com/metronic" target="_blank"
                                class="text-dark-75 text-hover-primary"></a>
                        </div>
                        <!--end::Copyright-->

                        <!--begin::Nav-->
                        {{-- <div class="nav nav-dark order-1 order-md-2">
                            <a href="#" target="_blank" class="nav-link pr-3 pl-0">About</a>
                            <a href="#" target="_blank" class="nav-link px-3">Team</a>
                            <a href="#" target="_blank" class="nav-link pl-3 pr-0">Contact</a>
                        </div> --}}
                        <!--end::Nav-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Footer-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Main-->
    @include('layouts.notification')

    <!--begin::Global Config(global config for global JS scripts)-->
    <script>
        var KTAppSettings = {
            "breakpoints": {
                "sm": 576,
                "md": 768,
                "lg": 992,
                "xl": 1200,
                "xxl": 1200
            },
            "colors": {
                "theme": {
                    "base": {
                        "white": "#ffffff",
                        "primary": "#6993FF",
                        "secondary": "#E5EAEE",
                        "success": "#1BC5BD",
                        "info": "#8950FC",
                        "warning": "#FFA800",
                        "danger": "#F64E60",
                        "light": "#F3F6F9",
                        "dark": "#212121"
                    },
                    "light": {
                        "white": "#ffffff",
                        "primary": "#E1E9FF",
                        "secondary": "#ECF0F3",
                        "success": "#C9F7F5",
                        "info": "#EEE5FF",
                        "warning": "#FFF4DE",
                        "danger": "#FFE2E5",
                        "light": "#F3F6F9",
                        "dark": "#D6D6E0"
                    },
                    "inverse": {
                        "white": "#ffffff",
                        "primary": "#ffffff",
                        "secondary": "#212121",
                        "success": "#ffffff",
                        "info": "#ffffff",
                        "warning": "#ffffff",
                        "danger": "#ffffff",
                        "light": "#464E5F",
                        "dark": "#ffffff"
                    }
                },
                "gray": {
                    "gray-100": "#F3F6F9",
                    "gray-200": "#ECF0F3",
                    "gray-300": "#E5EAEE",
                    "gray-400": "#D6D6E0",
                    "gray-500": "#B5B5C3",
                    "gray-600": "#80808F",
                    "gray-700": "#464E5F",
                    "gray-800": "#1B283F",
                    "gray-900": "#212121"
                }
            },
            "font-family": "Poppins"
        };
    </script>
    <!--end::Global Config-->

    <!--begin::Global Theme Bundle(used by all pages)-->
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js?v=7.0.6') }}"></script>
    <script src="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.js?v=7.0.6') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js?v=7.0.6') }}"></script>
    <!--end::Global Theme Bundle-->

    <!--begin::Page Scripts(used by this page)-->
    <script src="{{ asset('assets/js/pages/widgets.js?v=7.0.6') }}"></script>


    <!--begin::Page Scripts(used by this page)-->
    <script src="{{ asset('assets/js/pages/crud/datatables/basic/scrollable.js?v=7.0.6') }}"></script>

    <script src="{{ asset('assets/js/pages/features/miscellaneous/sweetalert2.js?v=7.0.6') }}"></script>

    <script src="{{ asset('assets/js/pages/features/miscellaneous/sweetalert2.js?v=7.0.6') }}"></script>

    <!--begin::Page Scripts(used by this page)-->
    <script src="{{ asset('assets/js/pages/features/charts/apexcharts.js?v=7.0.6') }} "></script>
    <!--end::Page Scripts-->

    <!--end::Page Scripts-->
    @stack('script')
    <!--end::Page Scripts-->

    {{-- <script>
        jQuery(function($){
                $(document).ajaxSend(function() {
                    $("#overlay").fadeIn(100);　
                });
                    
                $('#button').click(function(){
                    $.ajax({
                    type: 'GET',
                    success: function(data){
                        console.log(data);
                    }
                    }).done(function() {
                        setTimeout(function(){
                            $("#overlay").fadeOut(100);
                        },500);
                    });
                });	
          });
    </script> --}}

    <script>
        @if (session('success-create'))
            swal("Good job!", "Anda Berhasil Menambahkan Data !", "success");
        @endif

        @if (session('success-update'))
            swal("Good job!", "Anda Berhasil Mengubah Data !", "success");
        @endif
    </script>

</body>
<!--end::Body-->

</html>

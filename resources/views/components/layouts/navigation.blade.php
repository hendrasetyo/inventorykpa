<!--begin::Header MENU-->
<div id="kt_header" class="header  header-fixed ">
    <!--begin::Container-->
    <div class=" container  d-flex align-items-stretch justify-content-between">
        <!--begin::Left-->
        <div class="d-flex align-items-stretch mr-3">
            <!--begin::Header Logo-->
            <div class="header-logo">
                <a href="/">
                    <img alt="Logo" src="{{ asset('assets/media/logos/logo_kpa_main.png') }}"
                        class="logo-default max-h-40px" />
                    <img alt="Logo" src="{{ asset('assets/media/logos/logo_kpa.png') }}"
                        class="logo-sticky max-h-40px" />
                </a>
            </div>
            <!--end::Header Logo-->

            <!--begin::Header Menu Wrapper-->
            <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
                <!--begin::Header Menu-->
                <div id="kt_header_menu"
                    class="header-menu header-menu-left header-menu-mobile  header-menu-layout-default ">
                    <!--begin::Header Navigation-->
                    <ul class="menu-nav ">
                        <li class="menu-item  menu-item-open menu-item-rel" aria-haspopup="true">
                            <a href="/" class="menu-link"><span class=" menu-text">Dashboard</span><i
                                    class="menu-arrow"></i></a>
                        </li>                    
                        @foreach ($navigations as $navigation)
                       
                            @can($navigation->permission_name)
                                <li class="menu-item  menu-item-submenu menu-item-rel" data-menu-toggle="click"
                                    aria-haspopup="true"><a href="javascript:;" class="menu-link menu-toggle"><span
                                            class="menu-text">{{ $navigation->name }}</span><span class="menu-desc"></span><i
                                            class="menu-arrow"></i></a>
                                    <div class="menu-submenu menu-submenu-classic menu-submenu-left">
                                        <ul class="menu-subnav">
                                            @foreach ($navigation->children->sortBy('urut') as $child)
                                                @can($child->permission_name)
                                                    <li class="menu-item " aria-haspopup="true"><a href="{{ url($child->url) }}"
                                                        class=" menu-link ">
                                                        <span class=" svg-icon menu-icon">
                                                            <i class="{{ $child->icon }}"></i>
                                                        </span>
                                                        <span class="menu-text">{{ $child->name }}</span><span class="menu-label">
                                                        </span></a>
                                                   </li>
                                                @endcan
                                          
                                            @endforeach
                                        </ul>
                                    </div>
                                </li>
                            @endcan
                        @endforeach


                    </ul>
                    <!--end::Header Navigation-->
                </div>
                <!--end::Header Menu-->
            </div>
            <!--end::Header Menu Wrapper-->
        </div>
        <!--end::Left-->

        <!--begin::Topbar-->
        <div class="topbar">

            <!--begin::User-->
            <div class="dropdown">
                <!--begin::Toggle-->
                <div class="topbar-item" data-toggle="dropdown" data-offset="0px,0px">
                    <div
                        class="btn btn-icon btn-hover-transparent-white d-flex align-items-center btn-lg px-md-2 w-md-auto">                       
                        <span
                            class="text-white opacity-90 font-weight-bolder font-size-base d-none d-md-inline mr-4">{{ Auth::user()->name }}</span>                                                   
                    </div>
                </div>
                <!--end::Toggle-->

                <!--begin::Dropdown-->
                <div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg p-0">
                    <!--begin::Header-->
                    <div class="d-flex align-items-center p-8 rounded-top">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-md bg-light-primary mr-3 flex-shrink-0">
                            @if(Auth::user()->avatar == "")
                            <img src="{{ asset('assets/media/users/blank.png') }}" alt="" />
                            @else
                            <img src="{{ asset('storage/'.Auth::user()->avatar) }}" alt="" />
                            @endif
                        </div>
                        <!--end::Symbol-->

                        <!--begin::Text-->
                        <div class="text-dark m-0 flex-grow-1 mr-3 font-size-h5">{{ Auth::user()->name }}</div>

                        <!--end::Text-->
                    </div>
                    <div class="separator separator-solid"></div>
                    <!--end::Header-->

                    <!--begin::Nav-->
                    <div class="navi navi-spacer-x-0 pt-5">
                        <!--begin::Item-->
                        <a href="/profile/edit" class="navi-item px-8">
                            <div class="navi-link">
                                <div class="navi-icon mr-2">
                                    <i class="flaticon2-calendar-3 text-success"></i>
                                </div>
                                <div class="navi-text">
                                    <div class="font-weight-bold">
                                        My Profile
                                    </div>
                                    <div class="text-muted">
                                        Account settings and more
                                        <span
                                            class="label label-light-danger label-inline font-weight-bold">update</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <!--end::Item-->

                        <!--begin::Footer-->
                        <div class="navi-separator mt-3"></div>
                        <div class="navi-footer  px-8 py-5">
                            @guest
                            <a href="/register" class="btn btn-clean font-weight-bold">Register</a>
                            <a href="/login" class="btn btn-light-primary font-weight-bold">Log In</a>
                            @else
                            <a href="/logout"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit()"
                                class="btn btn-light-danger font-weight-bold">Log Out<output></output></a>
                            <form action="/logout" method="post" id="logout-form">@csrf</form>
                            @endguest



                        </div>
                        <!--end::Footer-->
                    </div>
                    <!--end::Nav-->
                </div>
                <!--end::Dropdown-->
            </div>
            <!--end::User-->
        </div>
        <!--end::Topbar-->
    </div>
    <!--end::Container-->
</div>
<!--end::Header-->
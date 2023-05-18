<!DOCTYPE html>

@php
  $configData = Helper::applClasses();
@endphp

<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>

        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
        <meta name="author" content="Codechroma MLM Software Solutions">
        <!-- Favicon -->
        <link rel="icon" href="{{ asset('assets/img/brand/favicon.png') }}" type="image/x-icon"/>

        <!-- Title -->
        <title>@yield('title') - {{ $configData['projectTitle'] }}</title>

        <!-- Bootstrap css-->
        <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"/>

        <!-- Icons css-->
        <link href="{{ asset('assets/plugins/web-fonts/icons.css') }}" rel="stylesheet"/>
        <link href="{{ asset('assets/plugins/web-fonts/font-awesome/font-awesome.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/plugins/web-fonts/plugin.css') }}" rel="stylesheet"/>

        <!-- Style css-->
        <link href="{{ asset('assets/css/style/style.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/skins.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/dark-style.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/colors/default.css') }}" rel="stylesheet">

        <!-- Color css-->
        <link id="theme" rel="stylesheet" type="text/css" media="all" href="{{ asset('assets/css/colors/'.$configData['primaryColor'].'.css') }}">

        <!-- Sidemenu css-->
        <link href="{{ asset('assets/css/sidemenu/sidemenu.css') }}" rel="stylesheet">

        <!-- Page CSS -->
        @yield('page-css')

    </head>

    @php
        $menu_style = $configData['menu'] == 'horizontal-menu' ? 'horizontalmenu' : 'main-body leftmenu';
        $theme_style = $configData['theme'] == 'dark' ? 'dark-theme' : '';
    @endphp

    <body class="{{ $menu_style }} {{ $theme_style }}">

        <!-- Loader -->
        <div id="global-loader">
            <img src="{{ asset('assets/img/loader.svg') }}" class="loader-img" alt="Loader">
        </div>
        <!-- End Loader -->

        <!-- Page -->
        <div class="page">

            <!-- Sidebar -->
            @if($configData['menu'] == 'vertical-menu')
                @include('admin.layouts.verticalMenu')
            @endif

            <!-- Main Header-->
            @if($configData['menu'] == 'vertical-menu')
                @include('admin.layouts.desktopHeader')
            @else
                @include('admin.layouts.verticalHeader')
            @endif
            <!-- End Main Header-->     

            <!-- Mobile-header -->
            @include('admin.layouts.mobileHeader')
            <!-- Mobile-header closed -->

            <!-- Main Content-->
            <div class="main-content side-content pt-0">
                <div class="container-fluid">
                    <div id="app" class="inner-body">
                        @yield('content')
                    </div>
                </div>
            </div>
            <!-- End Main Content-->

            <!-- Main Footer-->
            @include('admin.layouts.footer')
            <!--End Footer-->               
            
        </div>
        <!-- End Page -->

        @if($configData['isScrollTop'])
            <!-- Back-to-top -->
            <a href="#top" id="back-to-top"><i class="fe fe-arrow-up"></i></a>
        @endif

        <!-- Jquery js-->
        <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>

        <!-- Bootstrap js-->
        <script src="{{ asset('assets/plugins/bootstrap/js/popper.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

        <!-- Perfect-scrollbar js -->
        <script src="{{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>

        <!-- Sidemenu js -->
        <script src="{{ asset('assets/plugins/sidemenu/sidemenu.js') }}"></script>

        <script src="{{ asset('assets/plugins/sidebar/sidebar.js') }}"></script>

        <!-- Sticky js -->
        <script src="{{ asset('assets/js/sticky.js') }}"></script>
        
        <!-- Page JS -->
        @yield('page-js')

        <!-- Custom js -->
        <script src="{{ asset('assets/js/custom.js') }}"></script>

    </body>
    
</html>
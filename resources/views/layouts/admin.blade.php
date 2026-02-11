<!DOCTYPE html>
<html lang="en">

<head>
    <!-- All meta and title start-->
    @include('layout.head')
    <!-- meta and title end-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- css start-->
    @include('layout.css')
    <!-- css end-->
    
</head>

<body>
    
    <style>
        #sidebar-menu .simplebar-offset { 
            min-height: 90vh; 
        }
        .dataTables_wrapper button.btn-light, .page-wrapper li.sidebar-main-title{
            color: #183053;
        }
        .page-wrapper li.sidebar-main-title > div {
            background-color: #F47A30;
        }
        .page-wrapper li.sidebar-main-title h4{
            color: #F7F9FC;
            letter-spacing: 0px;
        }
        #mysidebar .sidebar-main .sidebar-links .simplebar-wrapper .simplebar-mask .simplebar-content-wrapper .simplebar-content > li .sidebar-link.active,
        #mysidebar .sidebar-main .sidebar-links .simplebar-wrapper .simplebar-mask .simplebar-content-wrapper .simplebar-content > li .sidebar-link.active span,
        #mysidebar .sidebar-main .sidebar-links .simplebar-wrapper .simplebar-mask .simplebar-content-wrapper .simplebar-content > li .sidebar-link.active div i,
        #mysidebar .sidebar-main .sidebar-links .simplebar-wrapper .simplebar-mask .simplebar-content-wrapper .simplebar-content > li .sidebar-link.active svg{
            background-color: #183053;
            color: #F7F9FC;
        }
        .btn-sm{
            padding: 6px;
        }
        .dataTables_wrapper table.dataTable th, .dataTables_wrapper table.dataTable td{
            padding: 0.5em;
        }
        .bg-primary{
            background-color: #183053 !important;
        }
         /* Aplicación global */.
        body {
            font-family: 'Montserrat', sans-serif !important;
            font-size: 1em;
        }
        body, h1, h2, h3, h4, h5, h6, .btn, .form-control, .sidebar-link, .page-title, .page-wrapper.compact-wrapper .page-body-wrapper div.sidebar-wrapper .sidebar-main .sidebar-links li a span, .page-wrapper.compact-wrapper .page-body-wrapper div.sidebar-wrapper .sidebar-main .sidebar-links .simplebar-wrapper .simplebar-mask .simplebar-content-wrapper .simplebar-content > li .sidebar-submenu li a {
            font-family: 'Montserrat', sans-serif !important;
            letter-spacing: 0.1px;
        }
    
        /* Opcional: Para que los textos de los inputs no se vean tan pesados, 
        podemos dejar el peso normal pero la misma fuente */
        input::placeholder, .text-muted, span, p, a, small {
            font-weight: 400 !important;.
            letter-spacing: 0.1px;
            font-size: 1em;
        }
    </style>
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->

    <!-- Loader starts-->
    <div class="loader-wrapper">
        <div class="loader"></div>
    </div>
    <!-- Loader ends-->

    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">

        <!-- Page Header Start-->
        @include('layout.header')
        <!-- Page Header Ends -->

        <!-- Page Body Start-->
        <div class="page-body-wrapper">

        <!-- Page Sidebar Start-->
            @include('layout.sidebar')
        <!-- Page Sidebar Ends-->

        <div class="page-body">
            @yield('content')
            {{-- main body content --}}
           

        </div>
        <!-- footer start-->
            @include('layout.footer')
        <!-- footer end-->
        </div>
    </div>
    <!-- scripts start-->
    @include('layout.script')
    @stack('scripts')
    <!-- scripts end-->
</body>

</html>

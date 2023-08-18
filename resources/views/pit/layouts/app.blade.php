<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="google" content="notranslate">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{DB::table('appinfo')->first()->appname}}</title>

    <!-- Scripts -->
    {{-- <script src="{{ asset('plugins/jquery/jquery.min.js') }}" defer></script> --}}


    {{-- <link rel="shortcut icon" href="{{asset('assets/ckicon.ico')}}" type="image/x-icon"/> --}}

    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins\fontawesome-free-6.3.0-web\css/all.min.css')}}">
    <link href="{{asset('dist/css/adminlte.css')}}" rel="stylesheet">
    {{-- <link type="text/css" href="{{asset('css/fontawesome.css')}}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
   <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}"> 
   <link rel="stylesheet" href="{{asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
   <link rel="stylesheet" href="{{asset('plugins/pace-progress/themes/blue/pace-theme-flat-top.css')}}">


{{--    <link rel="stylesheet" href="{{asset('plugins/jquery-image-viewer-magnify/css/jquery.magnify.min.css')}}">
   <link rel="stylesheet" href="{{asset('plugins/jquery-image-viewer-magnify/css/magnify-bezelless-theme.css')}}"> --}}

   <link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">
   {{-- <link rel="stylesheet" href="{{asset('dist/css/fontfamily.css')}}"> --}}
   {{-- <link rel="stylesheet" href="{{asset('dist/css/ionicons.min.css')}}"> --}}
   {{-- <link rel="stylesheet" href="{{asset('dist/css/googleapis-font.css')}}"> --}}
   <link rel="stylesheet" href="{{asset('dist/css/select2.min.css')}}">
   <link rel="stylesheet" href="{{asset('dist/css/select2-bootstrap4.min.css')}}">
   <link rel="stylesheet" href="{{asset('dist/css/sweetalert2.min.css')}}">
   {{-- <link rel="stylesheet" href="{{asset('dist/css/simplePagination.css')}}"> --}}
   {{-- <link rel="stylesheet" href="{{asset('assets\css\sideheaderfooter.css')}}"> --}}
   @yield('jsUP') 

   {{-- remove default arrow on select --}}
    <!-- <style type="text/css"> 
      select {
    -webkit-appearance: none;
    -moz-appearance: none;
    text-indent: 1px;
    text-overflow: '';
}
    </style> -->
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed" style="height: auto;">
<div class="wrapper">
    @include('pit.layouts.navbar')
        <div class="content-wrapper" style="min-height: 543px;">
            @yield('content')
        </div>
    
</div>
    

</body>
</html>
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>
{{-- <script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script> --}}
<script src="{{asset('plugins/daterangepicker/moment.min.js')}}"></script>
<script src="{{asset('plugins/jquery-knob/jquery.knob.min.js')}}"></script>

<script src="{{asset('plugins\fontawesome-free-6.3.0-web\js\all.min.js')}}"></script>

<script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>

<script src="{{asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<script src="{{asset('dist/js/adminlte.js')}}"></script>
{{-- <script src="{{asset('dist/js/pages/dashboard.js')}}"></script> --}}
<script src="{{asset('dist/js/demo.js')}}"></script>
<script src="{{asset('dist/js/select2.full.min.js')}}"></script>

{{-- <script src="{{asset('dist/js/jquery.simplePagination.js')}}"></script> --}}
<script src="{{asset('plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('plugins/sweetalert2/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('plugins/pace-progress/pace.min.js')}}"></script>
{{-- <script src="{{asset('plugins/jquery-image-viewer-magnify/js/jquery.magnify.min.js')}}"></script> --}}


@yield('modal')
@yield('js')
<!-- <script>
    $(document).ready(function(){
        
        setInterval(function(){

            // $('.pace').css('display','none !important')
        
            window.paceOptoins = {
                ajax:false,
                restartOnRequestAfter: false,
            }


            // Pace.ignore(function(){
            //   $.ajax({
            //       url: '/finance/salaryrateelevation/reloadcount',
            //       type: 'GET',
            //       dataType: 'json',
            //       success: function(data) {

            //           $('.countsalaryrateelevation').text(data.rateCount)
            //           $('.viewolpaycount').text(data.OLpayCount);
            //       },
            //   });
            // });
        }, 30000);
    })
</script> -->


{{-- ver 06.27.2020.0922 --}}
{{-- changelog:  - Fix Tuition Entry for College; --}}
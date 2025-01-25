<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head>
    <title>@yield("title") | Chat App</title>
    <meta charset="utf-8"/>
    <meta name="description" content="@yield("description")"/>
    <meta name="keywords" content="@yield("keywords")"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta property="og:locale" content="tr_TR"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title" content=""/>
    <meta property="og:url" content=""/>
    <meta property="og:site_name" content=""/>
    <link rel="shortcut icon" href=""/>

    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700"/>
    <!--end::Fonts-->

    <!--begin::Style-->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <!--end::Style-->
    @yield("style")
</head>
<!--end::Head-->
<!--begin::Body-->
<body>
<!--begin::App-->
@include("static.header")
<div class="container pb-2 pt-4">
    @yield("master")
</div>
<!--end::App-->
<!--begin::Javascript-->
<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/js/popper.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@yield("script")
<!--end::Javascript-->
</body>
<!--end::Body-->
</html>

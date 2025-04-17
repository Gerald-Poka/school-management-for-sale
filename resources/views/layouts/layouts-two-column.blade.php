<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="twocolumn" data-layout-style="default" data-layout-position="fixed" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-layout-width="fluid">

<head>
    <meta charset="utf-8" />
    <title>@yield('title') | School Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="School Management System" name="description" />
    <meta content="Gerald" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.ico')}}">
    @include('layouts.head-css')
</head>

@section('body')
    @include('layouts.body')
@show

<!-- Begin page -->
<div id="layout-wrapper">
    @include('layouts.topbar')
    
    @auth
        @switch(auth()->user()->role)
            @case('admin')
                @include('admin.sidebar.sidebar')
                @break
            @case('teacher')
                @include('teacher.sidebar.sidebar')
                @break
            @default
                @include('student.sidebar.sidebar')
        @endswitch
    @endauth

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
            <!-- Start content -->
            <div class="container-fluid">
                @yield('content')
            </div> <!-- content -->
        </div>
        @include('layouts.footer')
    </div>
    <!-- ============================================================== -->
    <!-- End Right content here -->
    <!-- ============================================================== -->
</div>
<!-- END wrapper -->

<!-- Right Sidebar -->
@include('layouts.customizer')
<!-- END Right Sidebar -->

@include('layouts.vendor-scripts')
</body>
</html>

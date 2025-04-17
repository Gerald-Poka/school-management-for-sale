@extends('layouts.master-without-nav')
@section('title')
    School
@endsection
@section('css')
    <link href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('body')
    <body data-bs-spy="scroll" data-bs-target="#navbar-example">
@endsection
@section('content')
    <div class="layout-wrapper landing">
        @include('website.each.head')
        @include('website.each.home')
        @include('website.each.services')
        @include('website.each.features')
        @include('website.each.contact')
        @include('website.each.footer')
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('build/libs/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/landing.init.js') }}"></script>
@endsection

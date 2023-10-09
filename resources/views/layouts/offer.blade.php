@extends('layouts.master-dc')

@section('content')

    {{-- Top Content --}}
    @include('partials.offer-top')
    {{-- / Top Content --}}

    {{-- Product Ofer Content --}}
    @yield('product-content')
    {{-- / Product ofer Content --}}

    {{-- Tabs Block --}}
    @include('partials.tabs-block')
    {{-- / Tabs Block --}}

    {{-- Three Blocks --}}
    @include('partials.three-blocks')
    {{-- / Three Blocks --}}

    {{-- Brands --}}
    @include('partials.brands')
    {{-- / Brands --}}

@endsection
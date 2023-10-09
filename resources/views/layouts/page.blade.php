@extends('layouts.master')

@section('content')

    <section class="page-top-part">
        <div class="container">
            @yield('breadcrumbs')

            <div class="page-title-block">
                <h2 class="page-title"><span class="c-yellow">@yield('page-title')</span></h2>
                <h3 class="page-short-desc">@yield('page-description')</h3>
            </div>

        </div>
    </section>

    @yield('page-content')

@endsection
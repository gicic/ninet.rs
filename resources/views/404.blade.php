@extends('layouts.master-for-404')

@section('meta')
    <meta name="robots" content="noindex">
@endsection
@section('content')
    <section class="bp-purchased-section">
        <div class="container">
            <div class="row" style="margin-top: 50px">
                <div class="col-md-7">
                    <div class="text">
                        @if(App::getLocale() === 'sr-Latn')
                            <p class="text1 text">Došlo je do greške, tražena stranica nije pronadjena.</p>
                        @else
                            <p class="text1 text">An error occurred, the requested page was not found.</p>
                        @endif
                            <div class="text-right mt-3 mb-3 mr-4">
                                <a href="{{ route('home') }}" class="btn btn-outline-primary pull-left">{{ __('main.back_to_home') }}</a>
                            </div>
                    </div>

                </div>
                <div class="col-md-5">
                    <div class="image">
                        <img src="{{ url('assets/images/purchased.png') }}" alt=""/>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@extends('layouts.master')

@section('meta')
    <meta name="robots" content="noindex">
@endsection

@section('content')
    <section class="bp-purchased-section">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <div class="text">
                        @if($status)
                            <p class="text1 text-uppercase">{{ 'Uspešno ste verifikovali svoju e-mail adresu' . ' ' . $email }}</p>
                        @else
                            <p class="text1 text-uppercase">{{ 'E-mail adresa nije verifikovana.' }}</p>
                        @endif
                    </div>
                </div>
                @if($status)
                    <div class="col-md-5">
                        <div class="image">
                            <img src="{{ url('assets/images/purchased.png') }}" alt=""/>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
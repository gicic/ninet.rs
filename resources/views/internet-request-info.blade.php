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
                        <p class="text1 text-uppercase">Poštovani <strong>{{ $internet->ime . ' ' . $internet->prezime }}</strong></p>
                        <p class="text2">Uspešno ste se prijavili za besplatno probno merenje za paket <strong>{{ $internet->proizvod->naziv_proizvoda ?? '' }}</strong> </p>
                        <p class="text3">
                            Uskoro će Vas kontaktirati neko od naših administratora. <br>
                            Hvala Vam na ukazanom poverenju.
                        </p>
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
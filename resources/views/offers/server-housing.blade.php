@extends('layouts.offer')

{{--{{ dd($offer) }}--}}

@section('page-title')
    {!! $offer->titleHtml !!}
@endsection

@section('page-description')
    {!! $offer->description !!}
@endsection
{{--{{ dd(Cart::content()) }}--}}
@section('product-content')

                <!-- Tab panes -->
<div class="tab-content">
    <div role="tabpanel" class="package"  id="">
        <strong>{{App::getLocale() === 'sr-Latn' ? 'Za sve informacije nas kontaktirajte na' : 'Please contact us by email'}} </strong>
        <a href="mailto:helpdesk@webglobe.rs" target="_blank"><span class="text-primary">helpdesk@webglobe.rs</span></a>
    </div>
</div>

@endsection
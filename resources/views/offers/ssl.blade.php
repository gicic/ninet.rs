@extends('layouts.offer')

@section('page-title')
     {!! $offer->titleHtml !!}
@endsection

@section('page-description')
    {!! $offer->description !!}
@endsection

@section('product-content')

    <section class="ssl-page">
        <div class="container">

            <div class="tab-t4-holder">

                <div class="row">

                    <!-- Nav tabs -->
                    <div class="col-sm-4">
                        <ul class="c-tab tab-t4" role="tablist">
                            @foreach($offer->category->productLines as $line)
                                @if(count($line->products))
                                    <li><a href="#ssl-tab{{ $loop->iteration }}" aria-controls="ssl-tab1" role="tab" data-toggle="tab">{{ $line->name }}</a></li>
                                @endif
                            @endforeach
                            <li>
                                <a href="#ssl-tab{{ count($offer->category->productLines) + 1 }}" aria-controls="ssl-tab1" role="tab" data-toggle="tab">
                                    <span class="invisible-on-smallest">Webglobe</span> {{ __('main.advice') }}
                                    <span class="additional-text invisible-on-smallest">{{ __('main.ssl_question_text') }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Tab panes -->
                    <div class="col-sm-8">
                        <div class="tab-content">

                            @foreach($offer->category->productLines as $line)
                                @if(count($line->products))
                                    <div role="tabpanel" class="tab-pane"  id="ssl-tab{{ $loop->iteration }}">
                                        @foreach($line->products as $product)
                                            @if($product->active && $product->public)
                                                <div class="ssl-certificate">
                                                    <div class="pos-helper">
                                                        <div class="price text-center" style="line-break: normal; font-size: {{ App::getLocale() === 'sr-Latn' ? '1.1rem' : '1.6rem' }}"><span><strong>{{ number_format($product->getPrice(), 0, ',', '.') }}</strong> {!! App::getLocale() === 'sr-Latn' ? ' RSD' : '&euro;' !!}</span></div>
                                                        <div class="about">
                                                            <h3>{{ $product->name }}</h3>
                                                            @php
                                                                switch($product->sslSecurityLevel->validation_type) {
                                                                    case 'DV': $validity = __('ssl-wizard.valid_for_domain'); break;
                                                                    case 'OV': $validity = __('ssl-wizard.valid_for_organization'); break;
                                                                    case 'EV': $validity = __('ssl-wizard.extended_validation'); break;
                                                                    default: null;
                                                                }
                                                            @endphp
                                                            <ul class="check-list">
                                                                <li>{{ $validity }}</li>
                                                                <li><strong>{{ __('ssl-wizard.server_licencing') }}:</strong> {{ __('ssl-wizard.unlimited') }}</li>
                                                                <li><strong>{{ __('ssl-wizard.domains_number') }}:</strong> {{ __('ssl-wizard.domain_' . $product->sslSecurityLevel->domains_number) }}</li>
                                                                @if($product->sslSecurityLevel->wildcard)
                                                                    <li><strong>WildCard</strong></li>
                                                                @endif
                                                                @if($product->sslSecurityLevel->validation_type === 'EV')
                                                                    <li><strong>Green Address Bar</strong></li>
                                                                @endif
                                                                @if(in_array($product->sslSecuritylevel->validation_type, ['OV', 'EV']))
                                                                    <li><strong>Business validated</strong></li>
                                                                @endif
                                                                <li><strong>Mobile friendly</strong></li>
                                                            </ul>
                                                        </div>
                                                        <div class="buttons">
                                                            <a href="{{ route('cart.ssl', ['productId' => Hashids::encode($product->id)]) }}" class="btn-t1">{{ __('main.add_to_cart') }}<span class="fa fa-cart-arrow-down"></span></a>
{{--                                                            <div style="margin-top: 10px">--}}
{{--                                                                <h6>{{ App::getLocale() === 'sr-Latn' ? 'Samo za postojeće korisnike' : 'Only for existing customers' }}</h6>--}}
{{--                                                            </div>--}}
{{--                                                            <a href="https://webglobe.rs/" class="add-to-wishlist"><span style="color:#FFC20E">{{ App::getLocale() === 'sr-Latn' ? 'Ukoliko želite da postanete novi korisnik kliknite OVDE' : 'If you want to become a new customer click HERE' }}</span></a>--}}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            @endforeach

                            <div role="tabpanel" class="tab-pane"  id="ssl-tab{{ count($offer->category->productLines) + 1 }}">
                                <div class="advice-holder">

                                    <div class="advice-step1">
                                        <div class="question-holder">
                                            <p class="question">1. {{ __('ssl-wizard.question_1') }}</p>
                                            <div class="radio-box" data-radio="block">
                                                <div>
                                                    <input type="radio" name="domain_type_question" value="DV" id="domain_type_question_1" checked>
                                                    <label class="active" for="domain_type_question_1"><span class="fw-bold">{{ __('ssl-wizard.question_1_answer_1-1') }}</span> – {{ __('ssl-wizard.question_1_answer_1-2') }}</label>
                                                </div>
                                                <div>
                                                    <input type="radio" name="domain_type_question" value="OV" id="domain_type_question_2">
                                                    <label for="domain_type_question_2"><span class="fw-bold">{{ __('ssl-wizard.question_1_answer_2-1') }}</span> – {{ __('ssl-wizard.question_1_answer_2-2') }}</label>
                                                </div>
                                                <div>
                                                    <input type="radio" name="domain_type_question" value="EV" id="domain_type_question_3">
                                                    <label for="domain_type_question_3"><span class="fw-bold">{{ __('ssl-wizard.question_1_answer_3-1') }}</span> – {{ __('ssl-wizard.question_1_answer_3-2') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="buttons-holder">
                                            <div class="row">
                                                <div class="col-lg-6">

                                                </div>
                                                <div class="col-lg-6">
                                                    <a href="javascript:void(0)" data-next="trigger" data-next-step="2" class="btn-t3 btn-next text-upper">{{ __('ssl-wizard.next_question') }} <span class="fa fa-arrow-circle-o-right"></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="advice-step2" style="display: none">
                                        <div class="question-holder">
                                            <p class="question">2. {{ __('ssl-wizard.question_2') }}</p>
                                            <div class="radio-box" data-radio="block">
                                                <div>
                                                    <input type="radio" name="domains_number_question" value="single" id="domains_number_question_1" checked>
                                                    <label class="active" for="domains_number_question_1"><span class="fw-bold">{{ __('ssl-wizard.question_2_answer_1-1') }}</span> {{ __('ssl-wizard.question_2_answer_1-2') }}</label>
                                                </div>
                                                <div>
                                                    <input type="radio" name="domains_number_question" value="multiple" id="domains_number_question_3">
                                                    <label for="domains_number_question_3"><span class="fw-bold">{{ __('ssl-wizard.question_2_answer_3-1') }}</span> {{ __('ssl-wizard.question_2_answer_3-2') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="buttons-holder">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <a href="javascript:void(0)" data-previous="trigger" data-previous-step="1" class="btn-t3 btn-prev left text-upper">{{ __('ssl-wizard.back') }} <span class="fa fa-arrow-circle-o-left"></span></a>
                                                </div>
                                                <div class="col-lg-6">
                                                    <a href="javascript:void(0)" data-next="trigger" data-next-step="3" class="btn-t3 btn-next">{{ __('ssl-wizard.next_question') }} <span class="fa fa-arrow-circle-o-right"></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="advice-step3" style="display: none;">
                                        <div class="question-holder">
                                            <p class="question">3. {{ __('ssl-wizard.question_3') }}?</p>
                                            <div class="radio-box" data-radio="block">
                                                <div>
                                                    <input type="radio" name="wildcard_question" value="yes" id="wildcard_question_1" checked>
                                                    <label class="active" for="wildcard_question_1"><span class="fw-bold">{{ __('ssl-wizard.question_3_answer_1-1') }}</span>. {{ __('ssl-wizard.question_3_answer_1-2') }}.</label>
                                                </div>
                                                <div>
                                                    <input type="radio" name="wildcard_question" value="no" id="wildcard_question_2">
                                                    <label for="wildcard_question_2"><span class="fw-bold">{{ __('ssl-wizard.question_3_answer_2-1') }}</span> {{ __('ssl-wizard.question_3_answer_2-2') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="buttons-holder">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <a href="javascript:void(0)" data-previous="trigger" data-previous-step="2" class="btn-t3 btn-prev left">{{ __('ssl-wizard.back') }} <span class="fa fa-arrow-circle-o-left"></span></a>
                                                </div>
                                                <div class="col-lg-6">
                                                    <a href="javascript:void(0)" data-next="trigger" data-next-step="finish" class="btn-t3 btn-next">{{ __('ssl-wizard.show_suggestions') }} <span class="fa fa-arrow-circle-o-right"></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="advice-step4" id="advice_result" style="display: none">
                                        <div class="advice">
                                            <p class="block-title">{{ __('ssl-wizard.your_conditions') }}:</p>
                                            <ul class="check-list">
                                                <li id="ssl_condition_1"></li>
                                                <li id="ssl_condition_2"></li>
                                                <li id="ssl_condition_3"></li>
                                            </ul>
                                            <p class="block-title border">{{ __('ssl-wizard.result_text') }}:</p>
                                            <div id="advice-products-holder">

                                            </div>
                                        </div>
                                        <div class="buttons-holder no-top-margin">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <a href="javascript:void(0)" data-previous="trigger" data-previous-step="3" class="btn-t3 btn-prev left">{{ __('main.change') }} <span class="fa fa-arrow-circle-o-left"></span></a>
                                                </div>
                                                <div class="col-lg-6">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script>
        var _ssl_products_url = '{{ route('offer.ssl-wizard-products') }}';
    </script>
    <script src="{{ url(mix('js/ssl-offer.js')) }}"></script>
@endsection
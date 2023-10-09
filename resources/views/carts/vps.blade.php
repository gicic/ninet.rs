@extends('layouts.master-dc')

@section('meta')
    <meta name="robots" content="noindex">
@endsection

@section('content')
    <section class="page-top-part">
        <div class="container">

            <div class="page-title-block">
                <ul class="buying-process-menu">
                    <li class="active text-uppercase"><a href="javascript:void(0)">{{ __('main.adding_product_to_cart') }} </a></li>
                </ul>
            </div>

        </div>
    </section>

    <section>
        <div class="container">
            <div class="tab-t5-holder">
                <!-- Nav tabs -->
                <ul class="tab-t5">
                    <li class="active">
                        <a>
                            vps
                        </a>
                    </li>
                    {{--<li>--}}
                        {{--<a href="javascript:void(0)">--}}
                            {{--ssl sertifikati--}}
                        {{--</a>--}}
                    {{--</li>--}}
                </ul>

            <!-- Tab panes -->
                <div class="tab-content">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="block-t1">
                                <div class="block-title">
                                    {{ __('main.product_characteristics') }}
                                </div>
                                <div class="block-content">
                                    <ul class="vps-characteristics">
                                        @foreach($product->productCharacteristics as $characteristic)
                                            <li><span>{{ $characteristic->name }}: {{ $characteristic->description }}</span></li>
                                        @endforeach
                                        @if(!empty($periods))
                                            <li>
                                                <span>{{ __('main.number_of_months') }}</span>
                                                <div>
                                                    <div class="select-holder">
                                                        <select name="order_period" id="order_period">
                                                            @foreach($periods as $period)
                                                                <option value="{{ $period->id }}">{{ $period->period_text }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </li>
                                        @endif
                                        <li>
                                            <span>OS</span>
                                            <div class="select-holder">
                                                <select name="operating_system" id="operating_system">
                                                    <option value="">--</option>
                                                    @if(!empty($solusTemplates))
                                                        @foreach($solusTemplates as $template)
                                                            @if($product->productLine->code == 'vps-windows-ssd')
                                                            @if($template->category == 'windows')
                                                                    <option value="{{ $template->filename}}">{{ $template->name }}</option>
                                                                @endif
                                                            @elseif($product->productLine->code == 'ssd-vps' || $product->productLine->code == 'ssd-vps-cpanel')
                                                                @if($template->category == 'linux')
                                                                    <option value="{{ $template->filename}}">{{ $template->name }}</option>
                                                                @endif
                                                            @else
                                                                <option value="{{ $template->filename}}">{{ $template->name }}</option>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            @include('carts.partials.hostname')

                            @if(count($product->subproducts))
                                @include('carts.partials.subproducts')
                            @endif

                            {{--<div class="vps-add-certificate">--}}
                                {{--<span>Dodaj SSD sertifikat</span>--}}
                                {{--<label for="add-certificate">DODAJ SSD SERIFIKAT</label>--}}
                                {{--<input type="file" id="add-certificate"/>--}}
                            {{--</div>--}}

                            <div style="display: block;" class="text-danger">
                                @if($errors->has('license'))
                                    @foreach($errors->get('license') as $error)
                                        <p>{{ $error }}</p>
                                    @endforeach
                                @endif
                            </div>

                            <div class="vps-border-divider"></div>

                            <a href="{{ route('purchase.index') }}" class="btn-t1 margin-t full-width center">{{ __('main.make_order') }} <span class="fa fa-cart-arrow-down"></span></a>

                        </div>

                        <div class="col-lg-4 sticky">
                            <div class="sidebar-cart" data-cart="holder"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script>
        var _current_cart_item_id = '{{ $cartItem->rowId }}';
        var _additional_add_url  = '{{ route('cart.add-additional') }}';
    </script>
    <script src="{{ url(mix('/js/counters.js')) }}"></script>
@endsection
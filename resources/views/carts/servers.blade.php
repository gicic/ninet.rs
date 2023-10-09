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
                            server
                        </a>
                    </li>
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
                                            <div>
                                                <div class="select-holder">
                                                    <select name="server_operating_system" id="server_operating_system">
                                                        <option value="">--</option>
                                                        <option value="no_operating_system">{{ __('main.no_operating_system') }}</option>

                                                         @if( ! empty($operatingSystems))
                                                            @foreach($operatingSystems as $system)
                                                                <option value="{{ $system->id }}" {{ !empty($cartItem->options['operating_system_id']) && $system->id == $cartItem->options['operating_system_id'] ? 'selected' : '' }}>{{ $system->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <span class='error-message' id='os'></span>
                            </div>

                            @include('carts.partials.hostname')

                            @if(count($product->subproducts))
                                @include('carts.partials.subproducts')
                            @endif

                            <div class="vps-border-divider"></div>
                            @if($product->productLine->code == 'server-housing')
                                <a href="{{ route('purchase.purchase-int') }}" class="btn-t1 margin-t full-width center" id="host_name" type="submit">{{ __('main.make_order') }} <span class="fa fa-cart-arrow-down"></span></a>
                            @else
                                <a href="{{ route('purchase.index') }}" class="btn-t1 margin-t full-width center" id="host_name" type="submit">{{ __('main.make_order') }} <span class="fa fa-cart-arrow-down"></span></a>
                            @endif
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

    <script>
        function producePrompt(message, promptLocation, color) {

            document.getElementById(promptLocation).innerHTML = message;
            document.getElementById(promptLocation).style.color = color;
        }
        function jsHide(id) {
            document.getElementById(id).style.display = 'none';
        }
        $("#host_name").click(function(){
            if ($("#server_hostname").val() == "") {
                producePrompt('Ovo polje je obavezno', 'host-name', 'red');
                setTimeout(function () {
                    jsHide('host-name');
                }, 4000);
                return false;
            }
            else if($("#server_operating_system").val()=='')
            {
                producePrompt('Ovo polje je obavezno', 'os', 'red');
                setTimeout(function () {
                    jsHide('os');
                }, 4000);
                return false;
            }
            else{
                return true;
            }
        });
    </script>
@endsection
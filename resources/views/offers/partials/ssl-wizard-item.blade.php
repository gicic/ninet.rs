@if(!empty($products) && count($products))
    @foreach($products as $product)
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
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="ssl-certificate">
        <h3>{{ __('ssl-wizard.no_products_found') }}</h3>
    </div>
@endif
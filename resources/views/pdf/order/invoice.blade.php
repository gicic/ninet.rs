<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>

    <style>
        body {
            font-family: "DejaVu Sans", Arial, sans-serif;
        }
        .pay-button{
            background-color: #43c8fa;
            width: 250px!important;
            border-radius: 50%!important;
            color: white!important;
            text-decoration: none;
            text-align: center;
            padding-bottom: 3px;
        }
    </style>
    <link rel="stylesheet" href="{{ resource_path('/views/pdf/order/theme.css') }}">
</head>
<body>

    <div id="container">
        <header id="header">
            <div id="logo">
                @php
                $file = Storage::disk('public')->get('webglobe.png');
                $logo = 'data:image/png;base64,' . base64_encode($file);
                @endphp
                <img src="{{ $logo }}" alt="Webglobe Company">
            </div>

            <div id="header-right">
                <h1>{{ __('company.webglobe') }}</h1>
                <h4>{{ __('main.order') }}: {{ $order->order_number }}</h4>
                <h6>{{ __('main.order_date') }}: {{ $order->created_at->format('Y-m-d') }}</h6>
            </div>

            <div class="clearfix"></div>
        </header>

        @php
            $contact = $order->customer->contacts->where('contact_type_id', 1)->first();
            $currency = $order->currency->code;
            $customer = $order->customer;
        @endphp

        <div id="info-container">
            <div id="user-info">
                <h4>{{ $contact->first_name }} {{ $contact->last_name }}</h4>
                <p class="text-faded">{{ $contact->address }}</p>
                @if($contact->is_legal_entity)
                    <p class="text-faded">{{ $contact->company_name }}</p>
                @endif
                <p class="text-faded">{{ $contact->postal_code }}, {{ $contact->city }}</p>
                <p class="text-faded">{{ $contact->country->name }}</p>
                <p class="text-faded">{{ $contact->phone }}</p>
            </div>
            <div id="company-info">
                <h4>{{ __('company.webglobe') }}</h4>
                <p>{{ __('company.webglobe_address') }}</p>
                <p>{{ __('company.webglobe_postal') }} {{ __('webglobe.city') }}, {{ __('webglobe.country') }}</p>
                <p>Tel {{ __('company.webglobe_phone') }}</p>
                <p>helpdesk@webglobe.rs</p>
            </div>
            <div class="clearfix"></div>
        </div>

        <div id="order-details">
            <table>
                <thead>
                <tr>
                    <th class="text-left">{{ __('main.product') }}</th>
                    <th class="text-left">{{ __('main.unit_price') }}</th>
                    <th class="text-left">{{ __('main.period') }}</th>
                    <th class="text-left">{{ __('main.quantity') }}</th>
                    <th class="text-left">{{ __('main.discount') }}(%)</th>
                    @if(App::getLocale() === 'sr-Latn')
                        <th class="text-left">{{ __('main.tax_base') }}</th>
                        <th class="text-left">PDV ({{ config('general-data.tax') }}%)</th>
                    @endif
                    <th class="text-left">{{ __('main.total') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($order->orderDetails as $detail)
                    <tr>
                        <td class="text-left">{{ $detail->description }}</td>
                        <td class="text-left">{{ \App\CommonFunctions::priceFormat($detail->getBoundModel()->{App::getLocale() === 'sr-Latn' ? 'price_resident' : 'price_foreign'}) }}</td>
                        <td class="text-left">{{ $detail->period_months }} m</td>
                        <td class="text-left">{{ $detail->quantity }}</td>
                        <td class="text-left">{{ $detail->discount_percentage ?? '0' }}</td>
                        @if(App::getLocale() === 'sr-Latn')
                            <td class="text-left">{{ \App\CommonFunctions::priceFormat($detail->taxBase()) }}</td>
                            <td class="text-left">{{ \App\CommonFunctions::priceFormat($detail->taxAmount()) }}</td>
                        @endif
                        <td class="text-bolder text-left">{{ \App\CommonFunctions::priceFormat($detail->totalPrice()) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="5" class="text-bolder text-uppercase">{{ __('main.total') }}</td>
                    @if(App::getLocale() === 'sr-Latn')
                        <td class="text-left">{{ \App\CommonFunctions::priceFormat($order->taxBase()) }} {{ $currency }}</td>
                        <td class="text-left">{{ \App\CommonFunctions::priceFormat($order->taxAmount()) }} {{ $currency }}</td>
                    @endif
                    <td class="text-bolder">{{ \App\CommonFunctions::priceFormat($order->totalPrice()) }} {{ $currency }}</td>
                </tr>
                </tbody>
            </table>
        </div>

        @php
            $url = 'https://www2.ninet.rs/raiffeisen/' . $order->id . '/online_payments';
            $euro = \App\Models\Currency::where('code', 'EUR')->first();
                $rsd = \App\Models\Currency::where('code', 'RSD')->first();

                $exchangeRate = \App\Models\ExchangeRate::where('currency_from', $euro->id)
                    ->where('currency_to', $rsd->id)
                    ->orderBy('currency_date', 'desc')
                    ->first()['rate'];
        @endphp
        <hr>
        @if(App::getLocale() === 'sr-Latn')
            <a href="{{ $url }}" class="pull-left btn pay-button">Platite karticom</a><br><br>
            <small class="pull-left">Plaćanje u banci ili pošti, <b>tekući računi:</b><br>
                160-6000001455661-06 Banca Intesa <br>
                265-1110310005889-83 Raiffeisen banka <br>
                obavezno upisati <b>poziv na broj</b> {{ $order->order_number }}</small>
            <div class="clearfix"></div>
            <hr>
        @endif

        <div id="total-container" class="pull-right">
            <div id="total-info" class="pull-left">
                <p>{{ __('main.total_amount') }}:</p>
                <p>{{ __('main.total_discount') }}:</p>
                @if(App::getLocale() === 'sr-Latn')
                    <p>Ukupna osnovica za PDV:</p>
                    <p>Ukupno PDV:</p>
                @endif
                <p class="text-bolder text-upper">{{ __('main.total_amount') }}</p>
            </div>
            <div id="total-values" class="pull-right">
                <p>{{ \App\CommonFunctions::priceFormat($order->originalAmount()) }} {{ $currency }}</p>
                <p>{{ \App\CommonFunctions::priceFormat($order->discountAmount()) }} {{ $currency }}</p>
                @if(App::getLocale() === 'sr-Latn')
                    <p>{{ \App\CommonFunctions::priceFormat($order->taxBase()) }} {{ $currency }}</p>
                    <p>{{ \App\CommonFunctions::priceFormat($order->taxAmount()) }} {{ $currency }}</p>
                @endif
                <p class="text-bolder">{{ \App\CommonFunctions::priceFormat($order->totalPrice()) }} {{ $currency }}</p>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>

        @if(App::getLocale() !== 'sr-Latn')
            <hr>
            <table>
                <tbody>
                <tr>
                    <td colspan="3">
                        <span class="text-bolder text-upper">
                            Payment instructions
                        </span>
                    </td>
                </tr>
                    <tr>
                        <td><strong>WIRE TRANSFER:</strong></td>
                        <td>56: Intermediary bank:</td>
                        <td>
                            RZBAATWW
                            <br>
                            Raiffeisen Bank International AG
                            <br>
                            Vienna, Austria
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>57: Account with institution:</td>
                        <td>
                            DBDBRSBG
                            <br>
                            Raiffeisen banka ad Beograd
                            <br>
                            BEOGRAD, REPUBLIKA SRBIJA
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>59: Beneficiary customer:</td>
                        <td>
                            /RS35265100000038913638
                            <br>
                            WEBGLOBE D.O.O.
                            <br>
                            TRG 14. OKTOBAR 2/2/1
                            <br>
                            NIŠ-MEDIJANA, Serbia
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <span class="text-danger text-bolder">
                                Important notice for payments made by wire transfer: we have to receive correct amount after any bank charges have been deducted (option: OUR).
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>

            <span class="pull-right">Webglobe PayPal e-mail address: paypal@webglobe.rs</span>
            <div class="clearfix"></div>
            <span class="pull-right"><a href="{{ $order->get2COUrl() }}">Pay online via 2CO payment link</a></span>
            <div class="clearfix"></div>
            <hr>
        @endif

        <div class="clearfix"></div>

        <div id="payment-instructions">
            <p>

            </p>
        </div>
    </div>

</body>
</html>
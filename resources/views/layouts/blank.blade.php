<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="default-style">
<head>

    @if(env('APP_ENV') === 'production')
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','GTM-TW3RG77');</script>
        <!-- End Google Tag Manager -->
    @endif
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=0"/>

    <title>@yield('title')</title>

    @yield('meta')

    <meta name="author" content="name">
    <meta name="description" content="description here">
    <meta name="keywords" content="keywords,here">

    <link rel="shortcut icon" href="{{ url('favicon.ico') }}" type="image/vnd.microsoft.icon">

    <link rel="stylesheet" href="{{ url('/assets/css/bootstrap_scss/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ url('/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ url(mix('/css/app.css')) }}">
    <link rel="stylesheet" href="{{ url(mix('/css/cookieConsent.css')) }}">

    @yield('styles')
    @yield('head-scripts')
</head>
<body>
@if(env('APP_ENV') === 'production')
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TW3RG77"
                      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
@endif

@yield('content')

<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&amp;subset=latin-ext" rel="stylesheet">
<script src="{{ url('/assets/bower_components/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ url('/assets/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ url('/assets/js/scripts.js') }}"></script>
<script src="{{ url(mix('/js/shopping-cart.js')) }}"></script>
<script src="{{ url(mix('/js/app.js')) }}"></script>

<script>
    var _token = '{{ csrf_token() }}';
    var _locale = '{{ App::getLocale() }}';
    var _shopcart_remove_url = '{{ route('cart.remove') }}';
    var _get_cart_view_url = '{{ route('cart.get-view') }}';
    var _get_side_cart_view_url = '{{ route('cart.get-side-view') }}';
    var _shopcart_update_url = '{{ route('cart.update') }}';
</script>

@yield('scripts')

</body>
</html>
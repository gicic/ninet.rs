@component('mail::message-dc')

@if(App::getLocale() === 'sr-Latn')
# Poštovani,
Predračun za izvršenu narudžbinu možete preuzeti iz priloga
@else
#Dear,
You can download pre-invoice for Your order from attachment.
@endif

@endcomponent
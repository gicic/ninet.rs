@component('mail::message')
@if(App::getLocale() === 'sr-Latn')
# Poštovani {{ $mainContact->first_name }} {{ $mainContact->last_name }},

Kreiran je Vaš korisnički nalog za [MojNinet portal](https://cp.ninet.rs)

Lozinku preuzmite preko navedenog jednokratnog linka.

@component('mail::panel')
**Korisničko ime:** {{ $customer->email }} <br>
**Lozinka:** {{ $otsUrl }}
@endcomponent

Molimo Vas da promenite Vašu lozinku prilikom prve posete [MojWebglobe portalu](https://cp.ninet.rs)

Ovu pristupne parametre možete koristiti za pristup [MojNinet portalu](https://cp.ninet.rs) kao i za kreiranje narudžbina na https://ninet.rs

Na [MojWebglobe portalu](https://cp.ninet.rs) možete videti svoje trenutne narudžbine i usluge, menjati svoje podatke i drugo.

@else
# Dear {{ $mainContact->first_name }} {{ $mainContact->last_name }},

Your [MyWebglobe portal](https://cp.ninet.rs) account has been successfully created

You can get Your password from the following one time URL.

@component('mail::panel')
**Username:** {{ $customer->email }}
**Password:** {{ $otsUrl }}
@endcomponent

Please change Your password on Your first visit to [MyWebglobet portal](https://cp.ninet.rs)

You can use these parameters to access [MyWebglobe portal](https://cp.ninet.rs) as well as make new orders at https://ninet.rs

At [MyWebglobe portal](https://cp.ninet.rs) You can view Your current orders and services, change Your information and more.

@endif
@endcomponent
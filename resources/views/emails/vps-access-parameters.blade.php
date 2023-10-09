@component('mail::message-dc')
@if(App::getLocale() === 'sr-Latn')
# Poštovani,

PROČITAJTE OVAJ EMAIL U POTPUNOSTI.

VPS koji ste naručili je sada podešen i operativan.

Molimo da pre bilo kakve akcije pročitate ovaj mail u potpunosti kao i naše [uputstvo za slanje lozinki](https://www.ninet.rs/support/Knowledgebase/Article/View/44/6/procedura-za-slanje-lozinke)
@else
# Dear,

PLEASE READ THE WHOLE EMAIL.

The VPS You have ordered is now set and operational.

Before any action, read this email completely as well as our [instructions for sending passwords](https://www.ninet.rs/support/Knowledgebase/Article/View/44/6/procedura-za-slanje-lozinke)
@endif

@component('mail::panel')
@if(App::getLocale() === 'sr-Latn')
Pristup SolusVM kontrol panelu odakle možete reinstalirati, restartovati, pratiti statistike... VPS servera:
@else
SolusVM Control Panel access parameters:
@endif
<br>
**URL:** [http://solus.ninet.rs:5353](http://solus.ninet.rs:5353) <br>
**Username:** {{ $mailData['clientUserName'] }} <br>
@if($mailData['clientIsNew'])
**Password:** {{ $mailData['clientPasswordUrl'] }}
@endif

@if(App::getLocale() === 'sr-Latn')
SSH pristup serveru
@else
SSH server access
@endif

**Main IP (host):** {{ $mailData['vserverIp'] }} <br>
**Port:** 22 <br>
**Username:** root <br>
**Password:** {{ $mailData['vserverPasswordUrl'] }}
@endcomponent

U našoj bazi znanja možete naći i druge korisne savete:
@component('mail::button', ['url' => 'https://www.ninet.rs/support/Knowledgebase/List/Index/1/vps---virtualni-privatni-serveri'])
    Baza znanja
@endcomponent

Za sva dodatna pitanja stojimo vam na raspolaganju.

@endcomponent
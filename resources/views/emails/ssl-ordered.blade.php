@component('mail::message-dc')

# SSL sertifikat je naručen

**Order number:** {{ $mailData['orderNumber'] }} <br>
**Proizvod:** {{ $mailData['ssl'] }} <br>
**Domen:** {{ $mailData['domain'] }} <br>
**E-mail za potvrdu:** {{ $mailData['confirmation_email'] }} <br>
**Tip serverske platforme:** {{ $mailData['serverPlatformType'] }} <br>

**CSR kod:** <br>

<code markdown="1" style="font-size: 0.8em !important;">{!! nl2br($mailData['csrCode']) !!}</code>

@endcomponent
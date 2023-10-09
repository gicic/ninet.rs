@component('mail::message-dc')

**Ime:** {{ $data['name'] ?? '' }} <br>
**Firma:** {{ $data['company'] ?? '' }} <br>
**E-mail:** {{ $data['email'] ?? '' }} <br>
**Telefon:** {{ $data['phone'] ?? '' }} <br>

@component('mail::panel')
**Naslov:** {{ $data['subject'] ?? '' }} <br>

**Poruka:** {{ $data['message'] ?? '' }} <br>
@endcomponent

@endcomponent
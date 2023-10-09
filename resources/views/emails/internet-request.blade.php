@component('mail::message')

**Ime: ** {{ $internet->ime }} <br>
**Prezime: ** {{ $internet->prezime }} <br>
**Kompanija: ** {{ $internet->naziv_kompanije }} <br>
**Adresa: ** {{ $internet->adresa_korisnika }} <br>
**Mesto: ** {{ $internet->mesto }} <br>
**Telefon: ** {{ $internet->telefon_1 }} <br>
**Mobilni: ** {{ $internet->mobilni_1 }} <br>
**E-mail adresa: ** {{ $internet->mail }} <br>
**Izbor promocije: ** {{ $additionalData['choice'] ?? ''}} <br>
**Tip/proizvodjac wireless uređaja ili PCI wireless kartice: ** {{ $additionalData['card_type'] ?? '' }} <br>
**MAC adresa wireless uređaja ako koristite access point: ** {{ $additionalData['mac_ap'] ?? '' }} <br>
**MAC adresa LAN kartice u računaru na koji je uređaj uključen: ** {{ $additionalData['mac_lan'] ?? '' }} <br>
**MAC adresa PCI wireless kartice ako koristite PCI Wireless karticu: ** {{ $additionalData['mac_card'] ?? '' }} <br>
**SSID nase bazne stanice koju najbolje "vidite" pri skeniranju mreža: ** {{ $additionalData['ssid'] ?? '' }} <br>
**Signal stanice ninetxx: ** {{ $additionalData['signal'] ?? '' }} <br>
**Komentar: ** {{ $internet->komentar ?? '' }} <br>
**Vreme slanja poruke: ** {{ $internet->vreme_zahtev }} <br>
**IP adresa: ** {{ $additionalData['ip'] }} <br>

@endcomponent
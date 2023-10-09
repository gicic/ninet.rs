@component('mail::message-dc')
@if(App::getLocale() === 'sr-Latn')
# Poštovani,

PROČITAJTE OVAJ EMAIL U POTPUNOSTI.

Kreiran je {{ $mailData['package'] }} nalog na našim serverima. <br>

@if(!$mailData['existingDomain'])
Kako bi domen bio usmeren ka ovom hosting nalogu potrebno je postaviti sledeće DNS-ove <br>
ns1.hostingweb.rs - 185.96.210.11 <br>
ns2.hostingweb.rs - 176.104.106.107 <br>
ns3.hostingweb.rs - 176.104.107.223 <br>
@endif

Pre nego što probate da pristupite serveru, molimo da pročitate ovaj mail u potpunosti i link ka uputstvu za preuzimanje lozinke: <br>
https://www.ninet.rs/support/Knowledgebase/Article/View/44/6/procedura-za-slanje-lozinke <br><br>

@else
# Dear,

PLEASE READ THE WHOLE EMAIL.

{{ $mailData['package'] }} has been created on our servers. <br>

@if(!$mailData['existingDomain'])
For the domain to be redirected to this hosting account, You have to set the following DNS-s: <br>
ns1.hostingweb.rs - 185.96.210.11 <br>
ns2.hostingweb.rs - 176.104.106.107 <br>
ns3.hostingweb.rs - 176.104.107.223 <br>
@endif

@endif

@component('mail::panel')
@if(App::getLocale() === 'sr-Latn')
cPanel-u možete pristupiti sa adrese: <br>
@else
Your can access cPanel from following address: <br>
@endif
[http://{{ $mailData['serverName'] }}/cpanel] <br>

@if(App::getLocale() === 'sr-Latn')
Nakon propagacije domena možete pristupiti cPanel-u putem adrese: <br>
@else
After domain propagation You can access cPanel via address: <br>
@endif

http://{{ $mailData['domain'] }}/cpanel <br>

**Username:** {{ $mailData['username'] }} <br>
**Password:** {{ $mailData['passwordUrl'] }}
@endcomponent

FTP server: <br>
@if(App::getLocale() === 'sr-Latn')
Privremena adresa: {{ $mailData['ip'] }} <br>
@else
Temporary address: {{ $mailData['ip'] }} <br>
@endif
ftp.{{ $mailData['domain'] }} <br>

@if(App::getLocale() === 'sr-Latn')
Pristup webmail-u: <br>
@else
Webmail access: <br>
@endif

http://{{ $mailData['domain'] }}/webmail <br>

@if(App::getLocale() === 'sr-Latn')
Uputstvo za korišćenje PHP Selector opcije na cPanel-u:
@else
PHP Selector option guide for cPanel:
@endif
https://blog.ninet.rs/php-selector/

@if(App::getLocale() === 'sr-Latn')
Sadržaj prezentacije postavite u folder public_html. <br>
Pre početka rada obrišite index.html stranicu iz public_html direktorijuma. <br>
@else
Place Your presentation files inside of public_html folder. <br>
Before Your begin, delete index.html file from public_html folder. <br>
@endif

@if(App::getLocale() === 'sr-Latn')
** \*\* OBAVEZNA SMTP autentifikacija: WordPress, Joomla i PHP tutorijal: <br>
https://blog.ninet.rs/smtp-overavanje-autenticnosti-wordpres-joomla-i-php-tutorijal \*\* ** <br>
@else
** \*\* REQUIRED SMTP authentication: WordPress, Joomla i PHP tutorijal: <br>
https://blog.ninet.rs/smtp-overavanje-autenticnosti-wordpres-joomla-i-php-tutorijal \*\* ** <br>
@endif

@if(App::getLocale() === 'sr-Latn')
Uputstvo za podešavanje email klijenata možete pogledati u našoj bazi znanja: <br>
@else
Email client setup guide: <br>
@endif
https://www.ninet.rs/support/Knowledgebase/Article/View/11/5/Uputstvo-za-podesavanje-email-klijenta <br><br>

@if(App::getLocale() === 'sr-Latn')
U našoj bazi znanja možete naći i druge korisne savete: <br>
@else
You can find other useful advices in our knowledge base: <br>
@endif

@component('mail::button', ['url' => 'https://www.ninet.rs/support/Knowledgebase/List'])
@if(App::getLocale() === 'sr-Latn')
    Baza znanja
@else
    Knowledge base
@endif
@endcomponent

Za sva dodatna pitanja stojimo vam na raspolaganju.

@endcomponent
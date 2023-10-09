@component('mail::message-dc')
@if(App::getLocale() === 'sr-Latn')
# Poštovani,

Registrovali ste domen **{{ $mailData['domain'] }}**

Uzmite u obzir da vreme propagacije domena na Internetu može trajati do 24 časa. <br>
Promene na domenu (DNS, A, CNAME…) možete vršiti preko Vašeg korisnickog naloga na [https://cp.ninet.rs](https://cp.ninet.rs) ili možete nam se
obratiti na mail support@ninet.rs <br>

Molimo Vas da obavezno izvrsite verifikaciju podataka o domenu (proverite i SPAM/JUNK folder). <br>
Rok za potvrdu je 20 dana. Ako registrant ne postupi prema ovom uputstvu do navedenog roka, domen će biti deaktiviran do davanja potvrde,
odnosno isključen iz globalnog DNS sistema (što za posledicu može da ima da sajt na ovom domenu ne bude vidljiv na Internetu,
kao i da razmena elektronske pošte na ovom domenu prestane da funkcioniše). <br>

Pogledajte našu bazu znanja za dodatne informacije:

@component('mail::button', ['url' => 'https://www.ninet.rs/support/Knowledgebase/List'])
    Baza znanja
@endcomponent

Ukoliko imate dodatnih pitanja slobodno nam se obratite.

@else
# Dear,

Domain **{{ $mailData['domain'] }}** has been registered.

Please verify the registration and the domain name data (check also SPAM/JUNK folder).
Deadline for confirmation is 20 days. If the owner does not act on these instructions by the above deadline the domain will be
deactivated – removed from the global DNS system – until confirmation is received. As a result, the site on this domain may not be
visible online and email sent to and from this domain may stop working.


You can manage the domain name through [https://cp.ninet.rs](https://cp.ninet.rs)  portal

If you have any additional questions or doubts, please don’t hesitate to contact us.

@endif

@endcomponent
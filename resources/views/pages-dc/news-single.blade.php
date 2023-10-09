@extends('layouts.page-dc')

@section('page-title')
  {{ __('main.news') }}
@endsection

@section('page-description')
    {{ __('main.news') }}
@endsection

@section('breadcrumbs')
{{--    {{ Breadcrumbs::render(Route::currentRouteName(), $offer) }}--}}
@endsection

@section('page-content')

    <section class="news-single-article">
        <div class="container">
            <div class="row">

                <div class="col-lg-8">
                    <article class="news-article">
                        <div class="content">
                            <header>
                                <h2  class="article-title">Obaveštenje o širenju virusa putem email-a</h2>
                                <div class="bellow-title">
                                    <span class="author"><i class="fa fa-mixcloud"></i>Branko Milenković</span>
                                    <ul class="share-news">
                                        <li><a href="#" class="fa fa-facebook-f"></a></li>
                                        <li><a href="#" class="fa fa-twitter"></a></li>
                                        <li><a href="#" class="fa fa-google-plus"></a></li>
                                    </ul>
                                </div>
                                <time pubdate datetime="2017-08-29" title="August 29, 2017">
                                    <span class="day">29</span>
                                    <span class="month">AVG</span>
                                </time>
                            </header>
                            <figure>
                                <img src="{{ url('assets/images/temporary/news2.jpg') }}" alt="Image title">
                            </figure>
                            <div class="text-style">
                                <p>
                                    Obaveštavamo Vas da je sve češća pojava SPAM mailova koji sadrže virus. Želimo Vas upoznati sa potencijalnom pretnjom, kako bi zaštitili vaše email naloge.
                                </p>
                                <p>
                                    Konkretno, u pitanju su emailovi na nemačkom jeziku poslati sa lažnih email adresa nemačkih telekom operatera tipa “Telekom info@********.com”
                                </p>
                                <p>
                                    U mailu se navodi da ste prekoračili (fiktivni) račun i da ga mozete preuzeti u PDF formatu.
                                </p>
                                <p>
                                    Primer sadržaja emaila:
                                </p>
                                <blockquote>
                                    <p>
                                        Sehr geehrte Kundin,<br /> sehr geehrter Kunde
                                    </p>
                                    <p>
                                        Im Anhang finden Sie die gewünschten Dokumente und Daten zu Ihrer Telekom Mobilfunk Rechnung Online für Geschäftskunden vom Monat November,<br />
                                        Download (Ihre Telekom Mobilfunk RechnungOnline für Geschäftskunden 9903599055 vom 07.11.2014 des Kundenkontos 8323990355).
                                    </p>
                                    <p>
                                        Mit freundlichen Grüßen,<br />
                                        Geschäftskundenservice
                                    </p>
                                    <p>
                                        Telekom Deutschland GmbH<br />
                                        Aufsichtsrat: Timotheus Höttges Vorsitzender<br />
                                        Geschäftsführung: Niek Jan van Damme Sprecher, Thomas Dannenfeldt, Thomas Freude, Michael Hagspihl, Dr. Bruno Jacobfeuerborn, Dietmar Welslau, Dr. Dirk Wössner<br />
                                        Eintrag: Amtsgericht Bonn, HRB 59 19, Sitz der Gesellschaft Bonn<br />
                                        USt-Id.Nr.: DE 794100576531<br />
                                        WEEE-Reg.-Nr.: 367557846100
                                    </p>
                                </blockquote>
                                <p>
                                    Link vodi ka .zip fajlu koji umesto PDF fajla sadrži .exe fajl sa virusom (primer: 2014_11rechnung_K4768955881_pdf_sign_telekom_de_deutschland_gmbh.pdf.exe)
                                </p>
                                <p>
                                    Aktiviranjem virusa, kompromitovaćete sve svoje email naloge na računaru i virus će početi slati SPAM sa vaših email adresa.
                                </p>
                                <h3>
                                    Kako da se zaštitite?
                                </h3>
                                <p>
                                    Osnovno pravilo, nemojte kliktati na linkove iz sumnjivih emailova. Jednostavno obrišite email.
                                </p>
                                <h3>
                                    Ako ste preuzeli virus
                                </h3>
                                <ul>
                                    <li>
                                        Ukoliko ste greškom preuzeli virus, pokrenite anti-virus programe i očistite vaše računare.
                                    </li>
                                    <li>
                                        Mozete preuzeti besplatan program Malwarebytes Anti-malware<br />
                                        Promenite lozinke na svim email nalozima.
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </article>
                </div>

                <div class="col-lg-4">

                    <div class="latest-news">
                        <h3 class="block-title">Poslednje vesti</h3>
                        <ul>
                            <li>
                                <h4 class="title"><a>WP Slider Revolution Plugin</a></h4>
                                <time pubdate datetime="2017-08-27" title="August 27, 2017">
                                    27/05/2017
                                </time>
                            </li>
                            <li>
                                <h4 class="title"><a>WP Slider Revolution Plugin</a></h4>
                                <time pubdate datetime="2017-08-27" title="August 27, 2017">
                                    27/05/2017
                                </time>
                            </li>
                            <li>
                                <h4 class="title"><a>WP Slider Revolution Plugin</a></h4>
                                <time pubdate datetime="2017-08-27" title="August 27, 2017">
                                    27/05/2017
                                </time>
                            </li>
                            <li>
                                <h4 class="title"><a>WP Slider Revolution Plugin</a></h4>
                                <time pubdate datetime="2017-08-27" title="August 27, 2017">
                                    27/05/2017
                                </time>
                            </li>
                            <li>
                                <h4 class="title"><a>WP Slider Revolution Plugin</a></h4>
                                <time pubdate datetime="2017-08-27" title="August 27, 2017">
                                    27/05/2017
                                </time>
                            </li>
                        </ul>
                    </div>

                    <div class="testimonials-holder-t2">
                        <div class="testimonials-slider-t2">
                            <div class="testimonials-item">
                                <p class="testimonial-text">Koristila sam besplatnu platformu blogger dok nisam prešla kod vas. Hvala vam što ste mi sve tekstove prebacili na novi wordpress blog. Sada imam sopstveni domen, a poseta sajtu raste iz meseca u mesec.</p>
                                <div class="author"><span class="name">Nataša Blagojević</span> blogerka / nakyhandmade.com</div>
                            </div>
                            <div class="testimonials-item">
                                <p class="testimonial-text">Koristila sam besplatnu platformu blogger dok nisam prešla kod vas. Hvala vam što ste mi sve tekstove prebacili na novi wordpress blog. Sada imam sopstveni domen, a poseta sajtu raste iz meseca u mesec.</p>
                                <div class="author"><span class="name">Nataša Blagojević</span> blogerka / nakyhandmade.com</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection
@extends('layouts.page-dc')

@section('page-title')
    {{App::getLocale() === 'sr-Latn' ? ' Dobro došli na Webglobe stranu za podršku korisnicima ' : ' Welcome to the Webglobe customer support page '}}
@endsection

@section('page-description')
  {{App::getLocale() === 'sr-Latn' ? 'Webglobe podrška' : 'Webglobe support'}}
@endsection

@section('page-content')

    <section class="simple-page" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="text-style">
                        <h2>
                            <span class="bg-secondary"><a href="https://ninet.atlassian.net/servicedesk/" target="_blank">{{App::getLocale() === 'sr-Latn' ? 'DC podrška' : 'DC support'}}</a></span>
                        </h2>
                        <p>
                            {{App::getLocale() === 'sr-Latn' ? 'Preporučujemo Vam našu' : 'We recommend ours'}}
                            <a href="https://ninet.atlassian.net/wiki/spaces" target="_blank">
                                <span class="text-primary">
                                     <strong>{{App::getLocale() === 'sr-Latn' ? 'Bazu znanja' :'Knowledge base'}}</strong>
                                </span>
                            </a>
                            {{App::getLocale() === 'sr-Latn' ? 'gde možete pronaći odgovore na najčešće postavljana pitanja, kao i korisna uputstva.' : 'where you can find answers to frequently asked questions, as well as useful instructions.'}}
                        </p>
                        <p>
                            {{App::getLocale() === 'sr-Latn' ? 'Ukoliko niste pronašli odgovor u ' : 'If you did not find the answer in'}}
                            <a href="https://ninet.atlassian.net/wiki/spaces" target="_blank">
                                <span class="text-primary">
                                     <strong>{{App::getLocale() === 'sr-Latn' ? 'Bazi znanja' :'Knowledge base'}}</strong>
                                </span>
                            </a>
                            {{App::getLocale() === 'sr-Latn' ? ' i imate pitanja u vezi sa domenima, web hostingom, namenskim serverima, VPS-ovima, server housing-om, SSL sertifikatima, Mail Business servisom - Kontaktirajte našu' :'and you have questions about domains, web hosting, dedicated servers, VPSs, server housing, SSL certificates, Mail Business service - Contact our'}}
                            <a href="https://ninet.atlassian.net/servicedesk/" target="_blank">
                                <span class="text-primary">
                                    <strong>{{App::getLocale() === 'sr-Latn' ? 'DC podršku' : 'DC support'}}</strong>
                                </span>
                            </a>
                        </p>
                            <p>
                                <a href="https://ninet.atlassian.net/servicedesk/customer/user/signup" target="_blank"><span class="text-primary"><strong> {{App::getLocale() === 'sr-Latn' ?'Registracija naloga':'Account registration'}}</strong></span></a> {{App::getLocale() === 'sr-Latn' ?'je obavezna kako biste kontaktirali Webglobe podršku. ':'is required to contact Webglobe support.'}}
                            </p>
                        <h3>{{App::getLocale() === 'sr-Latn' ?'Kako da se registrujem?':'How do I register?'}}</h3>
                           <p>
                               {{App::getLocale() === 'sr-Latn' ? 'Detaljno uputstvo sa slikama se nalazi na linku' :'Detailed instructions with pictures can be found at the link'}}
                               @if(App::getLocale() === 'sr-Latn')
                                   <a href="https://ninet.atlassian.net/wiki/spaces/KN/pages/95748129/Uputstvo+za+pristup+NiNet+help+centru" target="_blank">
                                        <span class="text-primary">
                                             <strong>{{App::getLocale() === 'sr-Latn' ? 'Uputstvo za registraciju.' :'Registration instructions.'}}</strong>
                                        </span>
                                   </a>
                               @else
                                   <a href="https://ninet.atlassian.net/wiki/spaces/KN/pages/159940611/How+to+get+to+NiNet+help+center-+Instructions+for+registration" target="_blank">
                                        <span class="text-primary">
                                             <strong>{{App::getLocale() === 'sr-Latn' ? 'Uputstvo za registraciju.' :'Registration instructions.'}}</strong>
                                        </span>
                                   </a>
                               @endif
                           </p>
                        <h3>{{App::getLocale() === 'sr-Latn' ?'Kako da se ulogujem i kreiram tiket?':'How to log on user account and create a ticket?'}}</h3>
                        <p>
                            {{App::getLocale() === 'sr-Latn' ? 'Detaljno uputstvo sa slikama se nalazi na linku ' :'Detailed instructions with pictures can be found at the link'}}
                            @if(App::getLocale() === 'sr-Latn')
                                <a href="https://ninet.atlassian.net/wiki/spaces/KN/pages/346128385/" target="_blank">
                                        <span class="text-primary">
                                             <strong>{{App::getLocale() === 'sr-Latn' ? 'Kreiranje tiketa.' :' Create a ticket.'}}</strong>
                                        </span>
                                </a>
                            @else
                                <a href="https://ninet.atlassian.net/wiki/spaces/KN/pages/349929473/How+to+log+into+Ninet+Help+Center+and+create+a+ticket" target="_blank">
                                        <span class="text-primary">
                                             <strong>{{App::getLocale() === 'sr-Latn' ? 'Kreiranje tiketa.' :'Create a ticket.'}}</strong>
                                        </span>
                                </a>
                            @endif
                        </p>
                        <h3>{{App::getLocale() === 'sr-Latn' ?' Radno vreme DC podrške:':'DC support working hours:'}}</h3>
                            <p>
                                {{App::getLocale() === 'sr-Latn' ?' Ponedeljak-Petak: 8-20h':'Monday-Friday: 8-20h'}}<br>
                                {{App::getLocale() === 'sr-Latn' ?' Subota: 10-14h':'Saturday: 10-14h'}}<br>
                                {{App::getLocale() === 'sr-Latn' ?' Nedelja: Neradni dan':'Sunday: Non-working day'}}
                            </p>
                        <p>
                            {{App::getLocale() === 'sr-Latn' ?' Kontakt:':'Contact:'}}
                            <a href="https://ninet.atlassian.net/servicedesk/" target="_blank">
                                 <span class="text-primary">
                                    {{App::getLocale() === 'sr-Latn' ? 'DC podrška' : 'DC support'}}
                                 </span>
                            </a><br>
                            {{App::getLocale() === 'sr-Latn' ? 'Centrala: 018/3409888 opcija 3' :'Central: 018/4155055 option 3'}}<br>
                        </p>
                            <p>
                                {{App::getLocale() === 'sr-Latn' ? 'Hvala što koristite Webglobe DC servise.':'Thank you for using Webglobe DC services.'}}
                            </p><hr>
                    </div>
                </div>

                @include('partials.side-tech-dc')

            </div>
        </div>
    </section>
@endsection
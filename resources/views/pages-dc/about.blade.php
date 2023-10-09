@extends('layouts.page-dc')

@section('page-title')
   {{ __('main.about_us') }}
@endsection

@section('page-description')
    {{ __('main.about_us') }}
@endsection

@section('page-content')

    <section class="simple-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="text-style">
                        <p>
                            <strong>{{ App::getLocale() === 'sr-Latn' ? ' NiNet Data Centar je promenio naziv u Webglobe d.o.o. sa predstavništvom u Nišu.. ' : 'NiNet Data Center Operations has changed its name to Webglobe d.o.o. registered in Niš (Serbia).' }}</strong><br><br>
                            {{ App::getLocale() === 'sr-Latn' ? ' Webglobe je posvećen pružanju visokokvalitetnih hosting servisa i najbolje korisničke podrške. ' : 'Webglobe is committed to delivering high-quality IT Hosting Services and industry-best Customer Support.' }}<br><br>
                            {{ App::getLocale() === 'sr-Latn' ? ' Kompanija Webglobe, koja se bavi pružanjem usluga kao web provajder, digitalnih komunikacija i cloud usluga,ima za cilj da olakša preduzećima da uđu u digitalno okruženje i da potpomaže njihovom razvoju. ' : 'Currently, Webglobe manages over 300.000 domains for over  100.000 customers – in three countries.' }} <br><br>
                            {{ App::getLocale() === 'sr-Latn' ? ' U svom portfoliju ima ukupno šesnaest brendova. Trenutno opslužuje oko 100.000 klijenata i upravlja sa preko 300.000 domena u tri zemlje. ' : 'Currently, Webglobe manages over 300.000 domains for over  100.000 customers – in three countries.' }}<br><br>
                            {{ App::getLocale() === 'sr-Latn' ? ' Kompanija Webglobe već dugo drži drugu najjaču poziciju na slovačkom tržištu, a u Srbiji, gde je kompanija nedavno ušla akvizicijom NiNeta, Eutelneta i Paneta, ubrzano gradi svoju poziciju. ' : 'Webglobe ranks number two on the Slovak market, and it is starting to build its position on the Serbian market with the acquisition of three local web hosting companies, NiNet, Eutelnet and Panet.' }}
                            {{ App::getLocale() === 'sr-Latn' ? ' Međutim, ambicije kompanije Webglobe se tu ne završavaju; kompanija planira dalje domaće kupovine i širenje akvizicija u zemljama Centralne i Istočne Evrope.' : 'This move strengthens Webglobe’s foothold in the region and marks  another step towards its goal of building a leading web hosting provider in Central and Eastern Europe' }}
                           </p>

                            <p>
                                {{ App::getLocale() === 'sr-Latn' ? ' Cilj Webglobe-a je da svaki korisnik odabere ono što mu je potrebno iz širokog spektra usluga i olakša korisnicima pristup online poslovanju ' : 'The goal of Webglobe is for everybody to choose what they need from awide range of services and make it easier for them to enter the onlinebusiness as much as possible.' }}
                                {{ App::getLocale() === 'sr-Latn' ? ' Webglobe infrastruktura se temelji na tri osnovne vrednosti - dostupnost, brzina i sigurnost ' : 'Webglobe Infrastructure relies on three primary values – availability,speed, and security' }}
                                {{ App::getLocale() === 'sr-Latn' ? 'Kompanija posluje u 3 data centra na 3 različite lokacije u svetu, u različitim klimatskim uslovima (kako prirodna katastrofa na jednoj lokaciji ne bi uticala na ostale) ' : 'The company operates in 3 data centers in 3different global locations, all in different climates (so that a naturaldisaster in one wouldn’t affect another)' }}
                                {{ App::getLocale() === 'sr-Latn' ? 'Svi centri su međusobno povezani, što se odnosi i na sistem backup-a. Sve funkcioniše preko optičke mreže. ' : 'Each center connects to eachof the others and, which also includes backup connectivity. All of itoperates on fiber optic cables' }}
                                {{ App::getLocale() === 'sr-Latn' ? 'Naši data centri ispunjavaju najstrože međunarodne kriterijume bezbednosti i pristupačnosti.' : 'Support is available through chat support, ticketing system and telephone. All of our data centers meet thestrictest international security and accessibility criteria.' }}<br><br>
                                {{ App::getLocale() === 'sr-Latn' ? 'Rutiranje se vrši u okviru autonomnog IP opsega korišćenjem visokokvalitetnih Cisco proizvoda. ' : 'Routing is arranged to autonomous IP range using high-quality Cisco products.' }}
                                {{ App::getLocale() === 'sr-Latn' ? 'Savremena arhitektura omogućava našim klijentima da budu online čak i ako je data centar pod DDOS napadom ' : 'Routing is arranged to autonomous IP range using high-quality Cisco products.' }}
                                {{ App::getLocale() === 'sr-Latn' ? 'Čitava mrežna struktura funkcioniše u minimalnoj konfiguraciji od N + 1.' : 'All network facilities operate in a minimum configuration of N+1.' }}
                            </p>

                            <p>
                                {{ App::getLocale() === 'sr-Latn' ? 'Webglobe koristi samo visokokvalitetni brendirani hardver za pružanje usluga hostinga. ' : 'Webglobe uses only high-quality branded hardware for providing hosting services.' }}' }}
                                {{ App::getLocale() === 'sr-Latn' ? 'Za mrežne usluge, kompanija prvenstveno koristi Cisco i Cisco Linksys proizvode. ' : ' For network services, the company primarily uses Cisco and Cisco Linksys products.' }}
                                {{ App::getLocale() === 'sr-Latn' ? ' Za prenos, napajanje i ˝disaster recovery˝ koriste se APC proizvodi, dok je za servere i skladištenje glavni dobavljač Dell. ' : ' APC products are used for transmission, power supply, and disaster recovery.Where for production servers and storage Dell is the prime vendor.' }}
                            </p>

                            <p>
                                {{ App::getLocale() === 'sr-Latn' ? 'Sandberg Capital je primarni investitor Webglobe-a. ' : 'Sandberg Capital isthe primary investor of Webglobe.' }}
                                {{ App::getLocale() === 'sr-Latn' ? 'To je kompanija koja se bavi upravljanjem alternativnim investicionim fondovima i fokusira se na ulaganje u mala i srednja preduzeća u Slovačkoj i regionu Centralne i Istočne Evrope' : 'It is an alternative investment fund management company that focuses on investing in small and medium-sized companies in Slovakia and in the region of Central and Eastern Europe' }}
                                {{ App::getLocale() === 'sr-Latn' ? 'Njihov portfolio uključuje sredstva u iznosu od preko 150 miliona evra.' : 'Its portfolio includes assets in the amount of over EUR 150 million. ' }}
                            </p>
                    </div>
                </div>

                @include('partials.side-tech-dc')

            </div>
        </div>
    </section>

@endsection
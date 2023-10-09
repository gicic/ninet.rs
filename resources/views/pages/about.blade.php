@extends('layouts.page')

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
                            {{ App::getLocale() === 'sr-Latn' ? ' NiNet je osnovan 2003. godine u Nišu. ' : 'NiNet was founded in 2003 in Niš.' }}
                            {{ App::getLocale() === 'sr-Latn' ? ' Od tada smo stekli poverenje velikog broja klijenata. ' : 'Since then, we have gained the trust of a large number of clients' }}
                            {{ App::getLocale() === 'sr-Latn' ? ' Danas NiNet svojim bežičnim signalom pokriva veći deo južne Srbije. ' : 'Today, NiNet covers most of southern Serbia with its wireless signal.' }}
                            {{ App::getLocale() === 'sr-Latn' ? '  Prateći najnovije svetske trendove, telekomunikacijske i informacijske standarde, svojim korisnicima želimo osigurati kvalitetnu uslugu po povoljnim cenama.' : 'Following the latest world trends, telecommunications and information standards, we want to provide our customers with quality service at affordable prices.' }}
                           </p>

                        <blockquote>
                            <p>
                                {{ App::getLocale() === 'sr-Latn' ? ' Ninet zapošljava radnike širokog spektra znanja i veština. ' : 'Ninet employs workers with a wide range of knowledge and skills.' }}
                                {{ App::getLocale() === 'sr-Latn' ? ' Svaki zaposleni je prošao internu obuku koja je srž kvalitetno pruženih usluga u daljem radu kompanije. ' : 'Each employee has undergone internal training, which is the core of quality services provided in the further work of the company.' }}
                                {{ App::getLocale() === 'sr-Latn' ? 'Podrška je na raspolaganju putem chat podrške, tiketing sistema i telefona. ' : 'Support is available through chat support, ticketing system and telephone.' }}
                            </p>
                        </blockquote>
                        <h2>
                            {{ App::getLocale() === 'sr-Latn' ? ' Vi ste nam na prvom mestu.' : 'You are our number one priority.' }}
                        </h2>
                        <p>
                            {{ App::getLocale() === 'sr-Latn' ? 'Zahvaljujući činjenici da svoje resurse sami održavamo i kreiramo, u mogućnosti smo da klijentimo ponudimo povoljne cene usluga na svetskom nivou. ' : 'Thanks to the fact that we maintain and create our own resources, we are able to offer clients the best prices for services worldwide.' }}
                        </p>
                        {{--<ul>--}}
                            {{--<li>--}}
                                {{--Lorem ipsum dolor sit amet, consectetur adipiscing elit.--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--Mauris turpis libero, tincidunt in tortor feugiat, pretium porta enim.--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--Suspendisse at erat malesuada, pulvinar nulla eu, lobortis sem.--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--Nulla non felis ultricies, congue augue nec, lacinia erat.--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--Suspendisse potenti.--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    </div>
                </div>

                @include('partials.side-tech')

            </div>
        </div>
    </section>

@endsection
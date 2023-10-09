@extends('layouts.page')

@section('page-title')
     {{ __('main.news') }}
@endsection

@section('page-description')
    {{ __('main.news') }}
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render(Route::currentRouteName()) }}
@endsection

@section('page-content')

    <section class="news-list">
        <div class="container">

            <article class="news-article">
                <div class="content">
                    <header>
                        <h3 class="article-title">WP Slider Revolution Plugin bezbednosni propust</h3>
                        <div class="bellow-title">
                            <span class="author"><i class="fa fa-mixcloud"></i>Branko Milenković</span>
                        </div>
                        <time pubdate datetime="2017-08-30" title="August 30, 2017">
                            <span class="day">30</span>
                            <span class="month">AVG</span>
                        </time>
                    </header>
                    <div class="row">
                        <div class="col-md-5 col-lg-4">
                            <figure>
                                <img src="{{ url('assets/images/temporary/news1.jpg') }}" alt="Image title">
                            </figure>
                        </div>
                        <div class="col-md-7 col-lg-8">
                            <div class="short text-style">
                                <p>Ovo obaveštenje upućeno je hosting korisnicima koji koriste WordPress Slider Revolution Plugin na svojim web sajtovima.</p>
                                <p>Ovaj veoma rasprostranjen plugin u svojim starijim verzijama ima veliki bezbedonosni...</p>
                                <a href="{{ route('page.news.single', ['id' => 1]) }}" class="btn-t1">OPŠIRNIJE <span class="fa fa-arrow-circle-right"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </article>

            <div class="pagination-holder center">
                <ul class="pagination">
                    <li><a href="#"><span class="fa fa-angle-double-left"></span></a></li>
                    <li class="active"><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#"><span class="fa fa-angle-double-right"></span></a></li>
                </ul>
            </div>

        </div>
    </section>

@endsection
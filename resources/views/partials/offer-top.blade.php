<section class="page-top-part">
    <div class="container">
        {{ Breadcrumbs::render(Route::currentRouteName(), $offer) }}

        <div class="page-title-block">
            <h2 class="page-title">@yield('page-title')</h2>
            <h3 class="page-short-desc" style="font-size: 1.2rem">@yield('page-description')</h3>
        </div>

    </div>
</section>
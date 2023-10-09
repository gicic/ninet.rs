<?php

// Home

Breadcrumbs::for('home', function ($trail) {
    $trail->push('Početna', route('home'));
});

// Common offer breadcrumbs

Breadcrumbs::for('offer.servers-linux', function ($trail, $offer) {
    $trail->parent('home');
    $trail->push($offer->title, route($offer->route));
});

Breadcrumbs::for('offer.servers-windows', function ($trail, $offer) {
    $trail->parent('home');
    $trail->push($offer->title, route($offer->route));
});

Breadcrumbs::for('offer.server-housing', function ($trail, $offer) {
    $trail->parent('home');
    $trail->push($offer->title, route($offer->route));
});

Breadcrumbs::for('offer.vps-ssd', function ($trail, $offer) {
    $trail->parent('home');
    $trail->push($offer->title, route($offer->route));
});

Breadcrumbs::for('offer.vps-ssd-cpanel', function ($trail, $offer) {
    $trail->parent('home');
    $trail->push($offer->title, route($offer->route));
});

Breadcrumbs::for('offer.windows-vps-servers', function ($trail, $offer) {
    $trail->parent('home');
    $trail->push($offer->title, route($offer->route));
});

Breadcrumbs::for('offer.hosting-web', function ($trail, $offer) {
    $trail->parent('home');
    $trail->push($offer->title, route($offer->route));
});

Breadcrumbs::for('offer.hosting-ssd', function ($trail, $offer) {
    $trail->parent('home');
    $trail->push($offer->title, route($offer->route));
});

Breadcrumbs::for('offer.mail-servers', function ($trail, $offer) {
    $trail->parent('home');
    $trail->push($offer->title, route($offer->route));
});

Breadcrumbs::for('offer.domains', function ($trail, $offer) {
    $trail->parent('home');
    $trail->push($offer->title, route($offer->route));
});

Breadcrumbs::for('offer.ssl', function ($trail, $offer) {
    $trail->parent('home');
    $trail->push($offer->title, route($offer->route));
});

Breadcrumbs::for('offer.wireless-internet', function ($trail, $offer) {
    $trail->parent('home');
    $trail->push($offer->title, route($offer->route));
});

Breadcrumbs::for('offer.fiber-internet', function ($trail, $offer) {
    $trail->parent('home');
    $trail->push($offer->title, route($offer->route));
});

// News breadcrumbs
Breadcrumbs::for('page.news', function ($trail) {
    $trail->parent('home');
    $trail->push(__('main.news'), route('page.news'));
});

Breadcrumbs::for('page-dc.news', function ($trail) {
    $trail->parent('home');
    $trail->push(__('main.news'), route('page-dc.news'));
});

Breadcrumbs::for('page.news.single', function ($trail, $singleNews) {
    $trail->parent('page.news');
    $trail->push($singleNews->title, route('page.news.single', ['id' => $singleNews->id]));
});
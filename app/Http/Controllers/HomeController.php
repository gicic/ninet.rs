<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke()
    {
        return view('home');

    }
    public function dcHome()
    {

        $headTitle = \App::getLocale() === 'sr-Latn' ? 'Najbolji Hosting I Internet provajder u Srbiji' : 'European Web Hosting';
        $packagesContent = [
            'hosting' => [
                'sr-Latn' => 'Siguran hosting uz odlične performanse sa odličnom podrškom.',
                'en' => 'Best home web hosting starting from 25 EUR per month.',
            ],
            'vps' => [
                'sr-Latn' => 'Hostujte neograničen broj sajtova web aplikacija ili skripti na Webglobe VPS serverima.',
                'en' => 'VPS hosting is designed for more demanding websites and applications. We offer SAS and SSD VPS packages.',
            ],
            'dedicated' => [
                'sr-Latn' => 'Brzi linkovi Webglobe servera namenjeni projektima sa specifičnim zahtevima.',
                'en' => 'Certainly the best offer of dedicated Servers in Serbia, starting from 69 EUR per month.',
            ],
            'ssl' => [
                'sr-Latn' => 'Konfigurišite server i povežite se na link za manje od 24h.',
                'en' => 'Protect your website with SSL certificate on time. New hosting clients are offered free SSL certificate for the first year.',
            ],

        ];

        $whyWebglobe = [
            'sr-Latn' => 'Kao hosting provajder s pozicinirali smo se kao jedna od najboljih kompanija u Srbiji i regionu. Preko 15 godina iskustva i nekoliko hiljada  zadovoljnih klijenata su dovojlan razlog da započnete saradnju sa nama!',
            'en' => 'As a hosting and internet provider we have positioned as one of the leading companies in Serbia and the region. Over 15 years of experience and more than 7000 satisfied clients are a good reason to start your cooperation with us!'
        ];

        $iconsText = [
            'anchor' => [
                'sr-Latn' => 'Preko 20 godina na tržištu ',
                'en' => 'Over 20 years on the market',
            ],
            'wallet' => [
                'sr-Latn' => 'Garancija povraćaja novca',
                'en' => 'Money back guarantee',
            ],
            'atom' => [
                'sr-Latn' => 'Pregledno klijentsko okruženje',
                'en' => 'Clear client environment',
            ],
            'gears' => [
                'sr-Latn' => 'Odlična tehnička podrška',
                'en' => 'Excellent technical support',
            ]
        ];

        $othersAboutUs = [
            0 => [
                'sr-Latn' => [
                    'content' => 'Svako okupljanje WordPress Srbije propraćeno je Ninet Hostingom koji je jedan od naših prvih prijatelja. Hvala Vam na pomoći!',
                    'author' => 'Milan Ivanovic',
                    'title' => 'WordPress Serbia',
                ],
                'en' => [
                    'content' => 'All WordPress Serbia meetups are followed and backuped by Ninet Hosting, which is one of our first friends. Thank you for the support!',
                    'author' => 'Milan Ivanovic',
                    'title' => 'WordPress Serbia',
                ],
            ],
            1 => [
                'sr-Latn' => [
                    'content' => 'Domacim klijentima preporučujemo Ninet zato što nam je bitna odlična podrška i kvalitetna infrastruktura.',
                    'author' => 'Radomir Basta',
                    'title' => 'Fourdots',
                ],
                'en' => [
                    'content' => 'We recommend Ninet to local clients because we find excellent support and high-quality infrastructure very important.',
                    'author' => 'Radomir Basta',
                    'title' => 'Fourdots',
                ],
            ],
            2 => [
                'sr-Latn' => [
                    'content' => 'Ukoliko želite hosting bez da se dodatno stresirate kako će raditi tokom vremena, mogu samo da kažem da posle nekoliko godina saradnje sa Ninetom moja očekivanja su ispunjena u potpunosti. Ukoliko vam je bitan brz response rate, profesionalna komunikacija i ažuriranja servera u low traffic vremenu preporučujem Ninet.',
                    'author' => 'Ivana Petrović',
                    'title' => 'Optimus Media',
                ],
                'en' => [
                    'content' => 'If would like to have a hosting without any stress about how it will work in the course of time, I can only say that after several years of cooperation with Ninet, my expectations have been fully met. If a fast response rate is important to you, as well as professional correspondence and regular updates in low traffic time, I do recommend Ninet.',
                    'author' => 'Ivana Petrović',
                    'title' => 'Optimus Media',
                ],
            ],
            3 => [
                'sr-Latn' => [
                    'content' => 'Ninet je hosting provajder koji ekpresno rešava sve zahteve koje ima jedan veliki sistem poput nas. Naše iskustvo je da su Ninetovi zaposleni krajnje ljubazni (čak nas i sami zovu telefonom:) i veoma stručni u rešavanju svih problema koje smo imali do sada.',
                    'author' => 'Nenad Radojević',
                    'title' => 'System Engineer',
                ],
                'en' => [
                    'content' => 'Ninet is a hosting provider that resolves the requirements of a large system such as ours. Our experience is that Ninet employees are extremely friendly (they even call us by telephone :) and are experts in solving all the problems we have had so far.',
                    'author' => 'Nenad Radojević',
                    'title' => 'System Engineer',
                ],
            ],
        ];

        return view('home-dc', compact(['packagesContent', 'whyWebglobe', 'othersAboutUs', 'iconsText', 'headTitle']));
    }

    public function intHome()
    {

        $internetContent = [
            'wireless' => [
                'sr-Latn' => [
                    'title' => 'Wireless Internet Home Paketi',
                    'content' => 'Neograničen i pre svega stabilan protok svim Ninet korisnicima. Budite online već sutra!'
                ],
                'en' => [
                    'title' => 'Wireless Internet Home Packages',
                    'content' => 'Unlimited and most importantly stable flow to all Ninet users. No contractual obligations required.'
                ],
            ],
            'fiber' => [
                'sr-Latn' => [
                    'title' => 'Optički Internet Home Paketi',
                    'content' => 'Savremen internet pristup, sa najvećom brzinom i pouzdanošću!',
                ],
                'en' => [
                    'title' => 'Optical Internet Home Packages',
                    'content' => 'Modern internet access, with the highest speed and reliability!'
                ],
            ],
        ];

        $whyNinet = [
            'sr-Latn' => 'Kao internet  provajder pozicinirali smo se kao jedna od najboljih kompanija u Srbiji i regionu. Preko 15 godina iskustva i nekoliko hiljada  zadovoljnih klijenata su dovojlan razlog da započnete saradnju sa nama!',
            'en' => 'As a hosting and internet provider we have positioned as one of the leading companies in Serbia and the region. Over 15 years of experience and more than 7000 satisfied clients are a good reason to start your cooperation with us!'
        ];

        $iconsText = [
            'anchor' => [
                'sr-Latn' => 'Sigurnost na prvom mestu. Najsavremenije mere zaštite ',
                'en' => 'Safety in the first place. Most modern security measures',
            ],
            'wallet' => [
                'sr-Latn' => 'Fer cene usluga. Kvalitet na svetskom nivou',
                'en' => 'Fair service prices. World class quality',
            ],
            'atom' => [
                'sr-Latn' => 'Deo smo velkih sistema u Srbiji',
                'en' => 'We are a part of the big systems in Serbia',
            ],
            'gears' => [
                'sr-Latn' => 'Posvećena tehnička podrška',
                'en' => 'Dedicated technical support',
            ]
        ];
        $othersAboutUs = [
            0 => [
                'sr-Latn' => [
                    'content' => 'Svako okupljanje WordPress Srbije propraćeno je Ninet Hostingom koji je jedan od naših prvih prijatelja. Hvala Vam na pomoći!',
                    'author' => 'Milan Ivanovic',
                    'title' => 'WordPress Serbia',
                ],
                'en' => [
                    'content' => 'All WordPress Serbia meetups are followed and backuped by Ninet Hosting, which is one of our first friends. Thank you for the support!',
                    'author' => 'Milan Ivanovic',
                    'title' => 'WordPress Serbia',
                ],
            ],
            1 => [
                'sr-Latn' => [
                    'content' => 'Domacim klijentima preporučujemo Ninet zato što nam je bitna odlična podrška i kvalitetna infrastruktura.',
                    'author' => 'Radomir Basta',
                    'title' => 'Fourdots',
                ],
                'en' => [
                    'content' => 'We recommend Ninet to local clients because we find excellent support and high-quality infrastructure very important.',
                    'author' => 'Radomir Basta',
                    'title' => 'Fourdots',
                ],
            ],
            2 => [
                'sr-Latn' => [
                    'content' => 'Ukoliko želite hosting bez da se dodatno stresirate kako će raditi tokom vremena, mogu samo da kažem da posle nekoliko godina saradnje sa Ninetom moja očekivanja su ispunjena u potpunosti. Ukoliko vam je bitan brz response rate, profesionalna komunikacija i ažuriranja servera u low traffic vremenu preporučujem Ninet.',
                    'author' => 'Ivana Petrović',
                    'title' => 'Optimus Media',
                ],
                'en' => [
                    'content' => 'If would like to have a hosting without any stress about how it will work in the course of time, I can only say that after several years of cooperation with Ninet, my expectations have been fully met. If a fast response rate is important to you, as well as professional correspondence and regular updates in low traffic time, I do recommend Ninet.',
                    'author' => 'Ivana Petrović',
                    'title' => 'Optimus Media',
                ],
            ],
            3 => [
                'sr-Latn' => [
                    'content' => 'Ninet je hosting provajder koji ekpresno rešava sve zahteve koje ima jedan veliki sistem poput nas. Naše iskustvo je da su Ninetovi zaposleni krajnje ljubazni (čak nas i sami zovu telefonom:) i veoma stručni u rešavanju svih problema koje smo imali do sada.',
                    'author' => 'Nenad Radojević',
                    'title' => 'System Engineer',
                ],
                'en' => [
                    'content' => 'Ninet is a hosting provider that resolves the requirements of a large system such as ours. Our experience is that Ninet employees are extremely friendly (they even call us by telephone :) and are experts in solving all the problems we have had so far.',
                    'author' => 'Nenad Radojević',
                    'title' => 'System Engineer',
                ],
            ],
        ];

        return view('home-int', compact([ 'internetContent', 'whyNinet', 'iconsText','othersAboutUs']));
    }

    /**
     * Page not found
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pageNotFound()
    {
       return view('404');
    }
}

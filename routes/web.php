<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::group(['middleware' => 'restrictIpMiddleware'], function() {
Route::get('/raiffeisen/{order_id}/online_payments', 'RaiffeisenController@onlinePayment');

    Route::group(['middleware' => 'fullCartRedirect'], function () {

        /**
         * If it's a first visit GeoIP redirects user according to his or hers geo location
         */
        Route::group(['middleware' => ['geoIpLocalization']], function () {
            /**
             * Route localization
             */

            Route::group(
                [
                    'prefix' => LaravelLocalization::setLocale(),
                    'middleware' => ['localize', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'localeToSession']
                ],
                function()
                {
                    Route::get('/dc', 'HomeController@dcHome')->name('home-dc');
                    Route::get('/int', 'HomeController@intHome')->name('home-int');
                    Route::get('/', 'HomeController')->name('home');


                    Route::get('/invoice/{orderId}', 'InvoiceController@invoicePDF')->name('invoice.pdf');

                    /*
                     * Domain offer
                     */
                    Route::get(LaravelLocalization::transRoute('routes.domains'), 'DomainOfferController@getOffer')->name('offer.domains');
                    Route::get('/cart-domain', 'CartController@showCartDomain')->name('cart.domain');
                    Route::post('/domains/list', 'DomainOfferController@getDomainList')->name('list.domains');
                    Route::post('/check-domain-compatibility', 'DomainOfferController@checkDomainCompatibility')->name('domains.check-compatibility');
                    Route::get('/general-terms-domain-registration', 'DomainOfferController@generalTermsDomainRegistrationPdf')->name('domains.general-terms-domain-registration');
                    Route::get('/opsti-uslovi-registracije-domena', 'DomainOfferController@opstiUsloviRegistracijeDomenaPdf')->name('domains.opsti-uslovi-registracije-domena');

                    /*
                     * SSL offer
                     */
                    Route::get(LaravelLocalization::transRoute('routes.ssl'), 'SslOfferController@getOffer')->name('offer.ssl');
                    Route::get('/cart-ssl/{productId}', 'SslCartController@showCartSsl')->name('cart.ssl');
                    Route::post('/generate-csr', 'SslCartController@generateCsrCode')->name('ssl.generate-csr');
                    Route::post('/ssl-wizard-products', 'SslOfferController@getSslWizardProducts')->name('offer.ssl-wizard-products');
                    Route::post('/ssl-add-to-cart', 'SslCartController@addToCart')->name('ssl.add-to-cart');
                    Route::post('get-ssl-confirmation-emails', 'SslCartController@getConfirmationEmailsOptions')->name('ssl.get-confirmation-emails');

                    /*
                     * VPS offer
                     */
                    Route::get(LaravelLocalization::transRoute('routes.vps-ssd'), 'VpsOfferController@getSsdVpsOffer')->name('offer.vps-ssd');
                    Route::get(LaravelLocalization::transRoute('routes.vps-ssd-cpanel'), 'VpsOfferController@getSsdVpsCpanelOffer')->name('offer.vps-ssd-cpanel');
                    Route::get(LaravelLocalization::transRoute('windows-vps-servers'), 'VpsOfferController@getVpsWindowsSsdOffer')->name('offer.windows-vps-servers');
                    Route::get('/cart-vps/{cartRowId}', 'CartController@showCartVps')->name('cart.vps');

                    /*
                     * Hosting Offer
                     */
                    Route::get(LaravelLocalization::transRoute('routes.hosting-ssd'), 'HostingOfferController@getSsdHostingOffer')->name('offer.hosting-ssd');
                    Route::get(LaravelLocalization::transRoute('routes.mail-servers'), 'HostingOfferController@getMailServersOffer')->name('offer.mail-servers');
                    Route::get('/cart-hosting/{cartRowId}', 'HostingCartController@showCartHosting')->name('cart.hosting');
                    Route::post('/hosting-add-to-cart', 'HostingCartController@addToCart')->name('hosting.add-to-cart');

                    /*
                     * Dedicated Offer
                     */
                    Route::get(LaravelLocalization::transRoute('routes.servers-linux'), 'ServerOfferController@getLinuxOffer')->name('offer.servers-linux');
                    Route::get(LaravelLocalization::transRoute('routes.servers-windows'), 'ServerOfferController@getWindowsOffer')->name('offer.servers-windows');
                    Route::get('/cart-linux/{cartRowId}', 'CartController@showCartLinux')->name('cart.linux-servers');
                    Route::get('/cart-windows/{cartRowId}', 'CartController@showCartWindows')->name('cart.windows-servers');

                    /*
                     * Server Housing Offer
                     */
                    Route::get(LaravelLocalization::transRoute('routes.server-housing'), 'ServerOfferController@getHousingOffer')->name('offer.server-housing');
                    Route::get('/cart-housing/{cartRowId}', 'CartController@showCartHousing')->name('cart.server-housing');

                    /*
                     * Shopping Cart
                     */
                    Route::get('/get-cart-view', 'CartController@getCartView')->name('cart.get-view');
                    Route::get('/get-cart-side-view', 'CartController@getSideCartView')->name('cart.get-side-view');
                    Route::get('/get-cart-payments-view', 'CartController@getPaymentsCartView')->name('cart.get-payments-view');
                    Route::get('/add-to-cart/{id}/{cartRoute}', 'CartController@addToCart')->name('cart.add');
                    Route::post('/add-to-cart-post', 'CartController@addToCartPost')->name('cart.add-post');
                    Route::post('/remove-from-cart', 'CartController@removeFromCart')->name('cart.remove');
                    Route::post('/remove-whois-from-cart', 'CartController@removeWhoisFromCart')->name('cart.remove-whois');
                    Route::post('/add-additional-to-cart', 'CartController@addAdditionalToCart')->name('cart.add-additional');
                    Route::post('/cart-update', 'CartController@updateCartItem')->name('cart.update');
                    Route::post('/add-domains-to-cart', 'CartController@addDomainsToCart')->name('cart.add-domains');

                    Route::post('/domain-is-available', 'CartController@domainIsAvailable')->name('cart.domain-is-available');

                    /*
                     * Purchase
                     */
                    Route::get('/purchase', 'PurchaseController@getPurchase')
                        ->middleware(['emptyCartRedirect'])
                        ->name('purchase.index');

                    Route::get('/purchase-product', 'PurchaseController@getIntPurchase')
                        ->middleware(['emptyCartRedirect'])
                        ->name('purchase.purchase-int');

                    Route::post('/purchase-login', 'PurchaseController@getLoginData')->name('purchase.login');

                    Route::get('/thank-you', 'PurchaseController@purchaseSuccess')->name('purchase.success');
                    Route::post('/get-dial-code', 'PurchaseController@getDialCode')->name('purchase.dial-code');

                    /*
                     * PAYMENT ROUTES
                     */
                    Route::group(['middleware' => 'emptyCartRedirect'], function () {
                        Route::post('/payment-redirect', 'PaymentController@paymentRedirect')->name('payment.redirect');
                        Route::post('/finalize-purchase', 'PurchaseController@finalizePurchase')->name('purchase.finalize');
                        Route::get('/payment', 'PurchaseController@getPaymentPage')->name('payment.page');

                        Route::get('/paypal/express', 'PayPalController@expressCheckout')->name('paypal.express');

                        Route::get('/twocheckout/charge', 'TwoCheckoutController@charge')->name('twocheckout.charge');
                    });

                    Route::post('/payment/validation', 'PaymentController@jsValidation')->name('payment.validation');

                    Route::get('/paypal/success', 'PayPalController@expressCheckoutSuccess')->name('paypal.express.success');
                    Route::get('/paypal/ipn', 'PayPalController@notification')->name('paypal.ipn');

                    Route::get('/twocheckout/success', 'TwoCheckoutController@chargeSuccess')->name('twocheckout.charge.success');
                    Route::get('/twocheckout/ipn', 'TwoCheckoutController@notification')->name('twocheckout.ipn');

                    Route::post('/nestpay/success', 'NestpayController@paymentSuccess')->name('nestpay.success');
                    Route::get('/nestpay/success-transaction', 'NestpayController@paymentSuccessPage')->name('nestpay.success-transaction');
                    Route::post('/nestpay/fail', 'NestpayController@paymentFail')->name('nestpay.fail');
                    Route::get('/nestpay/fail-transaction', 'NestpayController@paymentFailPage')->name('nestpay.fail-transaction');
                    Route::post('/nestpay/form', 'NestpayController@generateForm')->name('nestpay.form');
                    Route::get('/nestpay/cancel', 'NestpayController@cancelRedirect')->name('nestpay.cancel');

                    Route::post('/apply-promo-code', 'CartController@applyPromoCode')->name('promo-code.apply');

                    /*
                     * PAGES
                     */
                    Route::get('/about-us', 'PageController@aboutUs')->name('page.about');
                    Route::get(LaravelLocalization::transRoute('routes.about-us-dc'), 'DcPageController@aboutUs')->name('page-dc.about');
                    Route::any('/contact', 'PageController@contact')->name('page.contact');
                    Route::any(LaravelLocalization::transRoute('routes.contact-us-dc'), 'DcPageController@contact')->name('page-dc.contact');
                    Route::get('/news', 'PageController@news')->name('page.news');
                    Route::get(LaravelLocalization::transRoute('routes.news-dc'), 'DcPageController@news')->name('page-dc.news');
                    Route::get('/news/{id}', 'PageController@newsSingle')->name('page.news.single');
                    Route::get('/news-dc/{id}', 'DcPageController@newsSingle')->name('page-dc.news.single');
                    Route::get(LaravelLocalization::transRoute('routes.privacy-policy'), 'PageController@privacyPolicy')->name('page.privacy-policy');
                    Route::get(LaravelLocalization::transRoute('routes.privacy-policy-dc'), 'DcPageController@privacyPolicy')->name('page-dc.privacy-policy');
                    Route::get(LaravelLocalization::transRoute('routes.terms-and-conditions'), 'PageController@termsAndConditions')->name('page.terms-and-conditions');
                    Route::get(LaravelLocalization::transRoute('routes.terms-and-conditions-dc'), 'DcPageController@termsAndConditions')->name('page-dc.terms-and-conditions');
                    Route::get(LaravelLocalization::transRoute('routes.payment-and-refund-policy'), 'PageController@paymentAndRefundPolicy')->name('page.payment-and-refund-policy');
                    Route::get(LaravelLocalization::transRoute('routes.payment-and-refund-policy-dc'), 'PageController@paymentAndRefundPolicy')->name('page.payment-and-refund-policy');
                    Route::get(LaravelLocalization::transRoute('routes.payment-and-refund-policy-dc'), 'DcPageController@paymentAndRefundPolicy')->name('page-dc.payment-and-refund-policy');
                    Route::get(LaravelLocalization::transRoute('routes.delivery-policy'), 'PageController@deliveryPolicy')->name('page.delivery-policy');
                    Route::get(LaravelLocalization::transRoute('routes.delivery-policy-dc'), 'DcPageController@deliveryPolicy')->name('page-dc.delivery-policy');
                    Route::get('contract-and-name-of-representative-dc', 'DcPageController@contractAndNameOfRepresentative')->name('page-dc.contract-and-name-of-representative');
                    Route::get('/upcoming-price-change', 'DcPageController@upcomingPriceChange')->name('page-dc.upcoming-price-change');

                    Route::get('/internet-narucivanje/{id}', 'InternetController@create')->name('internet.create');
                    Route::get(LaravelLocalization::transRoute('routes.wireless-internet'), 'InternetController@offerWireless')->name('offer.wireless-internet');
                    Route::get(LaravelLocalization::transRoute('routes.fiber-internet'), 'InternetController@offerFiber')->name('offer.fiber-internet');
                    Route::post('/internet-request', 'InternetController@store')->name('internet.store');
                    Route::get('internet/terms', 'InternetController@terms')->name('internet.terms');
                    Route::get('internet/obrada-podataka-o-licnosti', 'InternetController@personalityDataPdf')->name('internet.personality-data');
                    Route::get('internet/resavanje-prigovora', 'InternetController@objectionResolvePdf')->name('internet.objection-resolve');
                    Route::get(LaravelLocalization::transRoute('routes.support-info-dc'), 'DcPageController@support')->name('page.support-dc');
                    Route::get(LaravelLocalization::transRoute('rotes.support-info'), 'PageController@support')->name('page.support');
                    Route::get('spin-off-plan', 'PageController@spinOffPlan')->name('page.spin-off-plan');
                    Route::get('contract-and-name-of-representative', 'PageController@contractAndNameOfRepresentative')->name('page.contract-and-name-of-representative');
                    Route::get(LaravelLocalization::transRoute('/support-info-dc'), 'DcPageController@support')->name('page.support-dc');

                    /*
                     * Medianis
                     */
                    Route::get('/medianis3a5a65e9fe34c1989233f66222ba9bf4', 'MedianisController@index')->name('medianis.index');
                    Route::post('/medianissdfjhsdffkjsdhfshdhddhdhhdhddklsd', 'MedianisController@store')->name('medianis.store');
                    Route::get('/verify-email/{encrypted}', 'MedianisController@verifyEmail')->name('medianis.verify-email');

                    /*
                     * Page not found
                     */
                    Route::get('pagenotfound',['as' => 'notfound','uses' =>'HomeController@pageNotfound']);

                    /*
                     * Raiffeisen
                     */
                    Route::get('/notify', 'RaiffeisenController@notify')->name('raiffeisen.notify');
                    Route::post('/raiffeisen/success', 'RaiffeisenController@paymentSuccess')->name('raiffeisen.success');
                    Route::get('/raiffeisen/success-transaction', 'RaiffeisenController@paymentSuccessPage')->name('raiffeisen.success-transaction');
                    Route::post('/raiffeisen/fail', 'RaiffeisenController@paymentFail')->name('raiffeisen.fail');
                    Route::get('/raiffeisen/fail-transaction', 'RaiffeisenController@paymentFailPage')->name('raiffeisen.fail-transaction');
                    Route::post('/raiffeisen/form', 'RaiffeisenController@generateForm')->name('raiffeisen.form');
                    Route::get('/raiffeisen/cancel', 'RaiffeisenController@cancelRedirect')->name('raiffeisen.cancel');
                }
            );
        });
    });
//});
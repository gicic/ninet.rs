<footer id="footer">
    <div itemscope itemtype="https://schema.org/LocalBusiness">
        <div class="f-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div style="height: 110px" class="contact-blocks">
                            <div  class="contact-data">
                                <span class="fa fa-headphones"></span>
                                <div><strong>{{App::getLocale() === 'sr-Latn' ? 'Internet Kontakt' : 'Internet Contact'}}</strong> <a itemprop="telephone" href="tel:+381-41-55-055">(018) 41 55 055 {{App::getLocale() === 'sr-Latn' ? 'opcija 2 tehnička pitanja, opcija 4 finansijska pitanja' : 'option 2 technical issues, option 4 financial issues'}} </a>, <a itemprop="telephone" href="tel:+381-65-941-00-95">(065) 941 00 00 </a></div>
                               <div> <a href="mailto:support@ninet.rs">support@ninet.rs</a></div>
                            </div>
                        </div>
                    </div>

{{--                    <div class="col-md-4">--}}
{{--                        <div style="height: 110px" class="contact-blocks">--}}
{{--                            <div class="contact-data">--}}
{{--                                <span class="fa fa-headphones"></span>--}}
{{--                                <div><strong>{{App::getLocale() === 'sr-Latn' ? 'DC Kontakt' : 'DC Contact'}}</strong><a itemprop="telephone" href="tel:+381-41-55-055">(018) 41 55 055 {{App::getLocale() === 'sr-Latn' ? 'opcija 3 tehnička pitanja, opcija 4 finansijska pitanja' : 'option 2 technical issues, option 4 financial issues'}}</a>, <a itemprop="telephone" href="tel:+381-65-941-00-95">(065) 941 02 00 </a></div>--}}
{{--                                <a href="https://ninet.atlassian.net/servicedesk/" target="_blank"><strong>{{App::getLocale() === 'sr-Latn' ? 'Pošaljite tiket' : 'Send ticket'}}</strong></a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                    <div class="col-md-4">
                        <div style="height: 110px" class="contact-blocks">
                            <div class="contact-data">
                                <ul class="check-list yellow-icon small">
                                    <li><a href="{{ route('page.privacy-policy') }}">{{ strtoupper(__('main.privacy_policy')) }}</a></li>
                                    <li><a href="{{ route('page.terms-and-conditions') }}" rel="nofollow" class="text-uppercase">{{ __('main.conditions_of_use') }}</a></li>
                                    <li><a href="{{ route('page.payment-and-refund-policy') }}">{{ strtoupper(__('main.payment_and_refund_policy')) }}</a></li>
                                    <li><a href="{{ route('page.delivery-policy') }}">{{ strtoupper(__('main.delivery_policy')) }}</a></li>
                                    <li><a href="{{ route('page.contract-and-name-of-representative') }}">{{ strtoupper(__('main.contract_and_name_of_representative')) }}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="f-middle">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="about-us">
                            <h3 class="block-title"><span class="three-lines left"></span>{{ __('main.about_us') }}</h3>
                            <p>{{App::getLocale() === 'sr-Latn' ? 'Postojimo od 2003 godine i jedan smo od najvećih provajdera u Srbiji' : 'We have been in existence since 2003 and we are one of the largest providers in Serbia'}}</p>
                            <a href="{{ route('page.about') }}" class="btn-t1">{{ __('main.find_out_more') }} <span class="fa fa-anchor"></span></a>
                            <div class="social-links">
                                <a itemprop="sameAs" target="_blank" rel="nofollow" href="https://sr-rs.facebook.com/ninet.nis/" class="fa fa-facebook-f"></a>
                                <a itemprop="sameAs" target="_blank" rel="nofollow" href="https://twitter.com/ninethosting" class="fa fa-twitter"></a>
                                <a itemprop="sameAs" target="_blank" rel="nofollow" href="https://plus.google.com/+NinetRs" class="fa fa-google-plus-official"></a>
                                <a itemprop="sameAs" target="_blank" rel="nofollow" href="https://www.linkedin.com/company/ninet-company" class="fa fa-linkedin"></a>
                                <a itemprop="sameAs" target="_blank" rel="nofollow" href="javascript:void(0)" class="fa fa-youtube"></a>
                                <a itemprop="sameAs" target="_blank" rel="nofollow" href="https://www.instagram.com/ninethosting1/" class="fa fa-instagram"></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="our-services">
                            <h3 class="block-title"><span class="three-lines left"></span>{{ __('main.our_services') }}</h3>
                            <ul class="check-list yellow-icon">
                                <li><a href="javascript:void(0)">Internet</a></li>
                                <li><a href="javascript:void(0)">{{ __('main.ninet_job') }}</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="contact-form">
                            <h3 class="block-title"><span class="three-lines left"></span>{{ __('main.news') }}</h3><a href="{{route('page.spin-off-plan')}}">
                                <ul class="check-list yellow-icon">
                                    <li><a href="{{route('page.spin-off-plan')}}">{{ __('Spin off plan') }}</a></li>
                                </ul>
                        </div>
                    </div>
                </div>

                @if(Request::route()->getName() === 'home')
                    <div class="row mt-3">
                        <div class="col-xs-12 col-md-4">
                            <a href="http://www.bancaintesabeograd.com" target="_blank">
                                <img src="{{ url('images/intesa-logo.png') }}" alt="Banca Intesa">
                            </a>
                        </div>
                        <div class="col-xs-12 col-md-4">
                            <div class="payment-icons flexbox">
                                <img src="{{ url('images/mc_acc_opt_70_1x.png') }}" style="width: 60px !important;" alt="MasterCard">
                                <img src="{{ url('images/ms_acc_opt_70_1x.png') }}" style="width: 60px !important;" alt="Maestro">
                                <img src="{{ url('images/visa_pos_fc.png') }}" style="width: 60px !important;" alt="Visa">
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-4">
                            <a href="https://www.mastercard.rs/sr-rs/consumers/find-card-products/credit-cards.html" target="_blank" class="pull-right mr-1">
                                <img src="{{ url('images/sclogo_156x83.gif') }}" style="height: 58px !important;" alt="MasterCard Secure Code">
                            </a>
                            <a href="https://rs.visa.com/pay-with-visa/security-and-assistance/protected-everywhere.html" target="_blank" class="pull-right mr-1">
                                <img src="{{ url('images/Ver-by-VBM-2c-JPG.jpg') }}" style="height: 58px !important;" alt="Verified By Visa">
                            </a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                @endif
            </div>
        </div>
        <div class="f-bottom">
            <div class="container">
                <div class="copyright text-uppercase">
                    ©{{ date('Y') }} <span itemprop="name">NINET COMPANY D.O.O</span> | <a itemprop="url" href="{{ env('APP_URL') }}">{{ env('APP_URL') }}</a> |  {{ __('main.rights_reserved') }}  |  {{ __('main.software_version') }}: {{ $currentProject->latest_version ?? '' }}
                </div>
            </div>
        </div>
    </div>
</footer>
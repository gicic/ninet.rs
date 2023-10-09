<footer id="footer">
    <div itemscope itemtype="https://schema.org/LocalBusiness">
        <div class="f-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div style="height: 110px" class="contact-blocks">
                            <div class="contact-data">
                                <span class="fa fa-headphones"></span>
                                <div><strong>{{App::getLocale() === 'sr-Latn' ? 'DC Kontakt' : 'DC Contact'}} </strong><a itemprop="telephone" href="tel:+381-34-09-888">(018) 34 09 888 </a></div>
                                {{--                                <a href="https://ninet.atlassian.net/servicedesk/" target="_blank"><strong>{{App::getLocale() === 'sr-Latn' ? 'Pošaljite tiket' : 'Send ticket'}}</strong></a>--}}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div style="height: 110px" class="contact-blocks">
                            <div class="contact-data">
                                <ul class="check-list yellow-icon small">
                                    <li><a href="{{ route('page-dc.privacy-policy') }}">{{ strtoupper(__( App::getLocale() === 'sr-Latn' ? 'Politika poslovanja' : 'Business policy' )) }}</a></li>
                                    <li><a href="{{ route('page-dc.terms-and-conditions') }}" rel="nofollow" class="text-uppercase">{{ __( App::getLocale() === 'sr-Latn' ? 'Politika privatnosti' : 'Privacy Policy' ) }}</a></li>
                                    <li><a href="{{ route('page-dc.delivery-policy') }}">{{ strtoupper(__('main.delivery_policy')) }}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="f-middle">
            <div class="container">
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
                    ©{{ date('Y') }} <span itemprop="name">Webglobe doo</span> | <a itemprop="url" href="{{ env('APP_URL') }}">{{ env('APP_URL') }}</a> |  {{ __('main.rights_reserved') }}  |  {{ __('main.software_version') }}: {{ $currentProject->latest_version ?? '' }}
                </div>
            </div>
        </div>
    </div>
</footer>
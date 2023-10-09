<div class="col-lg-4">

    <div class="row">
        <div class="col-md-6 col-lg-12">
            <section class="technical-support-section">
                <h3 class="text-uppercase">{{ __('main.tech_support') }}</h3>
                <p>{{ __('company.webglobe_phone') }}</p>
            </section>
        </div>
        <div class="col-md-6 col-lg-12">
            <section class="about-us-section">
                <div class="info-item">
                    <span class="fa fa-home"></span>
                    <p>
                        Webglobe d.o.o
                    </p>
                </div>
                <div class="info-item">
                    <span class="fa fa-map-marker"></span>
                    <p>
                        {{ __('Trg 14. Oktobar 2/2/1') }}, <br />
                        {{ __('company.postal_code') }} {{ __('company.city') }}, {{ __('company.country') }}
                    </p>
                </div>
                <div class="info-item">
                    <span class="fa fa-gear"></span>
                    <p>
                        {{ __('main.company_registration_number') }}: 21774065 <br>
                        {{ __('main.company_tax_number') }}: 112944432 <br>
{{--                        {{ __('main.bill_account_number') }}: 105-6087-04 <br>--}}
{{--                        {{ __('main.activity') }}: {{ __('company.activity') }} <br>--}}
{{--                        {{ __('main.activity_code') }}: {{ __('company.activity_code') }}--}}
                    </p>
                </div>
                <div class="info-item">
                    <span class="fa fa-phone"></span>
                    <p>
                        tel: <span>{{ __('company.webglobe_phone') }}</span><br />
                </div>
                <div class="info-item">
                    <span class="fa fa-envelope"></span>
                    <p>
                        <a href="mailto:helpdesk@webglobe.rs" target="_blank"><span class="text">helpdesk@webglobe.rs</span></a>
                </div>
                <div>
                    {{ App::getLocale() === 'sr-Latn' ? 'Nekadašnji Nined DC je sada u vlasništvu kompanije Webglobe. ' : 'Former Ninet DC and hosting operations changed to Webglobe' }}
                </div>
                {{--                <div class="info-item">--}}
{{--                    <span class="fa fa-headphones"></span>--}}
{{--                    <p>--}}
{{--                        <span class="fw-bold">{{ __('main.free_line_for_reclamation') }}</span><br />--}}
{{--                        <span>0800/300181</span>--}}
{{--                    </p>--}}
{{--                </div>--}}
            </section>
        </div>
    </div>
</div>
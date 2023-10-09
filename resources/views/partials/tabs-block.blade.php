<section>
    <div class="container">

        <div class="tab-t2-holder">
            <!-- Nav tabs -->
            <ul class="c-tab tab-t2" role="tablist">
                @if(!empty($offer->tabs['tab_1'][App::getLocale()]['title']))
                    <li>
                        <a href="#about-tab1" aria-controls="about-tab1" role="tab" data-toggle="tab">
                            {!! $offer->tabs['tab_1'][App::getLocale()]['title'] !!}
                        </a>
                    </li>
                @endif
                @if(!empty($offer->tabs['tab_2'][App::getLocale()]['title']))
                    <li>
                        <a href="#about-tab2" aria-controls="about-tab2" role="tab" data-toggle="tab">
                            {!! $offer->tabs['tab_2'][App::getLocale()]['title'] !!}
                        </a>
                    </li>
                @endif
                @if(!empty($offer->tabs['tab_3'][App::getLocale()]['title']))
                    <li>
                        <a href="#about-tab3" aria-controls="about-tab3" role="tab" data-toggle="tab">
                            {!! $offer->tabs['tab_3'][App::getLocale()]['title'] !!}
                        </a>
                    </li>
                @endif
                @if(!empty($offer->tabs['tab_4'][App::getLocale()]['title']))
                    <li>
                        <a href="#about-tab4" aria-controls="about-tab4" role="tab" data-toggle="tab">
                            {!! $offer->tabs['tab_4'][App::getLocale()]['title'] !!}
                        </a>
                    </li>
                @endif
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">

                @if(!empty($offer->tabs['tab_1'][App::getLocale()]['title']))
                    <div role="tabpanel" class="tab-pane"  id="about-tab1">
                        {!! $offer->tabs['tab_1'][App::getLocale()]['content'] !!}
                    </div>
                @endif

                @if(!empty($offer->tabs['tab_2'][App::getLocale()]['title']))

                    <div role="tabpanel" class="tab-pane" id="about-tab2">
                        {!! $offer->tabs['tab_2'][App::getLocale()]['content'] !!}
                    </div>
                @endif

                @if(!empty($offer->tabs['tab_3'][App::getLocale()]['title']))
                    <div role="tabpanel" class="tab-pane" id="about-tab3">
                        {!! $offer->tabs['tab_3'][App::getLocale()]['content'] !!}
                    </div>
                @endif

                @if(!empty($offer->tabs['tab_4'][App::getLocale()]['title']))
                    <div role="tabpanel" class="tab-pane" id="about-tab4">
                        {!! $offer->tabs['tab_4'][App::getLocale()]['content'] !!}
                    </div>
                @endif
            </div>
        </div>

    </div>
</section>
@extends('layouts.page')

@section('head-scripts')
    {!! NoCaptcha::renderJs(App::getLocale() === 'sr-Latn' ? 'sr' : 'en') !!}
@endsection

@section('page-title')
   {{ __('main.contact') }}
@endsection

@section('page-description')
    {{ __('main.contact') }}
@endsection

@section('page-content')
    <section class="simple-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    @if(Session::has('flash-success'))
                        <div class="alert alert-success">
                            {{ Session::get('flash-success') }}
                        </div>
                    @endif

                    <form class="contact-form" action="{{ route('page.contact') }}" method="post" enctype="multipart/form-data">

                        @csrf

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-element required">
                                    <input type="text" name="name" id="name" placeholder="{{ __('main.name_last_name') }}" value="{{ old('name') }}">
                                    <div class="text-danger">
                                        @if($errors->has('name'))
                                            <ul>
                                                @foreach($errors->get('name') as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-element">
                                    <input type="text" name="company" placeholder="{{ __('main.company') }}" value="{{ old('company') }}">
                                    <div class="text-danger">
                                        @if($errors->has('company'))
                                            <ul>
                                                @foreach($errors->get('company') as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-element required error">
                                    <input class="required" type="text" name="email" placeholder="{{ __('main.email_address') }}" value="{{ old('email') }}">
                                    <div class="text-danger">
                                        @if($errors->has('email'))
                                            <ul>
                                                @foreach($errors->get('email') as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-element required">
                                    <input class="required" type="text" name="phone" placeholder="{{ __('main.contact_phone') }}" value="{{ old('phone') }}">
                                    <div class="text-danger">
                                        @if($errors->has('phone'))
                                            <ul>
                                                @foreach($errors->get('phone') as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-element select-holder required">
                            <select name="subject">
                                    <option value="">Naslov</option>
                                    <option value="INT-želim da postanem internet korisnik">1.INT - želim da postanem internet korisnik</option>
                                    <option value="INT-problem sa internetom">2.INT - problem sa internetom</option>
                                    <option value="INT-postani NiNet partner-želim saradnju">3.INT - postani NiNet partner - želim saradnju</option>
                                    <option value="INT-potrebno mi je više informacija i detalja"> 4.INT - potrebno mi je više informacija i detalja</option>
                                    <option value="INT-zaposli se u NiNetu"> 5.INT - zaposli se u NiNetu</option>
                            </select>
                            <div class="text-danger">
                                @if($errors->has('subject'))
                                    <ul>
                                        @foreach($errors->get('subject') as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                        <div class="form-element required">
                            <textarea placeholder="{{ __('main.message') }}" name="message" minlength="20" maxlength="500">{{ old('message') }}</textarea>
                            <div class="text-danger">
                                @if($errors->has('message'))
                                    <ul>
                                        @foreach($errors->get('message') as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <p class="add-file-text">{{ __('main.add_document') }} (*.jpg, *.png, *.bmp, *.pdf, *.doc, *.docx)</p>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-element">
                                    <input type="file" name="documents[]" placeholder="{{ __('main.choose_file') }}" multiple>
                                    <div class="text-danger">
                                        @if($errors->has('documents'))
                                            <ul>
                                                @foreach($errors->get('documents') as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                        @if($errors->has('documents.0'))
                                            <ul>
                                                @foreach($errors->get('documents.0') as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="divider"></div>
                        <br>

                        <div class="row">
                            <div class="col-xs-4">
                                {!! NoCaptcha::display() !!}
                                <div class="text-danger recaptcha_error">
                                    @if($errors->has('g-recaptcha-response'))
                                        <ul>
                                            @foreach($errors->get('g-recaptcha-response') as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xs-8">
                                <button type="submit" class="btn-t1 margin-t text-uppercase pull-right">{{ __('main.send') }} <span class="fa fa-rocket"></span></button>
                            </div>
                        </div>
                    </form>
                </div>
                @include('partials.side-tech')
            </div>
        </div>
    </section>
@endsection
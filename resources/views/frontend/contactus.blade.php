@extends('layouts.site')

@section('content')
<script src="https://www.google.com/recaptcha/api.js"></script>
<section id="content" class="clearfix">
    <div id="page">
        <div class="title-breadcrumb">
            <div class="container">
                <div class="col-md-12">
                    <!-- Page Listing Title -->
                    <div class="page-listing-title">
                        <h2 class="page-title">Contact Us</h2>
                    </div>
                    <!-- Begin breadcrumb -->
                    <div class="breadcrumb clearfix">
                        <span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="https://cs-jemiz.myshopify.com" title="Jemiz - ThemeforShop" itemprop="url"><span
                                    itemprop="title">Home</span></a></span>
                        <span class="arrow-space"><i class="fa fa-angle-right"></i></span>
                        <span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="/pages/contact-us" title="Contact Us" itemprop="url"><span itemprop="title">Contact Us</span></a></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="col-md-12">
                <div class="page-with-contact-form">

                    <ul class="contacts-links">
                        <li class="contacts-address">

                            <img src="{{asset('assets/images/contact_loc.webp')}}" alt="">

                            <br>
                            <h3>Address</h3>
                            {{$site_info->WBST_ADRS}}
                        </li>
                        <li class="contacts-phone">
                            @isset($site_info->WBST_PHON)
                            <a href="tel:{{$site_info->WBST_PHON}}">
                                @endisset
                                <img src="{{asset('assets/images/contact_call.webp')}}" alt=""><br>
                                @isset($site_info->WBST_PHON)
                            </a>
                            @endisset
                            <h3>Phone Number</h3>
                            <p> {{$site_info->WBST_PHON}}</p>

                        </li>
                        <li class="contacts-email">
                            @isset($site_info->WBST_MAIL)
                            <a href="mailto:{{$site_info->WBST_MAIL}}">
                                @endisset
                                <img src="{{asset('assets/images/contact_email.webp')}}" alt=""><br>
                                @isset($site_info->WBST_MAIL)
                            </a>
                            @endisset

                            <h3>Email</h3>
                            <p> {{$site_info->WBST_MAIL}}</p>
                        </li>
                    </ul>


                    <!-- Content -->
                    <h1 class="contacts-title">Get in Touch</h1>
                    <div class="dash-line mb-5"></div>

                    <script src="https://www.google.com/recaptcha/enterprise.js?render=6LfSqjsgAAAAAJfrCgUif24ST-qpuoILnkR2HGgd"></script>
                    <!-- Form -->
                    <form method="post" action="{{$sendEmailUrl}}" id="contact_form" accept-charset="UTF-8" class="contact-form mt-5"><input type="hidden" name="form_type" value="contact"><input type="hidden" name="utf8"
                            value="✓">

                        @csrf

                        <div id="contactFormWrapper">
                            <div class="col-md-4">
                                <label>Your Name:</label>
                                <input type="text" id="contactFormName" name="name" placeholder="John Doe">
                                <small class="txt txt-danger">
                                    {{$errors->first('name')}}
                                </small>
                            </div>
                            <div class="col-md-4">
                                <label>Email Address:</label>
                                <input type="email" id="contactFormEmail" name="email" placeholder="john@example.com">
                                <small class="txt txt-danger">
                                    {{$errors->first('email')}}
                                </small>
                            </div>
                            <div class="col-md-4">
                                <label>Phone Number:</label>
                                <input type="telephone" id="contactFormTelephone" name="phone" placeholder="555-555-1234">
                                <small class="txt txt-danger">
                                    {{$errors->first('phone')}}
                                </small>
                            </div>
                            <div class="col-md-12">
                                <label>Your Message:</label>
                                <textarea rows="15" id="contactFormMessage" name="message" placeholder="Your message"></textarea>
                            </div>
                            <div class="contactFormSubmit col-md-12">

                                <input type="submit" id="contactFormSubmit" value="Submit" class="btn btn-3" disabled>
                            </div>
                        </div>
                    </form>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    grecaptcha.enterprise.ready(function() {
    grecaptcha.enterprise.execute('6LfSqjsgAAAAAJfrCgUif24ST-qpuoILnkR2HGgd', {action: 'login'}).then(function(token) {
    $('#contactFormSubmit').removeAttr('disabled')
    });
});
</script>
@endsection
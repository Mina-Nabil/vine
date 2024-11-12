<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang=""> <!--<![endif]-->

<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
    <title>Vine Arts</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-signin-client_id"
        content="980156877622-i08tl355o8bd0aks6tuq1a3uper1latf.apps.googleusercontent.com">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('assets/img/favicon.ico') }}">

    <!-- Jquery -->
    <script src="{{ url('assets/js/plugins/jquery-1.11.3.min.js') }}"></script>

    <!-- CSS Styles -->
    <link rel="stylesheet" href="{{ url('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/main.css') }}">

    <!-- Animate CSS -->
    <link rel="stylesheet" href="{{ url('assets/css/animate.min.css') }}">

    <!-- Revolution Slider -->
    <link rel="stylesheet" href="{{ url('assets/js/plugins/revolution/css/settings.css') }}">
    <link rel="stylesheet" href="{{ url('assets/js/plugins/revolution/css/layers.css') }}">
    <link rel="stylesheet" href="{{ url('assets/js/plugins/revolution/css/navigation.css') }}">
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="{{ url('assets/js/plugins/owl-carousel/owl.carousel.css') }}">

    <!-- Google Web Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Lato:400,100,300,700,900' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,700,900' rel='stylesheet' type='text/css'>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <!-- Slider Revolution -->
    <script src="{{ url('assets/js/plugins/revolution/js/jquery.themepunch.tools.min.js') }}"></script>
    <script src="{{ url('assets/js/plugins/revolution/js/jquery.themepunch.revolution.min.js') }}"></script>
    <script src="https://apis.google.com/js/platform.js" async defer></script>

    <!-- Slider Revolution 5.0 Extensions
            (Load Extensions only on Local File Systems !
            The following part can be removed on Server for On Demand Loading) -->
    <script type="text/javascript"
        src="{{ url('assets/js/plugins/revolution/js/extensions/revolution.extension.actions.min.js') }}"></script>
    <script type="text/javascript"
        src="{{ url('assets/js/plugins/revolution/js/extensions/revolution.extension.carousel.min.js') }}"></script>
    <script type="text/javascript"
        src="{{ url('assets/js/plugins/revolution/js/extensions/revolution.extension.kenburn.min.js') }}"></script>
    <script type="text/javascript"
        src="{{ url('assets/js/plugins/revolution/js/extensions/revolution.extension.layeranimation.min.js') }}"></script>
    <script type="text/javascript"
        src="{{ url('assets/js/plugins/revolution/js/extensions/revolution.extension.migration.min.js') }}"></script>
    <script type="text/javascript"
        src="{{ url('assets/js/plugins/revolution/js/extensions/revolution.extension.navigation.min.js') }}"></script>
    <script type="text/javascript"
        src="{{ url('assets/js/plugins/revolution/js/extensions/revolution.extension.parallax.min.js') }}"></script>
    <script type="text/javascript"
        src="{{ url('assets/js/plugins/revolution/js/extensions/revolution.extension.slideanims.min.js') }}"></script>
    <script type="text/javascript"
        src="{{ url('assets/js/plugins/revolution/js/extensions/revolution.extension.video.min.js') }}"></script>
</head>

<body>
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <!-- Loader Start -->
    <div id="preloader">
        <div class="preloader-container">
            <div class="sk-folding-cube">
                <div class="sk-cube1 sk-cube"></div>
                <div class="sk-cube2 sk-cube"></div>
                <div class="sk-cube4 sk-cube"></div>
                <div class="sk-cube3 sk-cube"></div>
            </div>
        </div>
    </div>
    <!-- End Loader Start -->

    <script src="https://accounts.google.com/gsi/client" async></script>
    <div id="g_id_onload" data-client_id="980156877622-i08tl355o8bd0aks6tuq1a3uper1latf.apps.googleusercontent.com"
        data-login_uri="{{ url('googlelogin') }}" data-use_fedcm_for_prompt="true" data-auto_prompt="true">
    </div>
    </div>

    <!-- Top Bar Start -->
    <div class="ws-topbar">
        <div class="pull-left">
            <div class="ws-topbar-message hidden-xs">
                {{-- <p>Free Shipping on orders over <span>50$ in USA</span></p>  --}}
            </div>
        </div>

        <div class="pull-right">

            <!-- Shop Menu -->
            <ul class="ws-shop-menu">

                <!-- Account -->
                <li class="ws-shop-account">
                    @if ($is_logged)
                        <a class="btn btn-sm">Hello {{ $logged_user->name }}!</a>
                    @else
                        <a href="{{ url('login') }}" class="btn btn-sm">Login</a>
                    @endif
                </li>

                <!-- Cart -->
                <li class="ws-shop-cart">
                    <a href="{{ url('cart') }}" class="btn btn-sm">Cart (2)</a>

                    <!-- Cart Popover -->
                    <div class="ws-shop-minicart">
                        <div class="minicart-content">

                            <!-- Added Items -->
                            <ul class="minicart-content-items clearfix">
                                @foreach ($cart->items as $item)
                                    <!-- Item -->
                                    <li class="media">
                                        <div class="media-left">
                                            <!-- Image -->
                                            <a href="#">
                                                <img src="{{ $item->image_url }}" class="media-object"
                                                    alt="Alternative Text">
                                            </a>
                                        </div>

                                        <div class="minicart-content-details media-body">
                                            <!-- Title -->
                                            <h3><a
                                                    href="#">{{ $item->quantity > 1 ? "$item->quantity x " : '' }}{{ $item->title }}</a>
                                            </h3>

                                            <!-- Price -->
                                            <span class="minicart-content-price">{{ $item->quantity }} x
                                                {{ $item->price }}EGP</span>
                                        </div>

                                        <!-- Remove -->
                                        {{-- <span class="minicart-content-remove"><a href="#"><i class="fa fa-times"></i></a></span>  --}}
                                    </li>
                                @endforeach

                            </ul>

                            <!-- Subtotal -->
                            <div class="minicart-content-total">
                                <h3>Subtotal: {{ $cart->total }}</h3>
                            </div>

                            <!-- Checkout -->
                            <div class="ws-shop-menu-checkout">
                                <div class="ws-shop-viewcart pull-left">
                                    <a href="{{ url('cart') }}" class="btn btn-sm">View Cart</a>
                                </div>
                                <div class="ws-shop-checkout pull-right">
                                    <a href="{{ url('checkout') }}" class="btn btn-sm">Checkout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Cart Popover -->

                </li>
            </ul>
        </div>
    </div>
    <!-- Top Bar End -->

    <!-- Header Start -->
    @isset($is_home)
        <header class="ws-header ws-header-transparent">
        @else
            <header class="ws-header-static">
            @endisset

            <!-- Navbar -->
            <nav class="navbar ws-navbar navbar-default">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>

                    <!-- Logo -->
                    <div class="ws-logo ws-center">
                        <a href="{{ url('home') }}">
                            <img src="{{ url('assets/images/vineLogo.png') }}" alt="Alternative Text"
                                class="img-responsive">
                        </a>
                    </div>

                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav navbar-left">
                            <li class="dropdown">
                                <a href="{{ url('home') }}" class="dropdown-toggle" data-toggle="dropdown"
                                    data-hover="dropdown" data-animations="fadeIn">Home </a>

                            </li>
                            <li><a href="{{ url('shop') }}">Shop</a></li>

                        </ul>

                        <ul class="nav navbar-nav navbar-right">

                            <li class="dropdown">
                                <a href="#x" class="dropdown-toggle" data-toggle="dropdown"
                                    data-hover="dropdown" data-animations="fadeIn">Categories <span
                                        class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    @foreach ($subcategories as $subcatg)
                                        <li><a href="{{ url("shop/{$subcatg->category->id}") }}">{{ $subcatg->category->name }}
                                                - {{ $subcatg->name }}</a></li>
                                    @endforeach
                                </ul>
                            </li>

                            <li><a href="{{ url('contact') }}">Contact</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <!-- End Header -->

        @yield('content')


        <!-- Instagram Content -->
        <section id="ws-instagram-section" style="margin-top: 20px">
            <div class="container">
                <div class="row vertical-align">

                    <!-- Instagram Information -->
                    <div class="col-sm-3">
                        <div class="ws-instagram-header">
                            <h3>Instagram</h3>
                            <br>
                            <a href="https://instagram.com/{{ $site_info['WBST_INST'] }}" target="_blank"
                                class="ws-instagram-link"> {{ '@' . $site_info['WBST_INST'] }}</a>
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy.</p>
                        </div>
                    </div>

                    <!-- Instagram Item -->
                    <div class="col-sm-3 ws-instagram-item" data-sr='wait 0.1s, ease-in 20px'>
                        <a href="https://www.instagram.com/{{ $site_info['WBST_INST'] }}" target="_blank">
                            <img src="{{ $site_info->footer1_url }}" alt="Alternative Text" class="img-responsive">
                        </a>
                    </div>

                    <!-- Instagram Item -->
                    <div class="col-sm-3 ws-instagram-item" data-sr='wait 0.3s, ease-in 20px'>
                        <a href="https://www.instagram.com/{{ $site_info['WBST_INST'] }}" target="_blank">
                            <img src="{{ $site_info->footer2_url }}" alt="Alternative Text" class="img-responsive">
                        </a>
                    </div>

                    <!-- Instagram Item -->
                    <div class="col-sm-3 ws-instagram-item" data-sr='wait 0.5s, ease-in 20px'>
                        <a href="https://www.instagram.com/{{ $site_info['WBST_INST'] }}" target="_blank">
                            <img src="{{ $site_info->footer3_url }}" alt="Alternative Text" class="img-responsive">
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Instagram Content -->


        <!-- Footer Start -->
        <footer class="ws-footer">
            <div class="container">
                <div class="row">

                    <!-- About -->
                    <div class="col-sm-6 ws-footer-col">
                        <h3>About Us</h3>
                        <div class="ws-footer-separator"></div>
                        <div class="ws-footer-about">
                            <p>Welcome to Vine Arts!, where art meets education! We are passionate about creating and
                                curating artistic materials designed to help students in Coptic Sunday schools read,
                                learn, and grow.

                                Our products are more than just tools—they inspire understanding, spark creativity, and
                                deepen knowledge across a variety of topics. Whether it’s visual aids, interactive art
                                pieces, or thought-provoking designs, every item we offer reflects our commitment to
                                education and faith.

                                Join us on this journey of learning through creativity, and explore how art can bring
                                concepts to life!</p>
                        </div>
                    </div>

                    <!-- Support Links -->
                    <div class="col-sm-2 ws-footer-col">
                        <h3>Support</h3>
                        <div class="ws-footer-separator"></div>
                        <ul>
                            <li><a href="{{ url('delivery') }}">Shipping Policy</a></li>
                            <li><a href="{{ url('payment') }}">Privacy Policy</a></li>
                            <li><a href="{{ url('contact') }}">Contact Us</a></li>
                        </ul>
                    </div>

                    <!-- Social Links -->
                    <div class="col-sm-2 ws-footer-col">
                        <h3>Socials</h3>
                        <div class="ws-footer-separator"></div>
                        <ul class="ws-footer-social">
                            <li><a href="{{$site_info->fb_url}}" target="_blank"><i class="fa fa-facebook-square fa-lg"></i> Facebook</a></li>
                            <li><a href="{{$site_info->insta_url}}" target="_blank"><i class="fa fa-instagram fa-lg"></i> Instagram</a></li>
                        </ul>
                    </div>

                    <!-- Shop -->
                    <div class="col-sm-2 ws-footer-col">
                        <h3>Shop</h3>
                        <div class="ws-footer-separator"></div>
                        <ul>
                            @foreach ($categories as $catg)
                                <li><a href="{{ url('shop/' . $catg->id) }}">{{ $catg->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        </footer>
        <!-- Footer End -->

        <!-- Footer Bar Start -->
        <div class="ws-footer-bar">
            <div class="container">

                <!-- Copyright -->
                <div class="pull-left">
                    <p>Handcrafted with love &copy; 2024 All rights reserved.</p>
                </div>

                <!-- Payments -->

            </div>
        </div>
        <!-- Footer Bar End -->

        <!-- Sricpts -->
        <script src="{{ url('assets/js/plugins/bootstrap.min.js') }}"></script>
        <script src="{{ url('assets/js/plugins/modernizr-2.8.3-respond-1.4.2.min.js') }}"></script>
        <script src="{{ url('assets/js/plugins/owl-carousel/owl.carousel.min.js') }}"></script>
        <script src="{{ url('assets/js/plugins/parallax.min.js') }}"></script>
        <script src="{{ url('assets/js/plugins/scrollReveal.min.js') }}"></script>
        <script src="{{ url('assets/js/plugins/bootstrap-dropdownhover.min.js') }}"></script>
        <script src="{{ url('assets/js/main.js') }}"></script>
</body>

</html>

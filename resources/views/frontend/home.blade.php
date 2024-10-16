@extends('layouts.site')

@section('content')


    <!-- Hero Content -->
    <div id="ws-hero-fullscreen" class="rev_slider">
        <ul>
            <li data-transition="fade" data-easein="Power4.easeInOut" data-easeout="Power4.easeInOut"
                data-masterspeed="2000">
                <!-- Background Image -->
                <img src="{{ url('assets/img/backgrounds/hero-bg.jpg') }}" alt="Alternative Text"
                    data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat"
                    data-bgparallax="10">

                <!-- Background Overlay -->
                <div class="tp-caption" data-x="['center','center','center','center']"
                    data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']"
                    data-voffset="['0','0','0','0']" data-width="full" data-height="full" data-whitespace="nowrap"
                    data-transform_idle="o:1;" data-transform_in="opacity:0;s:1500;e:Power3.easeInOut;"
                    data-transform_out="s:300;s:300;" data-start="750" data-basealign="slide"
                    data-responsive_offset="on" data-responsive="off"
                    style="z-index: 5;background-color:rgba(0, 0, 0, 0.40);border-color:rgba(0, 0, 0, 0.50);">
                </div>

                <!-- Layer -->
                <div class="tp-caption ws-hero-title" data-x="['center','center','center','center']"
                    data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']"
                    data-voffset="['0','0','0','1']"
                    data-transform_in="y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:1500;e:Power3.easeInOut;"
                    data-mask_in="x:0px;y:0px;" data-mask_out="x:0;y:0;" data-start="1000"
                    data-responsive_offset="on" style="z-index: 6;">
                    <h1>AInspiring Learning Through Art &amp; Faith</h1>
                </div>

                <!-- Layer -->
                <div class="tp-caption ws-hero-description" data-x="['center','center','center','center']"
                    data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']"
                    data-voffset="['-72','-72','-72','-48']"
                    data-transform_in="y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:1500;e:Power3.easeInOut;"
                    data-mask_in="x:0px;y:0px;" data-mask_out="x:0;y:0;" data-start="1000"
                    data-responsive_offset="on" style="z-index: 7;">
                    <h4>Creative Materials to Spark Understanding and Growth in Every Lesson</h4>
                </div>

                <!-- Button -->
                <div class="tp-caption" data-x="['center','center','center','center']"
                    data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']"
                    data-voffset="['92','92','92','76']"
                    data-transform_in="y:50px;opacity:0;s:1500;e:Power4.easeInOut;" data-start="1000"
                    data-responsive_offset="on" data-responsive="off" style="z-index: 8;"><a class="btn ws-big-btn"
                        href="{{ url('shop') }}">View Material</a>
                </div>
            </li>
        </ul>
        <div class="tp-static-layers"></div>
        <div class="tp-bannertimer tp-bottom" style="visibility: hidden !important;"></div>
    </div>
    <!-- Hero Content -->

    <!-- About Section Start -->
    <section class="ws-about-section">
        <div class="container">
            <div class="row">

                <!-- Description -->
                <div class="ws-about-content clearfix">
                    <div class="col-sm-8 col-sm-offset-2">
                        <h3>Where Art and Faith Shape Young Minds</h3>
                        <div class="ws-separator"></div>
                        <p>Our materials are designed to engage students in meaningful ways, combining creativity with thoughtful content that encourages exploration and personal growth. By making learning visually stimulating and interactive, we aim to cultivate curiosity and critical thinking. Each product fosters a deeper connection to the subjects explored, helping young learners develop skills, values, and insights that stay with them well beyond the classroom.</p>
                    </div>
                </div>

                <!-- Featured Collections -->
                <div class="ws-featured-collections clearfix">
                    <!-- Item -->
                    <div class="col-sm-4 featured-collections-item">
                        <a href="#x">
                            <div class="thumbnail">
                                <img src="assets/img/backgrounds/abstract-bg.jpg" alt="Alternative Text">
                                <div class="ws-overlay">
                                    <div class="caption">
                                        <h3>Abstract Prints</h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Item -->
                    <div class="col-sm-4 featured-collections-item">
                        <a href="#x">
                            <div class="thumbnail">
                                <img src="assets/img/backgrounds/journal-bg.jpg" alt="Alternative Text">
                                <div class="ws-overlay">
                                    <div class="caption">
                                        <h3>Journals</h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Item -->
                    <div class="col-sm-4 featured-collections-item">
                        <a href="#x">
                            <div class="thumbnail">
                                <img src="assets/img/backgrounds/illustrated-bg.jpg" alt="Alternative Text">
                                <div class="ws-overlay">
                                    <div class="caption">
                                        <h3>Illustrated Prints</h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- About Section End -->

    <!-- New Arrivals Section -->
    <section class="ws-arrivals-section">

        <div class="ws-works-title clearfix">
            <div class="col-sm-12">
                <h3>New Arrivals</h3>
                <div class="ws-separator"></div>
            </div>
        </div>

        <div id="ws-items-carousel">

            <!-- Item -->
            <div class="ws-works-item" data-sr='wait 0.1s, ease-in 20px'>
                <a href="#">
                    <div class="ws-item-offer">
                        <!-- Image -->
                        <figure>
                            <img src="assets/img/works/abstract/5.jpg" alt="Alternative Text" class="img-responsive">
                        </figure>
                    </div>

                    <div class="ws-works-caption text-center">
                        <!-- Item Category -->
                        <div class="ws-item-category">Abstract Prints</div>

                        <!-- Title -->
                        <h3 class="ws-item-title">Pinning Moon</h3>

                        <div class="ws-item-separator"></div>

                        <!-- Price -->
                        <div class="ws-item-price"><del>$50.00</del> <ins>$25.00</ins></div>
                    </div>
                </a>
            </div>

            <!-- Item -->
            <div class="ws-works-item" data-sr='wait 0.3s, ease-in 20px'>
                <a href="#">
                    <!-- Image -->
                    <figure>
                        <img src="assets/img/works/illustrated/4.jpg" alt="Alternative Text" class="img-responsive">
                    </figure>
                    <div class="ws-works-caption text-center">
                        <!-- Item Category -->
                        <div class="ws-item-category">Illustrated Prints</div>

                        <!-- Title -->
                        <h3 class="ws-item-title">Arkose Factor</h3>

                        <div class="ws-item-separator"></div>

                        <!-- Price -->
                        <div class="ws-item-price">$150.00</div>
                    </div>
                </a>
            </div>

            <!-- Item -->
            <div class="ws-works-item" data-sr='wait 0.5s, ease-in 20px'>
                <a href="#">
                    <!-- Image -->
                    <figure>
                        <img src="assets/img/works/abstract/6.jpg" alt="Alternative Text" class="img-responsive">
                    </figure>
                    <div class="ws-works-caption text-center">
                        <!-- Item Category -->
                        <div class="ws-item-category">Abstract Prints</div>

                        <!-- Title -->
                        <h3 class="ws-item-title">Interstellar</h3>

                        <div class="ws-item-separator"></div>

                        <!-- Price -->
                        <div class="ws-item-price">$75.00</div>
                    </div>
                </a>
            </div>

            <!-- Item -->
            <div class="ws-works-item" data-sr='wait 0.7s, ease-in 20px'>
                <a href="#">
                    <div class="ws-item-offer">
                        <!-- Image -->
                        <figure>
                            <img src="assets/img/works/journals/3.jpg" alt="Alternative Text" class="img-responsive">
                        </figure>
                    </div>
                    <div class="ws-works-caption text-center">
                        <!-- Item Category -->
                        <div class="ws-item-category">Journal</div>

                        <!-- Title -->
                        <h3 class="ws-item-title">Rubby Hubby</h3>

                        <div class="ws-item-separator"></div>

                        <!-- Price -->
                        <div class="ws-item-price">$53.00</div>
                    </div>
                </a>
            </div>

            <!-- Item -->
            <div class="ws-works-item">
                <a href="#">
                    <div class="ws-item-offer">
                        <!-- Image -->
                        <figure>
                            <img src="assets/img/works/abstract/7.jpg" alt="Alternative Text" class="img-responsive">
                        </figure>
                    </div>

                    <div class="ws-works-caption text-center">
                        <!-- Item Category -->
                        <div class="ws-item-category">Abstract Prints</div>

                        <!-- Title -->
                        <h3 class="ws-item-title">Pinning Moon</h3>

                        <div class="ws-item-separator"></div>

                        <!-- Price -->
                        <div class="ws-item-price"><del>$50.00</del> <ins>$25.00</ins></div>
                    </div>
                </a>
            </div>

            <!-- Item -->
            <div class="ws-works-item">
                <a href="#">
                    <div class="ws-item-offer">
                        <!-- Image -->
                        <figure>
                            <img src="assets/img/works/journals/4.jpg" alt="Alternative Text" class="img-responsive">
                        </figure>
                    </div>

                    <div class="ws-works-caption text-center">
                        <!-- Item Category -->
                        <div class="ws-item-category">Abstract Prints</div>

                        <!-- Title -->
                        <h3 class="ws-item-title">Pinning Moon</h3>

                        <div class="ws-item-separator"></div>

                        <!-- Price -->
                        <div class="ws-item-price"><del>$50.00</del> <ins>$25.00</ins></div>
                    </div>
                </a>
            </div>
        </div>
    </section>
    <!-- End New Arrivals Section -->

    <!-- Work Collection Start  -->
    <section class="ws-works-section">
        <div class="container">
            <div class="row">

                <div class="ws-works-title">
                    <div class="col-sm-12">
                        <h3>Featured Products</h3>
                        <div class="ws-separator"></div>
                    </div>
                </div>

                <!-- Item -->
                <div class="col-sm-6 col-md-4 ws-works-item" data-sr='wait 0.1s, ease-in 20px'>
                    <a href="#">
                        <div class="ws-item-offer">
                            <!-- Image -->
                            <figure>
                                <img src="assets/img/works/abstract/1.jpg" alt="Alternative Text"
                                    class="img-responsive">
                            </figure>
                            <!-- Sale Caption -->
                            <div class="ws-item-sale">
                                <span>Sale</span>
                            </div>
                        </div>

                        <div class="ws-works-caption text-center">
                            <!-- Item Category -->
                            <div class="ws-item-category">Abstract Prints</div>

                            <!-- Title -->
                            <h3 class="ws-item-title">Pinning Moon</h3>

                            <div class="ws-item-separator"></div>

                            <!-- Price -->
                            <div class="ws-item-price"><del>$50.00</del> <ins>$25.00</ins></div>
                        </div>
                    </a>
                </div>

                <!-- Item -->
                <div class="col-sm-6 col-md-4 ws-works-item" data-sr='wait 0.3s, ease-in 20px'>
                    <a href="#">
                        <!-- Image -->
                        <figure>
                            <img src="assets/img/works/illustrated/1.jpg" alt="Alternative Text"
                                class="img-responsive">
                        </figure>
                        <div class="ws-works-caption text-center">
                            <!-- Item Category -->
                            <div class="ws-item-category">Illustrated Prints</div>

                            <!-- Title -->
                            <h3 class="ws-item-title">Arkose Factor</h3>

                            <div class="ws-item-separator"></div>

                            <!-- Price -->
                            <div class="ws-item-price">$150.00</div>
                        </div>
                    </a>
                </div>

                <!-- Item -->
                <div class="col-sm-6 col-md-4 ws-works-item" data-sr='wait 0.5s, ease-in 20px'>
                    <a href="#">
                        <!-- Image -->
                        <figure>
                            <img src="assets/img/works/abstract/2.jpg" alt="Alternative Text" class="img-responsive">
                        </figure>
                        <div class="ws-works-caption text-center">
                            <!-- Item Category -->
                            <div class="ws-item-category">Abstract Prints</div>

                            <!-- Title -->
                            <h3 class="ws-item-title">Interstellar</h3>

                            <div class="ws-item-separator"></div>

                            <!-- Price -->
                            <div class="ws-item-price">$75.00</div>
                        </div>
                    </a>
                </div>

                <!-- Item -->
                <div class="col-sm-6 col-md-4 ws-works-item" data-sr='wait 0.1s, ease-in 20px'>
                    <a href="#">
                        <!-- Image -->
                        <figure>
                            <img src="assets/img/works/abstract/3.jpg" alt="Alternative Text" class="img-responsive">
                        </figure>
                        <div class="ws-works-caption text-center">
                            <!-- Item Category -->
                            <div class="ws-item-category">Abstract Prints</div>

                            <!-- Title -->
                            <h3 class="ws-item-title">Lake House</h3>

                            <div class="ws-item-separator"></div>

                            <!-- Price -->
                            <div class="ws-item-price">$33.00</div>
                        </div>
                    </a>
                </div>

                <!-- Item -->
                <div class="col-sm-6 col-md-4 ws-works-item" data-sr='wait 0.3s, ease-in 20px'>
                    <a href="#">
                        <!-- Image -->
                        <figure>
                            <img src="assets/img/works/illustrated/2.jpg" alt="Alternative Text"
                                class="img-responsive">
                        </figure>
                        <div class="ws-works-caption text-center">
                            <!-- Item Category -->
                            <div class="ws-item-category">Illustrated Prints</div>

                            <!-- Title -->
                            <h3 class="ws-item-title">Sorbetto</h3>

                            <div class="ws-item-separator"></div>

                            <!-- Price -->
                            <div class="ws-item-price">$123.00</div>
                        </div>
                    </a>
                </div>

                <!-- Item -->
                <div class="col-sm-6 col-md-4 ws-works-item" data-sr='wait 0.5s, ease-in 20px'>
                    <a href="#">
                        <div class="ws-item-offer">
                            <!-- Image -->
                            <figure>
                                <img src="assets/img/works/journals/1.jpg" alt="Alternative Text"
                                    class="img-responsive">
                            </figure>
                            <!-- Sale Caption -->
                            <div class="ws-item-sale">
                                <span>Sold</span>
                            </div>
                        </div>
                        <div class="ws-works-caption text-center">
                            <!-- Item Category -->
                            <div class="ws-item-category">Journal</div>

                            <!-- Title -->
                            <h3 class="ws-item-title">Rubby Hubby</h3>

                            <div class="ws-item-separator"></div>

                            <!-- Price -->
                            <div class="ws-item-price">$53.00</div>
                        </div>
                    </a>
                </div>

                <!-- Item -->
                <div class="col-sm-6 col-md-4 ws-works-item" data-sr='wait 0.1s, ease-in 20px'>
                    <a href="#">
                        <div class="ws-item-offer">
                            <!-- Image -->
                            <figure>
                                <img src="assets/img/works/illustrated/3.jpg" alt="Alternative Text"
                                    class="img-responsive">
                            </figure>
                            <!-- Sale Caption -->
                            <div class="ws-item-sale">
                                <span>Sale</span>
                            </div>
                        </div>
                        <div class="ws-works-caption text-center">
                            <!-- Item Category -->
                            <div class="ws-item-category">Illustrated Prints</div>

                            <!-- Title -->
                            <h3 class="ws-item-title">Grey Mountains</h3>

                            <div class="ws-item-separator"></div>

                            <!-- Price -->
                            <div class="ws-item-price"><del>$23.00</del> <ins>$10.00</ins></div>
                        </div>
                    </a>
                </div>

                <!-- Item -->
                <div class="col-sm-6 col-md-4 ws-works-item" data-sr='wait 0.3s, ease-in 20px'>
                    <a href="#">
                        <!-- Image -->
                        <figure>
                            <img src="assets/img/works/journals/2.jpg" alt="Alternative Text" class="img-responsive">
                        </figure>
                        <div class="ws-works-caption text-center">
                            <!-- Item Category -->
                            <div class="ws-item-category">Journals</div>

                            <!-- Title -->
                            <h3 class="ws-item-title">Thinking Wood</h3>

                            <div class="ws-item-separator"></div>

                            <!-- Price -->
                            <div class="ws-item-price">$23.00</div>
                        </div>
                    </a>
                </div>

                <!-- Item -->
                <div class="col-sm-6 col-md-4 ws-works-item" data-sr='wait 0.5s, ease-in 20px'>
                    <a href="#">
                        <!-- Image -->
                        <figure>
                            <img src="assets/img/works/abstract/4.jpg" alt="Alternative Text" class="img-responsive">
                        </figure>
                        <div class="ws-works-caption text-center">
                            <!-- Item Category -->
                            <div class="ws-item-category">Abstract Prints</div>

                            <!-- Title -->
                            <h3 class="ws-item-title">Thinking Wood</h3>

                            <div class="ws-item-separator"></div>

                            <!-- Price -->
                            <div class="ws-item-price">$23.00</div>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </section>
    <!-- Work Collection End  -->

@endsection
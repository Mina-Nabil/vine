@extends('layouts.site')

@section('content')
    <!-- Hero Content -->
    <div id="ws-hero-fullscreen" class="rev_slider">
        <ul>
            <li data-transition="fade" data-easein="Power4.easeInOut" data-easeout="Power4.easeInOut" data-masterspeed="2000">
                <!-- Background Image -->
                <img src="{{ $site_info->landing_image }}" alt="Alternative Text" data-bgposition="center center"
                    data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="10">

                <!-- Layer -->
                <div class="tp-caption ws-hero-title" data-x="['center','center','center','center']"
                    data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']"
                    data-voffset="['0','0','0','1']"
                    data-transform_in="y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:1500;e:Power3.easeInOut;"
                    data-mask_in="x:0px;y:0px;" data-mask_out="x:0;y:0;" data-start="1000" data-responsive_offset="on"
                    style="z-index: 6;">

                </div>

                <!-- Layer -->
                <div class="tp-caption ws-hero-description" data-x="['center','center','center','center']"
                    data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']"
                    data-voffset="['-72','-72','-72','-48']"
                    data-transform_in="y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:1500;e:Power3.easeInOut;"
                    data-mask_in="x:0px;y:0px;" data-mask_out="x:0;y:0;" data-start="1000" data-responsive_offset="on"
                    style="z-index: 7;">

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
                        <div class="ws-works-title clearfix">
                            <h4>Horus Limited</h4>
                            <h3>Beginnings</h3>
                        </div>
                        <p>Established in 1977 with major activity of papyrus replication 
                            and exhibition organization.</p>
                            <br />
                            <p>
                            Today, Horus is the number one Egyptian artifact replicator Has the "First Certified Replicas" 
                            authorization from the Egyptian government to be the official 
                            replicator of papyrus and Egyptian artifacts in 2019.
                            </p>
                 
                    </div>
                </div>

                <!-- Featured Collections -->
                <div class="ws-featured-collections clearfix">
                    @foreach ($slides as $slide)
                        <!-- Item -->
                        <div class="col-sm-{{ 12 / $slides->count() }} featured-collections-item">
                            <a @if ($slide->SLID_BTN_URL) href="{{ $slide->SLID_BTN_URL }}" @endif>
                                <div class="thumbnail">
                                    <img src="{{ $slide->image_url }}">
                                    @if ($slide->SLID_TITL)
                                        <div class="ws-overlay">
                                            <div class="caption">
                                                <h3>{{ $slide->SLID_TITL }}</h3>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </a>
                        </div>
                    @endforeach




                </div>

            </div>
        </div>
    </section>
    <!-- About Section End -->

    <!-- New Arrivals Section -->
    <section class="ws-arrivals-section">
        <div class="ws-works-title clearfix">
            <div class="col-sm-12">
                <h3>OUR EXHIBITS</h3>
            </div>
        </div>

        <!-- Exhibits Grid with HORUS styling -->
        <div class="horus-products-grid">
            @foreach ($new_arrivals as $new_prod)
                <!-- Product Card with Golden Border -->
                <div class="horus-product-card">
                    <a href="{{ url('product/' . $new_prod->id) }}">
                        <div class="ws-item-offer">
                            <!-- Image -->
                            <figure>
                                <img src="{{ $new_prod->main_image_url }}" alt="{{ $new_prod->name }}"
                                    class="horus-product-image">
                            </figure>
                        </div>

                        <div class="ws-works-caption text-center">
                            <!-- Title -->
                            <h3 class="ws-item-title">{{ $new_prod->arabic_name }}</h3>

                            <div class="ws-item-separator"></div>

                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </section>
    <!-- End New Arrivals Section -->

    <!-- Work Collection Start  -->
    <section class="ws-works-section">
        <div class="container">
            <div class="row">
                <div class="ws-works-title">
                    <div class="col-sm-12">
                        <h3>Best Sellers</h3>
                    </div>
                </div>

                <!-- Best Sellers Grid with HORUS styling -->
                <div class="horus-bestsellers-grid">
                    @foreach ($new_arrivals as $index => $prod)
                        <!-- Product Card with Golden Border -->
                        <div class="horus-product-card @if($index === 0) large @endif">
                            <a href="{{ url('product/' . $prod->id) }}">
                                <div class="ws-item-offer">
                                    <!-- Image -->
                                    <figure>
                                        <img src="{{ $prod->main_image_url }}" alt="{{ $prod->name }}"
                                            class="horus-product-image">
                                    </figure>
                                    <!-- Sale Caption -->
                                    @if ($prod->offer)
                                        <div class="ws-item-sale">
                                            <span>Sale</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="ws-works-caption text-center">
                                    <!-- Item Category -->
                                    <div class="ws-item-category">{{ $prod->subcategory->category->arabic_name }} -
                                        {{ $prod->subcategory->arabic_name }}</div>

                                    <!-- Title -->
                                    <h3 class="ws-item-title">{{ $prod->arabic_name }}</h3>

                                    <div class="ws-item-separator"></div>

                                    <!-- Price -->
                                    <div class="ws-item-price">
                                        @if ($prod->offer)
                                            <del>{{ $prod->price }}EGP</del>
                                        @endif
                                        <ins>{{ $prod->price - $prod->offer }}EGP</ins>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <!-- See More Button -->
                <div class="text-center" style="margin-top: 40px;">
                    <button class="horus-see-more-btn" onclick="window.location.href='{{ url('shop') }}'">
                        SEE MORE
                    </button>
                </div>
            </div>
        </div>
    </section>
    <!-- Work Collection End  -->


    @isset($showOrderSubmitted)
        <script>
            $('document').ready(function() {

                alert("Thank you for submiting the order. We will call you to confirm order details")
                // return Swal.fire({
                //     text: "Thank you for submiting the order. We will call you to confirm order details",
                //     icon: "success",
                //     showCancelButton: true,
                // })
            });
        </script>
    @endisset
    <!-- End Call to Action Section -->
@endsection

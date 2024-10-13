@extends('layouts.site')

@section('content')


<section id="content" class="clearfix">
    <!-- Slideshow -->

    <div id="home-slideshow" class="home-slideshow-wrapper" style="height:100px;overflow:hidden;">

        <div class="home-slideshow-loader"><i class="fa fa-spinner fa-pulse fa-2x"></i></div>
        <div class="home-slideshow-inner">
            <div class="home-slideshow" style="opacity:0">
                <ul class="slides">
                    @foreach ($slides as $slide)
                    <x-slide :slide="$slide" />
                    @endforeach

                </ul>
            </div>
        </div>

    </div>


    <div class="group-content-center">
        <div class="container">

            <!-- Home Tab -->

            <div id="tabpanel">
                <ul class="nav nav-tabs home-tabs-title" role="tablist" id="home-tabs">
                    <li role="presentation" class="active"><a href="#home-tabs-1" aria-controls="home-tabs-1" role="tab" data-toggle="tab">FEATURED</a></li>
                    <li role="presentation"><a href="#home-tabs-2" aria-controls="home-tabs-2" role="tab" data-toggle="tab">New Arrival</a></li>
                    <li role="presentation"><a href="#home-tabs-3" aria-controls="home-tabs-3" role="tab" data-toggle="tab">For Sale</a></li>
                </ul>
                <span class="dash-line"></span>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="home-tabs-1">
                        <div class="section-tab-content">
                            @foreach($models as $model)
                            <x-product-list-tile :model="$model" />
                            @endforeach
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane fade in" id="home-tabs-2">
                        <div class="section-tab-content">
                            @foreach($newArrivals as $model)
                            <x-product-list-tile :model="$model" />
                            @endforeach
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane fade in" id="home-tabs-3">
                        <div class="section-tab-content">
                            @foreach($onSale as $model)
                            <x-product-list-tile :model="$model" />
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>


            <!-- Banner -->

            <div id="home-banner" class="hidden-xs">
                <a href="{{$site_info->offer_url}}"><img class="pulse" src="{{$site_info->offer_small_url}}" alt="" /></a>
            </div>
            <div id="home-banner-smaller" class="visible-xs">
                <a href="{{$site_info->offer_url}}"><img class="pulse" src="{{$site_info->offer_large_url}}" alt="" /></a>
            </div>


            <!-- Browser our Collections -->

            <div id="home-browser-collections">
                <h1 class="home-collections-title">Browse our Collections</h1>
                <span class="dash-line"></span>
                <div class="home-collections-content">
                    <ul class="home-collections-links collection-list">

                        @foreach($subcategories as $sub)
                        <li class="link-element @if($loop->first) first @endif">
                            <a class="link-img" href="{{url('categories/' . $sub->id)}}"><img src="{{ $sub->image_url}}" alt="{{$sub->SBCT_NAME}}" height="175px" /></a>
                            <div class="group_element">
                                <div class="link-mask-content">
                                    <div class="inner-mask">
                                        <h2 class="link-title"> <a href="{{url('categories/' . $sub->id)}}">{{$sub->SBCT_NAME}}</a></h2>
                                        <div class="link-url"><a href="{{url('categories/' . $sub->id)}}">View All <i class="fa fa-caret-right"></i></a></div>
                                    </div>
                                    <!--/inner mask-->
                                </div>
                            </div>
                            <!--group element-->
                        </li>
                        @endforeach

                    </ul>
                </div>
                <script>
                    $(window).ready(function($) {
                        $(".link-mask-content").hover(
                            function() {
                            $( this ).parents('.link-element').children('.link-img').addClass("hovered");
                            }, 
                            function() {
                            $( this ).parents('.link-element').children('.link-img').removeClass( "hovered" );
                            });          
                        });
                </script>
            </div>

        </div>
    </div>

    <!--Group-content-center-->
    <x-quick-view-modal :prod-url="$loadProductJsonUrl" />
</section>




@endsection
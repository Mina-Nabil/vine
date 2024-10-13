@extends('layouts.site')

@section('content')

<section id="content" class="clearfix">
    <div id="collections-listing">
        <div class="title-breadcrumb">
            <div class="container">
                <div class="col-md-12">
                    <!-- Collection Listing Title -->
                    <div class="collection-listing-title">
                        <h2>Categories</h2>
                    </div>
                    <!-- Begin breadcrumb -->
                    <div class="breadcrumb clearfix">
                        <span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="{{url('/')}}" title="{{env('APP_NAME')}}" itemprop="url"><span itemprop="title">Home</span></a></span>
                        <span class="arrow-space"><i class="fa fa-angle-right"></i></span>
                        <span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="collection.html" title="Categories"><span itemprop="title">Categories</span></a></span>
                    </div>
                </div>
            </div>
        </div>


        <div id="collection-listing-content" class="products masonry">
            <div class="container">
                <div class="col-md-12">
                    <ul class="collection-list">

                        @foreach($subcategories as $sub)
                        <li class="link-element first">
                            <a href="{{url('categories/' . $sub->id)}}" class="link-img">
                                <img src="{{$sub->image_url}}" alt="{{$sub->SBCT_NAME}}">
                            </a>
                            <div class="group_element">
                                <div class="link-mask-content">
                                    <div class="inner-mask">
                                        <h2 class="link-title"><a href="{{url('categories/' . $sub->id)}}">{{$sub->SBCT_NAME}}</a></h2>
                                        <div class="link-url"><a href="{{url('categories/' . $sub->id)}}">View All <i class="fa fa-caret-right"></i></a></div>
                                    </div>
                                    <!--/inner mask-->
                                </div>
                            </div>
                        </li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('js_content')

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

@endsection
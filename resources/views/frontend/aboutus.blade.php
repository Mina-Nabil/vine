@extends('layouts.site')

@section('content')
<section id="content" class="clearfix">
    <div id="page">
        <div class="title-breadcrumb">
            <div class="container">
                <div class="col-md-12">
                    <!-- Page Listing Title -->
                    <div class="page-listing-title">
                        <h2 class="page-title">About Us</h2>
                    </div>
                    <!-- Begin breadcrumb -->
                    <div class="breadcrumb clearfix">
                        <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="{{url('home')}}" title="{{env('APP_NAME')}}" itemprop="url"><span itemprop="title">Home</span></a></span>
                        <span class="arrow-space"><i class="fa fa-angle-right"></i></span>
                        <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="{{url('aboutus')}}" title="About Us" itemprop="url"><span itemprop="title">About Us</span></a></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="col-md-12">
                <div class="about-us">
                    {!! $site_info->about_us !!}
                </div>
                <!--end about us-->
            </div>
        </div>
    </div>
</section>


@endsection
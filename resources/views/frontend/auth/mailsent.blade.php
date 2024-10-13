@extends('layouts.site')

@section('content')

<div id="content-wrapper">
    <section id="content" class="clearfix">


        <div id="customer-register">
            <div class="title-breadcrumb">
                <div class="container">
                    <div class="col-md-12">
                        <div class="page-listing-title">
                            <h2 class="page-title">Mail Sent</h2>
                        </div>
                        <!-- Begin breadcrumb -->
                        <div class="breadcrumb clearfix">
                            <span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
                                <a href="{{url('home')}}" title="Whalewears Shop" itemprop="url">
                                    <span itemprop="title">Home</span>
                                </a>
                            </span>
                            <span class="arrow-space">
                                <i class="fa fa-angle-right"></i>
                            </span>
                            <span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
                                <a href="#" title="Email Sent" itemprop="url">
                                    <span itemprop="title">Mail Sent</span>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="col-md-12">
                    <div class="row">
                        <p>Reset password email is successfully sent to the provided email. If it exists in our database. Please check your inbox, or the junk perhaphs </p>
                    </div>
                    <div class="row">
                        <div class="action_bottom">
                            <span class="note"><a href="{{url('home')}}">Back to Home</a></span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </section>
</div>
@endsection
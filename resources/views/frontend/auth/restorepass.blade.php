@extends('layouts.site')

@section('content')

<div id="content-wrapper">
    <section id="content" class="clearfix">


        <div id="customer-register">
            <div class="title-breadcrumb">
                <div class="container">
                    <div class="col-md-12">
                        <div class="page-listing-title">
                            <h2 class="page-title">Reset your Password</h2>
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
                                <a href="#" title="Reset Pass" itemprop="url">
                                    <span itemprop="title">Reset Password</span>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="col-md-12">
                    <form method="post" id="create_customer" action="{{$formURL}}" accept-charset="UTF-8">
                        @csrf
                        <h4>Reset Password</h4>
                        <input type="hidden" value="{{$encryptedID}}" name="encryptedID">

                        <div id="password" class="clearfix large_form">
                            <label for="password" class="label">New Password</label>
                            <input type="password" name="password" id="password" class="password text" size="30" minlength="6" required>
                            <div style="margin-bottom: 9px">
                                <small class="text-danger">{{$errors->first('password')}}</small>
                            </div>
                        </div>

                        <div class="action_bottom">
                            <input class="btn btn-3" type="submit" value="Reset">
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>
</div>
@endsection
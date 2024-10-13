@extends('layouts.site')

@section('content')

<div id="content-wrapper">
    <section id="content" class="clearfix">


        <div id="customer-register">
            <div class="title-breadcrumb">
                <div class="container">
                    <div class="col-md-12">
                        <div class="page-listing-title">
                            <h2 class="page-title">Login</h2>
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
                                <a href="#" title="Login" itemprop="url">
                                    <span itemprop="title">Login Form</span>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="col-md-12">
                    <form method="post" id="create_customer" accept-charset="UTF-8"><input type="hidden" name="form_type" value="create_customer"><input type="hidden" name="utf8" value="✓">
                        @csrf
                        <h4>Login</h4>

                        <div id="email" class="clearfix large_form">
                            <label for="email" class="label">Email</label>
                            <input type="email" value="{{old('email')}}" name="email" id="email" class="text" size="30" required>
                            <div style="margin-bottom: 9px">
                            <small class="text-danger">{{$errors->first('email')}}</small>
                            </div>
                        </div>

                        <div id="password" class="clearfix large_form">
                            <label for="password" class="label">Password</label>
                            <input type="password" name="password" id="password" class="password text" size="30" minlength="6" required>
                            <div style="margin-bottom: 9px">
                                <small class="text-danger">{{$errors->first('password')}}</small>
                            </div>
                        </div>

                        <div class="action_bottom">
                            <input class="btn btn-3" type="submit" value="Login"> 
                            <input class="btn btn-3" type="button" onclick="window.location='{{url('register')}}'" value="Register"> or
                            <span class="note"><a href="{{url('forgetpass')}}">Forget you password</a></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>
</div>
@endsection
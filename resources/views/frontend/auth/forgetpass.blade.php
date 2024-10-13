@extends('layouts.site')

@section('content')

<div id="content-wrapper">
    <section id="content" class="clearfix">


        <div id="customer-register">
            <div class="title-breadcrumb">
                <div class="container">
                    <div class="col-md-12">
                        <div class="page-listing-title">
                            <h2 class="page-title">Forget Password</h2>
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
                                <a href="#" title="Forget Password" itemprop="url">
                                    <span itemprop="title">Forget Password</span>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="col-md-12">
                    <form method="post" id="create_customer" accept-charset="UTF-8">
                        @csrf
                        <h4>Reset My Password</h4>

                        <div id="email" class="clearfix large_form">
                            <label for="email" class="label">Email</label>
                            <input type="email" value="{{old('email')}}" name="email" id="email" class="text" size="30" required>
                            <div style="margin-bottom: 9px">
                                <small class="text-danger">{{$errors->first('email')}}</small>
                            </div>
                        </div>


                        <div class="action_bottom">
                            <input class="btn btn-3" type="submit" value="Send Email"> 
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>
</div>
@endsection
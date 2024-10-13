@extends('layouts.site')

@section('content')

<section id="content" class="clearfix">


    <div id="customer-register">
        <div class="title-breadcrumb">
            <div class="container">
                <div class="col-md-12">
                    <div class="page-listing-title">
                        <h2 class="page-title">Create Account</h2>
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
                            <a href="#" title="Create Account" itemprop="url">
                                <span itemprop="title">Create Account</span>
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
                    <h4>Create Account</h4>

                    <div id="first_name" class="clearfix large_form">
                        <label for="first_name" class="label">Name</label>
                        <input type="text" value="{{old('name')}}" placeholder="Mohamed Salah" name="name" id="first_name" class="text" size="30" required>
                        <div style="margin-bottom: 9px">
                            <small class="text-danger">{{$errors->first('name')}}</small>
                        </div>
                    </div>

                    <div id="mobile" class="clearfix large_form">
                        <label for="mobile" class="label">Phone</label>
                        <input type="text" value="{{old('mobile')}}" name="mobile" id="mobile" class="text" size="30" minlength="11" placeholder="01231230000" required>
                        <div style="margin-bottom: 9px">
                            <small class="text-danger">{{$errors->first('mobile')}}</small>
                        </div>
                    </div>

                    <div id="email" class="clearfix large_form">
                        <label for="email" class="label">Email</label>
                        <input type="email" value="{{old('email')}}" name="email" id="email" placeholder="user@getwhalewear.com" class="text" size="30" required>
                        <div style="margin-bottom: 9px">
                            <small class="text-danger">{{$errors->first('email')}}</small>
                        </div>
                    </div>

                    <div class="addresses-country">
                        <label class="collection-filters__label" for="area">Delivery Area</label>
                        <div class="select">
                            <select class=" addresses-country__sort" id="area" name="area" aria-describedby="a11y-refresh-page-message">
                                @foreach ($areas as $area)
                                <option value="{{$area->id}}" @if ($area->id == old('area'))
                                    selected
                                    @endif
                                    >{{$area->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div style="margin-bottom: 9px">
                            <small class="text-danger">{{$errors->first('area')}}</small>
                        </div>
                    </div>

                    <div class="addresses-country">
                        <label class="collection-filters__label" for="gender">Gender</label>
                        <div class="select">
                            <select class="select__select collection-filters__sort" style="width:100%" id="gender" name=gender aria-describedby="a11y-refresh-page-message">
                                @foreach ($genders as $gender)
                                <option value="{{$gender->id}}" @if ($gender->id == old('gender'))
                                    selected
                                    @endif
                                    >{{$gender->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div style="margin-bottom: 9px">
                            <small class="text-danger">{{$errors->first('gender')}}</small>
                        </div>
                    </div>


                    <div id="last_name" class="clearfix large_form">
                        <label for="address" class="label">Address</label>
                        <textarea value="{{old(" address")}}" name="address" id="address" class="textarea" size="30" placeholder="Delivery Address (Optional)"></textarea>
                        <div style="margin-bottom: 9px">
                            <small class="text-danger">{{$errors->first('address')}}</small>
                        </div>
                    </div>

                    <div id="password" class="clearfix large_form">
                        <label for="password" class="label">Password</label>
                        <input type="password" value="" name="password" id="password" class="password text" size="30" minlength="6" required>
                        <div style="margin-bottom: 9px">
                            <small class="text-danger">{{$errors->first('password')}}</small>
                        </div>
                    </div>

                    <div class="action_bottom">
                        <input class="btn btn-3" type="submit" value="Create"> or
                        <span class="note"><a href="{{url('forgetpass')}}">Forgot the password?</a></span>
                    </div>
                </form>
            </div>
        </div>
    </div>

</section>

@endsection
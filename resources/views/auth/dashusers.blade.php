@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-7">
        <x-datatable id="myTable"  :title="$title" :subtitle="$subTitle" :cols="$cols" :items="$items" :atts="$atts" />
    </div>

    <div class="col-lg-5">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ $formTitle }}</h4>
                <form class="form pt-3" method="post" action="{{ url($formURL) }}" enctype="multipart/form-data" >
                @csrf
                <input type=hidden name=id value="{{(isset($user)) ? $user->id : ''}}">
                @if(isset($user->DASH_IMGE))
                <input type=hidden name=oldPath value="{{$user->DASH_IMGE}}">
                @endif
                    <div class="form-group">
                        <label>User Name*</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon11"><i class="ti-user"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="Username" name=name aria-label="Username" aria-describedby="basic-addon11" value="{{ (isset($user)) ? $user->name : old('username')}}" required>
                        </div>
                        <small class="text-danger">{{$errors->first('name')}}</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Full Name*</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon22"><i class="ti-user"></i></span>
                            </div>
                            <input type="text" class="form-control" name=fullname placeholder="Full Name" aria-label="Full Name" aria-describedby="basic-addon22" value="{{ (isset($user)) ? $user->full_name : old('fullname')}}" required>
                        </div>
                        <small class="text-danger">{{$errors->first('fullname')}}</small>
                    </div>
              
                    <div class="form-group">
                      <label for="input-file-now-custom-1">User Photo</label>
                        <div class="input-group mb-3">
                            <input type="file" id="input-file-now-custom-1" name=photo class="dropify" data-default-file="{{ (isset($user->image_url)) ? $user->image_url : old('photo') }}" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Password*</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon33"><i class="ti-lock"></i></span>
                            </div>
                            <input type="text" class="form-control" name=password placeholder="Password" aria-label="Password" aria-describedby="basic-addon33"
                            @if($isPassNeeded)
                            required
                            @endif
                            >
                            
                        </div>
                        <small class="text-danger">{{$errors->first('password')}}</small>
                    </div>
                    <button type="submit" class="btn btn-success mr-2">Submit</button>
                    @if($isCancel)
                        <a href="{{url($homeURL) }}" class="btn btn-dark">Cancel</a>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
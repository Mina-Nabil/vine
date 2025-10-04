@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-7">
        <x-datatable id="myTable" :title="$title" :subtitle="$subTitle" :cols="$cols" :items="$items" :atts="$atts" />
    </div>

    <div class="col-lg-5">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ $formTitle }}</h4>
                <form class="form pt-3" method="post" action="{{ url($formURL) }}" enctype="multipart/form-data" >
                @csrf
                <input type=hidden name=id value="{{(isset($location)) ? $location->id : ''}}">

                    <div class="form-group">
                        <label>Image{{ (isset($location)) ? '' : '*' }}</label>
                        <div class="input-group mb-3">
                            <input type="file" id="input-file-now-custom-1" name=photo class="dropify" data-default-file="{{ (isset($location)) ? $location->image_url : '' }}" {{ (isset($location)) ? '' : 'required' }} />
                            <small>3MB maximum - Recommended resolution 400 x 300</small>
                        </div>
                        <small class="text-danger">{{$errors->first('photo')}}</small>
                    </div>
                    <div class="form-group">
                        <label>Title*</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Title" name=title value="{{ (isset($location)) ? $location->title : old('title')}}" required>
                        </div>
                        <small class="text-danger">{{$errors->first('title')}}</small>
                    </div>
                    <div class="form-group">
                        <label>Location URL*</label>
                        <div class="input-group mb-3">
                            <input type="url" class="form-control" placeholder="Location URL" name=location_url value="{{ (isset($location)) ? $location->location_url : old('location_url')}}" required>
                        </div>
                        <small class="text-danger">{{$errors->first('location_url')}}</small>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <div class="input-group mb-3">
                            <textarea class="form-control" placeholder="Address" name=address rows="3">{{ (isset($location)) ? $location->address : old('address')}}</textarea>
                        </div>
                        <small class="text-danger">{{$errors->first('address')}}</small>
                    </div>
                    <div class="form-group">
                        <label>Telephone</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Telephone" name=telephone value="{{ (isset($location)) ? $location->telephone : old('telephone')}}">
                        </div>
                        <small class="text-danger">{{$errors->first('telephone')}}</small>
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

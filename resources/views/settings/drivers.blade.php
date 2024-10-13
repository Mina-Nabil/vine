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
                <input type=hidden name=id value="{{(isset($driver)) ? $driver->id : ''}}">

                    <div class="form-group">
                        <label>Driver Name*</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Driver Name" name=name value="{{ (isset($driver)) ? $driver->name : old('name')}}" required>
                        </div>
                        <small class="text-danger">{{$errors->first('name')}}</small>
                    </div>
                    <div class="form-group">
                        <label>Mobile Number</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Driver Mobile Number" name=mob value="{{ (isset($driver)) ? $driver->mobn : old('mob')}}" >
                        </div>
                        <small class="text-danger">{{$errors->first('mob')}}</small>
                    </div>
                    <div class="form-group">
                        <label>National ID Number</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Driver National ID Number" name=nationalID value="{{ (isset($driver)) ? $driver->nationalID : old('nationalID')}}" >
                        </div>
                        <small class="text-danger">{{$errors->first('nationalID')}}</small>
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
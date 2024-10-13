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
                <form class="form pt-3" method="post" action="{{ url($formURL) }}" enctype="multipart/form-data">
                    @csrf
                    <input type=hidden name=id value="{{(isset($chart)) ? $chart->id : ''}}">

                    <div class="form-group">
                        <label>Size Chart Name*</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Size Chart Name" name=name value="{{ (isset($chart)) ? $chart->SZCT_NAME : old('name')}}" required>
                        </div>
                        <small class="text-danger">{{$errors->first('name')}}</small>
                    </div>

                    <div class="form-group">
                        <label for="input-file-now-custom-1">Chart Image</label>
                        <div class="input-group mb-3">
                            <input type="file" id="input-file-now-custom-1" name=image class="dropify" data-default-file="{{ (isset($chart->SZCT_URL)) ? $chart->image_url : old('image') }}" />
                        </div>
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

@section("js_content")
<script src="https://widget.cloudinary.com/v2.0/global/all.js" type="text/javascript"></script>

<script>
    var myWidget = cloudinary.createUploadWidget({
    cloudName: 'sasawhale', 
    folder: "whale/sizechart",
    uploadPreset: 'whalesec'}, (error, result) => { 
      if (!error && result && result.event === "success") { 
        document.getElementById('uploaded').value = result.info.url;
      }
    }
  )
  
  document.getElementById("upload_widget").addEventListener("click", function(){
      myWidget.open();
    }, false);
</script>
@endsection
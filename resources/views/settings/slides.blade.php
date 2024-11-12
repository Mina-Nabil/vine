@extends('layouts.app')

@section('content')
<script>
    function confirmAndDelete(id){  
        Swal.fire({
            text: "Are you sure you want to delete the Slide?",
            icon: "warning",
            showCancelButton: true,
            }).then((isConfirm) => {
                if(isConfirm.value){
                window.location.href = "{{$deleteURL}}" + "/" + id;
            }
        });
    }
</script>

<div class="row">
    @foreach ($slides as $slide)
    <div class="col-6">
        <x-dashboard-slide :slide="$slide" />
    </div>
    @endforeach

    <div class="col-lg-6">
        <div class="card">
            <img class="card-img-top img-responsive" src='{{asset("assets/img/backgrounds/abstract-bg.jpg")}}' alt="Card image cap">
            <div class="card-body">
                <h4 class="card-title">Add Slide</h4>
                <a href="javascript:void(0)" data-toggle="modal" data-target="#slide-modal" class="btn btn-primary">Add</a>
            </div>
        </div>
    </div>
</div>

<div id="slide-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Slide</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="{{ url('admin/website/slides/add') }}" method=post enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <h5>Slide*</h5>
                        <input type="file" id="input-file-now-custom-1" name=photo class="dropify" data-default-file="" required />
                        <small>3MB maximum - Resolution 1670 x 700</small>
                    </div>
                    <div class="form-group col-md-12 m-t-0">
                        <h5>Title</h5>
                        <input type="text" class="form-control form-control-line" name=title value="{{old('title')}}" >
                    </div>
                    <div class="form-group col-md-12 m-t-0">
                        <h5>Subtitle</h5>
                        <input type="text" class="form-control form-control-line" name=subtitle value="{{old('subtitle')}}" >
                    </div>

                    <div class="form-group col-md-12 m-t-0">
                        <h5>Button Text</h5>
                        <input type="text" class="form-control form-control-line" name=buttonText value="{{old('buttonText')}}">
                    </div>
                    <div class="form-group col-md-12 m-t-0">
                        <h5>Button Url</h5>
                        <input type="text" class="form-control form-control-line" name=buttonUrl value="{{old('buttonUrl')}}">
                        <small>full url example: https://getwhalewear.com/newcollection</small>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning waves-effect waves-light">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if($errors->any())
<?php 
    $errorStr = "<ul>";
    foreach ($errors->all() as  $issue) {
        $errorStr .= "<li>";
        $errorStr .= $issue ;
        $errorStr .= "</li>";
    }
    $errorStr .="</ul>";
?>
<script>
    Swal.fire("Oops",'<?=$errorStr?>');
</script>
@endif
@endsection
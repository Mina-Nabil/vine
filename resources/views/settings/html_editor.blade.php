@extends('layouts.app')

@section('content')
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{$formTitle}}</h4>
                <form class="form pt-3" method="post" enctype="multipart/form-data">
                    @csrf
                    <textarea class="form-control" id="summary-ckeditor" name="{{$inputName}}">{{$inputValue}}</textarea>
                    <small class="text-danger">{{$errors->first($inputName)}}</small>
                    <hr>
                    <button type="submit" class="btn btn-success mr-2">Submit</button>

                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@section("js_content")
<script>
    CKEDITOR.replace( 'summary-ckeditor' );
</script>
@endsection
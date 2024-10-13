@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12" >
        <button class="btn btn-success mb-2" onclick="confirmAndGoTo('{{$deleteAllStock}}','remove all stock entries')" style="  float: right;">Clear All Stock list</button>
    </div>
    <div class="col-12">
        <x-datatable id="myTable"  :title="$title" :subtitle="$subTitle" :cols="$cols" :items="$items" :atts="$atts" />
    </div>
</div>
@endsection
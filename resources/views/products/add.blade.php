@extends('layouts.app')

@section('content')



<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ $formTitle }}</h4>
                <form class="form pt-3" method="post" action="{{ url($formURL) }}" enctype="multipart/form-data">
                    @csrf
                    <input type=hidden name=id value="{{(isset($product)) ? $product->id : ''}}">

                    <div class="form-group">
                        <label>Category</label>
                        <div class="input-group mb-3">
                            <select name=category class="select2 form-control custom-select" style="width: 100%; height:36px;" required>
                                <option value="" disabled selected >Pick From Categories</option>
                                @foreach($categories as $categry)
                                <option value="{{ $categry->id }}"
                                @if(isset($product) && $categry->id == $product->sub_category_id)
                                    selected
                                @endif
                                >{{$categry->category->name}} : {{$categry->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <small class="text-danger">{{$errors->first('category')}}</small>
                    </div>

                    <div class="form-group">
                        <label>Model Title</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Full Model Title" name=name value="{{ (isset($product)) ? $product->name : old('name')}}" required>
                        </div>
                        <small class="text-danger">{{$errors->first('name')}}</small>
                    </div>
                    <div class="form-group">
                        <label>Arabic Title</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name=arbcName placeholder="اسم الموديل بالعربيه" value="{{ (isset($product)) ? $product->arabic_name : old('mail')}}" required>
                        </div>
                        <small class="text-danger">{{$errors->first('arbcName')}}</small>
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" rows="3" required name=desc>{{(isset($product)) ? $product->desc : old('desc')}}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Arabic Description</label>
                        <textarea class="form-control" rows="3" required name=arbcDesc>{{(isset($product)) ? $product->arabic_desc : old('desc')}}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Material</label>
                        <textarea class="form-control" rows="3" required name=material>{{(isset($product)) ? $product->material : old('material')}}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Dimensions</label>
                        <textarea class="form-control" rows="3" required name=dimensions>{{(isset($product)) ? $product->material : old('dimensions')}}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Handled Topics / مواضيع المنتج</label>
                        <textarea class="form-control" rows="3" required name=handled_topics>{{(isset($product)) ? $product->handled_topics : old('handled_topics')}}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Price</label>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" placeholder="Model Price" name=price value="{{ (isset($product)) ? $product->price : old('price')}}" required>
                        </div>
                        <small class="text-danger">{{$errors->first('price')}}</small>
                    </div>

             

                    <div class="form-group">
                        <label>Discount</label>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" placeholder="Model Discount Amount" name=offer value="{{ (isset($product)) ? $product->offer : old('offer') }}">
                        </div>
                        @if($errors->first('offer') != null)
                        <small class="text-danger">{{$errors->first('offer')}}</small>
                        @else
                        <small>Not Required - Default 0</small>
                        @endif
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
@extends('layouts.app')

@section('head_content')

<link href="{{asset('assets/node_modules/multiselect/css/multi-select.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/node_modules/bootstrap-select/bootstrap-select.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css')}}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

<div class="row">
    <!-- Column -->
    <div class="col-lg-4 col-xlg-3 col-md-5">
        <div class="card"> <img class="card-img" src="{{$product->main_image_url}}" style="max-height:420; max-width:420;width:auto; height:auto;" alt="Card image">
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="col-lg-8 col-xlg-9 col-md-7">
        <div class="card">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs profile-tab" role="tablist">
                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#profile" role="tab">Model Info</a> </li>
                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#stock" role="tab">Stock</a> </li>
                {{-- <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#sales" role="tab">Sales</a> </li> --}}
                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#images" role="tab">Images</a> </li>

                {{-- <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tags" role="tab">Tags</a> </li> --}}
                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#settings" role="tab">Settings</a> </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <!--second tab-->
                <div class="tab-pane active" id="profile" role="tabpanel">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 col-xs-6 b-r"> <strong>Model Name</strong>
                                <br>
                                <p class="text-muted">{{$product->name}}</p>
                            </div>
                            <div class="col-md-3 col-xs-6 b-r"> <strong>Arabic Name</strong>
                                <br>
                                <p class="text-muted">{{$product->arabic_name}}</p>
                            </div>
                       
                            <div class="col-md-3 col-xs-6"> <strong>Offer</strong>
                                <br>
                                <p class="text-muted">{{$product->offer}}</p>
                            </div>
                        </div>
                        <hr>
                        <strong>Description</strong>
                        <p class="m-t-30">{{$product->desc}}</p>
                        <hr>
                        <strong>Arabic Description</strong>
                        <p class="m-t-30">{{$product->arabic_desc}}</p>
                    </div>
                </div>

                <div class="tab-pane" id="stock" role="tabpanel">
                    <div class="card-body">
                        <x-datatable id="myTable" :title="$title" :subtitle="$subTitle" :cols="$cols" :items="$items" :atts="$atts" />
                    </div>
                </div>

                <div class="tab-pane" id="images" role="tabpanel">
                    <div class="card-body">
                        <h4 class="card-title">Add New Model Image</h4>
                        <form class="form pt-3" method="post" action="{{ url($imageFormURL) }}" enctype="multipart/form-data">
                            @csrf


                            <div class="form-group">
                                <label for="input-file-now-custom-1">New Image</label>
                                <div class="input-group mb-3">
                                    <input type="file" id="input-file-now-custom-1" name=photo class="dropify" />
                                </div>
                                <small>900*900</small>
                            </div>

                            <button type="submit" class="btn btn-success mr-2">Submit</button>
                            @if($isCancel)
                            <a href="{{url($homeURL) }}" class="btn btn-dark">Cancel</a>
                            @endif
                        </form>
                    </div>

                    <hr>
                    <div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <?php $i=0; ?>
                            @foreach($product->images as $image)
                            <li data-target="#carouselExampleIndicators2" data-slide-to="{{$i}}" {{($i==0) ? 'class="active"' : '' }}></li>
                            <?php $i++; ?>
                            @endforeach
                        </ol>
                        <div class="carousel-inner" role="listbox">
                            <?php $i=0; ?>
                            @foreach($product->images as $image)
                            <div class="carousel-item {{($i==0) ? 'active' : ''}} align-items-center">
                                <img class="img-fluid" src="{{$image->full_image_url}}" style=" margin-left: 20%; margin-right: 20%;">
                            </div>
                            <?php $i++; ?>
                            @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators2" role="button" data-slide="prev" style="background-color:#DCDCDC">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators2" role="button" data-slide="next" style="background-color:#DCDCDC">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                    <hr>
                    <div>
                        <div class="table-responsive m-t-40">
                            <table class="table color-bordered-table table-striped full-color-table full-info-table hover-table" data-display-length='-1' data-order="[]">
                                <thead>
                                    <th>Url</th>
                                    <th>Actions</th>
                                </thead>
                                <tbody>
                                    @foreach ($product->images as $image)
                                    <tr>
                                        <td><a target="_blank" href="{{$image->full_image_url}}">
                                                {{(strlen($image->full_image_url) < 25) ? $image->full_image_url : substr($image->full_image_url, 0, 25).'..' }}
                                            </a></td>
                                        <td>
                                            <div class="row justify-content-center">
                                                @if($image->id != $product->product_image_id)
                                                <a href="javascript:void(0);">
                                                    <div class="label label-info" onclick="confirmAndGoTo('{{url('admin/products/setimage/'.$product->id.'/'.$image->id)}}', 'set this as the main Model Image')">
                                                        Set As Main </div>
                                                </a>
                                                @else
                                                <a href="javascript:void(0);">
                                                    <div class="label label-danger">Main Image</div>
                                                </a>
                                                @endif

                                                <div onclick="confirmAndGoTo('{{$deleteUrl . '/' . $image->id}}', '{{ 'delete this image'}}')"><a href="javascript:void(0)"><img src="{{ asset('images/del.png') }}"
                                                            width=25 height=25></a></div>
                                            </div>
                                        </td>
                                    <tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
    

   

                <div class="tab-pane" id="settings" role="tabpanel">
                    <div class="card-body">
                        <h4 class="card-title">{{ $formTitle }}</h4>
                        <form class="form pt-3" method="post" action="{{ url($formURL) }}" enctype="multipart/form-data">
                            @csrf
                            <input type=hidden name=id value="{{(isset($product)) ? $product->id : ''}}">

                            <div class="form-group">
                                <label>Category</label>
                                <div class="input-group mb-3">
                                    <select name=category class="select2 form-control custom-select" style="width: 100%; height:36px;" required>
                                        <option value="" disabled selected>Pick From Categories</option>
                                        @foreach($categories as $categry)
                                        <option value="{{ $categry->id }}" @if(isset($product) && $categry->id == $product->sub_category_id)
                                            selected
                                            @endif
                                            >{{$categry->category->arabic_name}} : {{$categry->arabic_name}}</option>
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
                                <label>Price</label>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" placeholder="Model Price" name=price value="{{ (isset($product)) ? $product->price : old('price')}}" required>
                                </div>
                                <small class="text-danger">{{$errors->first('price')}}</small>
                            </div>

                            <div class="form-group">
                                <label>Discount</label>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" placeholder="Model Discount" name=offer value="{{ (isset($product)) ? $product->offer : old('offer') }}">
                                </div>
                                @if($errors->first('offer') != null)
                                <small class="text-danger">{{$errors->first('offer')}}</small>
                                @else
                                <small>Not Required - Default 0</small>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Created At</label>
                                <div class="input-group mb-3">
                                    <input type="date" class="form-control" name=created_at value="{{ (isset($product)) ? $product->created_at->format('Y-m-d') : old('created_at') }}">
                                </div>
                            </div>




                            <button type="submit" class="btn btn-success mr-2">Submit</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->
</div>
@endsection

@section("js_content")
<script type="text/javascript" src="{{asset('assets/node_modules/multiselect/js/jquery.multi-select.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/node_modules/bootstrap-select/bootstrap-select.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js')}}"></script>


<script src="https://widget.cloudinary.com/v2.0/global/all.js" type="text/javascript"></script>
<script>
    var myWidget = cloudinary.createUploadWidget({
    cloudName: 'sasawhale', 
    folder: "whale/models",
    uploadPreset: 'whalesec'}, (error, result) => { 
      if (!error && result && result.event === "success") { 
        document.getElementById('uploaded').value = result.info.url;
      }
    }
  )
  
  document.getElementById("upload_widget").addEventListener("click", function(){
      myWidget.open();
    }, false);

    function confirmAndGoTo(url, action){
    Swal.fire({
        text: "Are you sure you want to " + action + "?",
        icon: "warning",
        showCancelButton: true,
        }).then((isConfirm) => {
    if(isConfirm.value){

    window.location.href = url;
        }
    });

}

</script>
@endsection
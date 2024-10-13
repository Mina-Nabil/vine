@extends('layouts.app')


@section('content')

<div class="row">
    <!-- Column -->
    <div class="col-lg-4 col-xlg-3 col-md-5">
        <div class="card">
            <div class="card-body">
                <small class="text-muted">Client Name </small>
                <h6>{{$user->name}}</h6>
                <small class="text-muted">Email address </small>
                <h6>{{$user->email}}</h6>
                <small class="text-muted p-t-30 db">Phone</small>
                <h6>{{$user->mobile}}</h6>
                <small class="text-muted p-t-30 db">Area</small>
                <h6>{{$user->area->name}}</h6>
                <small class="text-muted p-t-30 db">Address</small>
                <h6>{{$user->address}}</h6>

                <small class="text-muted p-t-30 db">Social Profile</small>
                <br />
                @isset($user->USER_FBTK)
                <button class="btn btn-circle btn-secondary"><i class="fab fa-facebook-f"></i></button>
                @else
                <button class="btn btn-circle btn-secondary"><i class="fas fa-at"></i></button>
                @endisset

            </div>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="col-lg-8 col-xlg-9 col-md-7">
        <div class="card">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs profile-tab" role="tablist">
                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#history" role="tab">Order History</a> </li>
                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#wishlist" role="tab">Wishlist</a> </li>
                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#bought" role="tab">Items Bought</a> </li>
                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#settings" role="tab">Settings</a> </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <!--Orders tab-->
                <div class="tab-pane active" id="history" role="tabpanel">
                    <div class="card-body">
                        <h4 class="card-title">User's Orders History</h4>
                        <h6 class="card-subtitle">Total Money Paid: {{$userMoney->paid}}, Discount offered: {{$userMoney->discount}}</h6>
                        <div class="col-12">
                            <x-datatable id="myTable" :title="$title ?? 'Orders History'" :subtitle="$subTitle ?? ''" :cols="$ordersCols" :items="$orderList" :atts="$orderAtts" :cardTitle="false" />
                        </div>
                    </div>
                </div>

                <!--Wishlist tab-->
                <div class="tab-pane" id="wishlist" role="tabpanel">
                    <div class="card-body">
                        <div class="col-12">
                            <x-datatable id="myTable3" :title="$title ?? 'Wishlist'" :subtitle="$subTitle ?? ''" :cols="$wishlistCols" :items="$wishlistList" :atts="$wishlistAtts"
                                :cardTitle="false" />
                        </div>
                    </div>
                </div>

                <!--Item Bought tab-->
                <div class="tab-pane" id="bought" role="tabpanel">
                    <div class="card-body">
                        <div class="col-12">
                            <x-datatable id="myTable4" :title="$title ?? 'Items Bought'" :subtitle="$subTitle ?? ''" :cols="$boughtCols" :items="$boughtList" :atts="$boughtAtts" :cardTitle="false" />
                        </div>
                    </div>
                </div>


                <div class="tab-pane" id="settings" role="tabpanel">
                    <div class="card-body">
                        <h4 class="card-title">Edit {{ $user->name }}'s Info</h4>
                        <form class="form pt-3" method="post" action="{{ url($formURL) }}" enctype="multipart/form-data">
                            @csrf
                            <input type=hidden name=id value="{{(isset($user)) ? $user->id : ''}}">
                            <div class="form-group">
                                <label>Full Name*</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Full Name" name=name value="{{ (isset($user)) ? $user->name : old('name')}}" required>
                                </div>
                                <small class="text-danger">{{$errors->first('name')}}</small>
                            </div>
                            <div class="form-group">
                                <label>Email*</label>
                                <div class="input-group mb-3">
                                    <input type="email" class="form-control" name=mail placeholder="User email" value="{{ (isset($user)) ? $user->email : old('mail')}}" required>
                                </div>
                         
                                <small class="text-danger">{{$errors->first('mail')}}</small>
                            </div>

                            <div class="form-group">
                                <label>Password*</label>
                                <div class="input-group mb-3">
                                    <input type="password" class="form-control" placeholder="Password" name=pass {{(isset($user) ? "" : "required")}}>
                                </div>
                                <small class="text-danger">{{$errors->first('pass')}}</small>
                            </div>

                            <div class="form-group">
                                <label>Mobile Number*</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Mobile Number" name=mob value="{{ (isset($user)) ? $user->mobile : old('mob') }}" required>
                                </div>
                             
                                <small class="text-danger">{{$errors->first('mob')}}</small>
                            </div>



                            <div class="form-group">
                                <label>Area*</label>
                                <div class="input-group mb-3">
                                    <select name=area class="select2 form-control custom-select" style="width: 100%; height:36px;" required>
                                        <option value="" disabled selected>Select Area</option>
                                        @foreach($areas as $area)
                                        <option value="{{ $area->id }}" @if(isset($user) && $area->id == $user->area_id)
                                            selected
                                            @elseif($area->id == old('area'))
                                            selected
                                            @endif
                                            >{{$area->name}} - {{$area->arabic_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <small class="text-danger">{{$errors->first('area')}}</small>
                            </div>


                            <div class="form-group">
                                <label>Gender*</label>
                                <div class="input-group mb-3">
                                    <select name=gender class="select2 form-control custom-select" style="width: 100%; height:36px;" required>
                                        <option value="" disabled selected>Pick A Gender</option>
                                        @foreach($genders as $gender)
                                        <option value="{{ $gender->id }}" @if(isset($user) && $gender->id == $user->gender_id)
                                            selected
                                            @elseif($gender->id == old('gender'))
                                            selected
                                            @endif
                                            >{{$gender->name}} - {{$gender->arabic_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <small class="text-danger">{{$errors->first('gender')}}</small>
                            </div>

                            <div class="form-group">
                                <label>Address</label>
                                <div class="input-group mb-3">
                                    <textarea class="form-control" name="address" id=userAdrs rows="3" required>{{ (isset($user)) ? $user->address : old('address') }}</textarea>
                                </div>
                                <small class="text-danger">{{$errors->first('address')}}</small>
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
@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Website Info</h4>
                <form class="form pt-3" method="post" action="{{ url($formUrl) }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-group">
                        <label>Logo*</label>
                        <div class="input-group mb-3">
                            <input type="file" id="input-file-now-custom-1" name=logo class="dropify" data-default-file="{{$info->logo_url}}" />
                            <small>20KB maximum - 180 * 40</small>
                        </div>
                        <small class="text-danger">{{$errors->first('logo')}}</small>
                    </div>

                    <hr>

                    <div class="form-group col-md-12 m-t-0">
                        <h5>Email</h5>
                        <input type="email" class="form-control form-control-line" name=mail value="{{ $info->email ?? old('mail')}}" >
                    </div>

                    <div class="form-group col-md-12 m-t-0">
                        <h5>Phone</h5>
                        <input type="text" class="form-control form-control-line" name=phone value="{{ $info->phone ?? old('phone')}}" >
                    </div>

                    <div class="form-group col-md-12 m-t-0">
                        <h5>Instagram Page</h5>
                        <input type="text" class="form-control form-control-line" name=instagram value="{{ $info->WBST_INST ?? old('instagram')}}" >
                        <small>Enter Page name only .. example: whalewear</small>
                    </div>

                    <div class="form-group col-md-12 m-t-0">
                        <h5>Facebook Page</h5>
                        <input type="text" class="form-control form-control-line" name=fb value="{{ $info->WBST_FB ?? old('fb')}}" >
                        <small>Enter Page name only .. example: whalewear</small>
                    </div>

                    <hr>
                    <div class="form-group col-md-12 m-t-0">
                        <h5>Offer Url</h5>
                        <input type="text" class="form-control form-control-line" name=offerUrl value="{{ $info->offer_url ?? old('offerUrl')}}" >
                        <small>Enter full url .. example: https://getwhalewear/jackets/2</small>
                    </div>

                    <div class="form-group">
                        <label>Offer Image Wide</label>
                        <div class="input-group mb-3">
                            <input type="file" id="input-file-now-custom-1" name=offerSmallImg class="dropify" data-default-file="{{$info->offer_small_url}}"  />
                            <small>4MB maximum - Appears on Laptop Screen - 1170 * 90</small>
                        </div>
                        <small class="text-danger">{{$errors->first('offerSmallImg')}}</small>
                    </div>

                    <div class="form-group">
                        <label>Offer Image Square</label>
                        <div class="input-group mb-3">
                            <input type="file" id="input-file-now-custom-1" name=offerLargeImg class="dropify" data-default-file="{{$info->offer_large_url}}"  />
                            <small>4MB maximum - Appears on Mobile Screen - 900 * 600 </small>
                        </div>
                        <small class="text-danger">{{$errors->first('offerLargeImg')}}</small>
                    </div>


                    <hr>

                    <div class="form-group">
                        <label>Footer Image 1</label>
                        <div class="input-group mb-3">
                            <input type="file" id="input-file-now-custom-1" name=footerImage1 class="dropify" data-default-file="{{$info->footer1_url}}"  />
                            <small>2MB maximum - 570 * 335</small>
                        </div>
                        <small class="text-danger">{{$errors->first('footerImage1')}}</small>
                    </div>


                    <div class="form-group col-md-12 m-t-0">
                        <h5>Footer Title 1</h5>
                        <input type="text" class="form-control form-control-line" name=footerTitle1 value="{{ $info->WBST_FOOT_TTL1 ?? old('footerTitle1')}}" >
                        <small>Appears on home page footer</small>
                    </div>

                    <div class="form-group col-md-12 m-t-0">
                        <h5>Footer Subtitle 1</h5>
                        <input type="text" class="form-control form-control-line" name=footerSubtitle1 value="{{ $info->WBST_FOOT_SUB1 ?? old('footerSubtitle1')}}" >
                        <small>Appears on home page footer</small>
                    </div>

                    <hr>


                    <div class="form-group">
                        <label>Footer Image 2</label>
                        <div class="input-group mb-3">
                            <input type="file" id="input-file-now-custom-1" name=footerImage2 class="dropify" data-default-file="{{$info->footer2_url}}" />
                            <small>2MB maximum - 570 * 335 </small>
                        </div>
                        <small class="text-danger">{{$errors->first('footerImage2')}}</small>
                    </div>

                    <div class="form-group col-md-12 m-t-0">
                        <h5>Footer Title 2</h5>
                        <input type="text" class="form-control form-control-line" name=footerTitle2 value="{{ $info->WBST_FOOT_TTL2 ?? old('footerTitle2')}}" >
                        <small>Appears on home page footer</small>
                    </div>

                    <div class="form-group col-md-12 m-t-0">
                        <h5>Footer Subtitle 2</h5>
                        <input type="text" class="form-control form-control-line" name=footerSubtitle2 value="{{ $info->WBST_FOOT_SUB2 ?? old('footerSubtitle2')}}" >
                        <small>Appears on home page footer</small>
                    </div>


                    <button type="submit" class="btn btn-success mr-2">Submit</button>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
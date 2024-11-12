@extends('layouts.site')

@section('content')
    <!-- Page Parallax Header -->
    <div class="ws-parallax-header parallax-window" data-parallax="scroll" data-image-src="{{$site_info->landing_image}}">        
        <div class="ws-overlay">            
            <div class="ws-parallax-caption">                
                <div class="ws-parallax-holder">
                    <h1>Our Delivery Policy</h1>                        
                </div>
            </div>
        </div>            
    </div>            
    <!-- End Page Parallax Header -->

    <!-- Page Content -->
    <div class="container ws-page-container">   
        <div class="row">
            <div class="ws-about-content col-sm-12">
                <!-- Information -->
               {!! $site_info->delivery_policy !!}       

            </div> 
        </div>                                                              
    </div>
    <!-- End Page Content --> 


@endsection
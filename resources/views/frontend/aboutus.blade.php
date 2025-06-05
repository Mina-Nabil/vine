@extends('layouts.site')

@section('content')
    <!-- Page Parallax Header -->
    <div class="ws-parallax-header" data-parallax="scroll" data-image-src="{{$site_info->landing_image}}">        
        <div class="ws-overlay">            
            <div class="ws-parallax-caption">                
                <div class="ws-parallax-holder">
                    <h1>About Horus</h1>                        
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
               {!! $site_info->about_us !!}       

                <!-- Space Helper Class -->
                <div class="padding-top-x70"></div>

                <!-- Team Members -->
                <div class="row text-center">
                    <div class="ws-about-team">
                        <div class="col-sm-6 ws-about-team-item" data-sr='wait 0.1s, ease-in 20px'>                        
                            <img src="assets/img/about/team-1.jpg" alt="Alternative Text" class="img-responsive">
                            <div class="caption">
                                <h3>Hellen Madison</h3>
                                <div class="ws-separator"></div>     
                                <h5>Owner / Designer / Creative Director</h5>
                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim.</p>                    
                            </div>                        
                        </div>
                        
                        <div class="col-sm-6 ws-about-team-item" data-sr='wait 0.3s, ease-in 20px'>                        
                            <img src="assets/img/about/team-2.jpg" alt="Alternative Text" class="img-responsive">
                            <div class="caption">
                                <h3>Ellen Moonday</h3>
                                <div class="ws-separator"></div>     
                                <h5>Owner / Illustrator / Letterer </h5>        
                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim.</p>                           
                            </div>                        
                        </div>
                    </div>
                </div>



            </div> 
        </div>                                                              
    </div>
    <!-- End Page Content --> 

@endsection
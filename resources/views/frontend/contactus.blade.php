@extends('layouts.site')

@section('content')
<script src="https://www.google.com/recaptcha/api.js"></script>
   <!-- Page Parallax Header -->
   <div class="ws-parallax-header parallax-window" data-parallax="scroll" data-image-src="{{$site_info->landing_image}}">        
    <div class="ws-overlay">            
        <div class="ws-parallax-caption">                
            <div class="ws-parallax-holder">
                <h1>Contact Us</h1>                        
            </div>
        </div>
    </div>            
</div>            
<!-- End Page Parallax Header -->

<!-- Page Content -->
<div class="container ws-page-container">
    <div class="row">            
        <div class="ws-contact-page">

            <!-- General Information -->
            <div class="col-sm-6">
                <div class="ws-contact-info">
                    <h2>General:</h2>
                    <p><a href="mailto:{{$site_info->email}}">{{$site_info->email}}</a></p>
                    <br>
                    <h2>Phone:</h2>
                    <p><a href="tel:{{$site_info->phone}}">{{$site_info->phone}}</a></p>
                    <br>
                    <p><strong>نحن نحب أن نسمع منك! سواء كان لديك أسئلة حول منتجاتنا، تحتاج إلى مساعدة في طلبك، أو ترغب في مشاركة رأيك، لا تتردد في التواصل معنا. فريقنا هنا لدعمك والتأكد من حصولك على أفضل تجربة ممكنة.</strong></p>
                    <p><strong>يمكنك الاتصال بنا عبر البريد الإلكتروني، الهاتف، أو من خلال قنوات التواصل الاجتماعي، وسنرد عليك في أسرع وقت. دعونا نبقى على تواصل! 🌿💬</strong></p>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-sm-6">
                <form class="form-horizontal ws-contact-form">
                    <!-- Name -->
                    <div class="form-group">
                        <label class="control-label">Name <span>*</span></label>
                        <input type="text" class="form-control">                        
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label class="control-label">Email <span>*</span></label>                        
                        <input type="email" class="form-control">                        
                    </div>

                    <!-- Message -->
                    <div class="form-group">
                        <label class="control-label">Message <span>*</span></label>      
                        <textarea class="form-control" rows="7"></textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group">                        
                        <a href="#x"  id="contactFormSubmit" class="btn ws-big-btn" disabled>Submit</a>                        
                    </div>
                </form>
            </div>


        </div>
    </div>
</div>
<!-- End Page Content -->

<script>
    grecaptcha.enterprise.ready(function() {
    grecaptcha.enterprise.execute('6LfSqjsgAAAAAJfrCgUif24ST-qpuoILnkR2HGgd', {action: 'login'}).then(function(token) {
    $('#contactFormSubmit').removeAttr('disabled')
    });
});
</script>
@endsection
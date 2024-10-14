@extends('layouts.site')

@section('after_pixel')
<meta property="og:title" content="{{$product->name}}">
<meta property="og:description" content="{{$product->desc}}">
<meta property="og:url" content="{{url('product/' . $product->id)}}">
<meta property="og:image" content="{{$product->main_image_url}}">
<meta property="product:brand" content="GetWhale">
<meta property="product:availability" content="in stock">
<meta property="product:condition" content="new">
<meta property="product:price:amount" content="{{$product->final_price}}">
<meta property="product:price:currency" content="EGP">
<meta property="product:retailer_item_id" content="{{$product->id}}">
<meta property="product:item_group_id" content="{{$product->category_name}}">
@endsection

@section('content')
<section id="content" class="clearfix">
    <div id="product" class="{{$product->name}} content clearfix">
        <div class="title-breadcrumb">
            <div class="container">
                <div class="col-md-12">
                    <div class="collection-listing-title">
                        <h2 class="collection-title">{{$product->name}}</h2>
                    </div>
                    <!-- Begin breadcrumb -->
                    <div class="col-md-12">
                        <div class="breadcrumb clearfix">
                            <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="{{url('home')}}" title="{{env('APP_NAME')}}" itemprop="url"><span itemprop="title">Home</span></a></span>
                            <span class="arrow-space"><i class="fa fa-angle-right"></i></span>
                            <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
                                <a href="{{url('all')}}" title="All Products">Products</a>
                            </span>
                            <span class="arrow-space"><i class="fa fa-angle-right"></i></span>
                            <strong>{{$product->name}}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="product-detail-content">
            <div class="container">
                <div class="col-md-12">
                    <div class="col-md-6" id="product-image">
                        <div id="gallery-images" class="thumbs clearfix hidden-xs">
                            <div class="vertical-slider">
                                <?php  $i=0;  ?>
                                @foreach($product->images as $image)
                                <div class="image @if($i==0) active @elseif($i==3) last-in-row @endif">
                                    <a href="{{$image->image_url}}" class="cloud-zoom-gallery">
                                        <img src="{{$image->image_url}}" alt="{{$product->name}}" />
                                    </a>
                                </div>
                                <?php $i++; ?>
                                @endforeach
                            </div>
                        </div>

                        <div id="featuted-image" class="image featured">
                            <img src="{{$product->main_image_url}}" alt="{{$product->name}}" />
                        </div>

                        <div id="gallery-images-mobile" class="thumbs clearfix visible-xs">
                            <div class="vertical-slider">
                                <?php $i=0; ?>
                                @foreach($product->images as $image)
                                <div class="image @if($i==0) active @elseif($i==3) last-in-row @endif">
                                    <a href="{{$image->image_url}}" class="cloud-zoom-gallery">
                                        <img src="{{$image->image_url}}" alt="{{$product->name}}" />
                                    </a>
                                </div>
                                <?php $i++; ?>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6" id="product-information">
                        <h3 class="quick-overview">Quick Overview</h3>
                        <div class="description">
                            {{$product->desc}}
                        </div>
                        <form id="product-form">
                            <div class="product-options ">

                                <style>
                                    label[for="product-select-option-0"] {
                                        display: none;
                                    }

                                    #product-select-option-0 {
                                        display: none;
                                    }

                                    #product-select-option-0+.custom-style-select-box {
                                        display: none !important;
                                    }
                                </style>
                                <script>
                                    $(window).load(function() { $('.selector-wrapper:eq(0)').hide(); });
                                </script>
                                <div class="swatch color clearfix" data-option-index="0">
                                    <div class="header">Color</div>
                                    @foreach($product->available_colors as $color)
                                    <div data-value="{{$color->name}}" class="swatch-element color {{$color->class_code}} available ">
                                        <div class="tooltip">{{$color->name}}</div>
                                        <input id="swatch-0-{{$color->id}}" type="radio" name="colorRadio" value="{{$color->id}}" onchange="checkStock()" />
                                        <label for="swatch-0-{{$color->id}}" style="background-color: {{$color->code}}; border-color: black;">
                                        </label>
                                    </div>
                                    <script>
                                        jQuery('.swatch[data-option-index="0"] .{{$color->class_code}}').removeClass('soldout').addClass('available').find(':radio').removeAttr('disabled');
                                    </script>
                                    @endforeach
                                </div>

               

                                <script>
                                    $(function() {
                                $('.swatch-element').hover(
                                function() {
                                    $(this).addClass("hovered");
                                }, function() {
                                    $(this).removeClass("hovered");
                                });
                                $(".swatch-element").click(function () {
                                if(!$(this).hasClass('active'))
                                {
                                    $(".swatch-element.active").removeClass("active");
                                    $(this).addClass("active");        
                                }
                                });
                            });
                                </script>

                                <div>
                                    <div class="detail-price" itemprop="price">
                                        <span class="price">
                                            <span class="money" data-currency-usd="{{$product->final_price}}EGP" data-currency="EGP">{{$product->final_price}}EGP</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="description">
                                    <small id="UnavailableText"></small>
                                </div>
                                <div class="quantity-wrapper clearfix">
                                    <label class="wrapper-title">Qty</label>
                                    <div class="wrapper">
                                        <span class="qty-down btooltip" data-toggle="tooltip" data-placement="top" title="Decrease" data-src="#prod-quantity">
                                            <i class="fa fa-minus"></i>
                                        </span>
                                        <input id="prod-quantity" type="number" name="prod-quantity" value="1" min=1 max=0 size="5" class="item-quantity" />
                                        <span class="qty-up btooltip" data-toggle="tooltip" data-placement="top" title="Increase" data-src="#prod-quantity">
                                            <i class="fa fa-plus"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="addto-cart-wrapper clearfix">
                                    <div class="process-addtocart" style="display: none;"><i class="fa fa-spinner fa-pulse fa-2x"></i></div>
                                    <button id="add-to-cart" class="btn btn-1 add-to-cart" onclick="addToCartFromProductPage('{{$product->id}}')" type="button" name="add"><i class="fa fa-shopping-cart"></i>Add to
                                        Cart</button>
                                </div>

                            </div>
                        </form>

                        <div class="add-to-wishlist">
                            <span @class(["non-user"=> !$is_logged]) data-toggle="tooltip" data-placement="right"
                                @if(!$is_logged)
                                title="To add this product to your wish list you must Login or Register"
                                @endif>
                                <a href="javascript:void(0);" id="prodAddToWishlist" onclick="addToWishlist('{{$product->id}}', 'prodAddToWishlist')">
                                    <i class="fa fa-heart"></i>Add to Wishlist</a>
                            </span>
                        </div>
                        <div class="relative product-detail-tag">
                            <ul class="list-unstyled">
                                <li class="tags">
                                    <span>Tags: </span>
                                    @foreach($product->tags as $tag)
                                    {{$tag->TAGS_NAME . " "}}
                                    @endforeach

                                    @foreach($product->tags as $tag)
                                    {{$tag->TAGS_ARBC_NAME . " "}}
                                    @endforeach

                                </li>
                            </ul>
                        </div>
                    </div>

                    <div id="tabs-information" class="col-md-12">
                        <div class="col-md-3 tabs-title">
                            <ul class="nav nav-tabs tabs-left sideways">
                                <li class="active"><a href="#desc" data-toggle="tab">Description</a></li>
                                {{-- <li><a href="#customerreview" data-toggle="tab">Customer Review</a></li> --}}
                                <li><a href="#delivery" data-toggle="tab">Delivery</a></li>
                                <li><a href="#payment" data-toggle="tab">Payment</a></li>
                                @if($product->sizechart)
                                <li><a href="#chart" data-toggle="tab">Sizechart</a></li>
                                @endif
                            </ul>
                        </div>
                        <div class="col-md-9 tabs-content">
                            <div class="tab-content">
                                <div class="tab-pane active" id="desc">
                                    <aside>
                                        {{$product->desc}}
                                        <br><br>
                                        {{$product->arabic_desc}}
                                    </aside>
                                </div>

                                <div class="tab-pane fade " id="delivery">
                                    {!!$site_info->delivery_policy!!}
                                </div>

                                <div class="tab-pane fade " id="payment">
                                    {!!$site_info->payment_policy!!}
                                </div>
                                @if($product->sizechart)
                                <div class="tab-pane fade " id="chart">
                                    <img src="{{$product->sizechart->image_url}}" />
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <script type="text/javascript">
        $(window).load(function() {
      
            $('#gallery-images div.image').on('click', function() {
                var $this = $(this);
                var parent = $this.parents('#gallery-images');
                parent.find('.image').removeClass('active');
                $this.addClass('active');
            });

          

            var anyProductImage = $('.featured img');
            if (anyProductImage.size()) {
                if ($(window).width() > 782) {
                var anyZoomedSrc = $('.featured img').attr('src');
                $('.featured img')
                    .wrap('<span style="display:inline-block; max-width: 100%;"></span>')
                    .css('display', 'block')
                    .parent()
                    .zoom({ url: anyZoomedSrc });
                }
            }
        })
  
        var jsonObj = `<?=$product->toJSON(JSON_UNESCAPED_UNICODE)?>`
        var prodPageObj = JSON.parse(jsonObj.replace(/[\r]?[\n]/g, '\\n'));
        checkStock();

        function checkStock(){
            $("#prod-quantity").val(0)
            var maxLimit = 0;
            var selected_color  = $('input[name="colorRadio"]:checked').val();
            var selected_size   = $('input[name="sizeRadio"]:checked').val();

            prodPageObj.stock.forEach(entry => {
                if(entry.size.id == selected_size && entry.color.id == selected_color) {
                    maxLimit = entry.available_units;
                }
            });
            $("#prod-quantity").attr("max", maxLimit)
            if(maxLimit>0){
                $("#add-to-cart").removeAttr("disabled")
                $("#UnavailableText").html("")
            }
            else {
      
                if(selected_color==undefined || selected_size==undefined){
                    $("#UnavailableText").html("Please Select desired color and size")
                } else {
                    $("#UnavailableText").html("Out of Stock unfortunately.. Please check again soon.")
                }
            }
        }

        function addToCartFromProductPage(prod_id){
            var color  = $('input[name="colorRadio"]:checked').val();
            var size   = $('input[name="sizeRadio"]:checked').val();
            if(!color || !size){
                showErrorModal("Please select color and size")
                return
            }
            if(document.querySelector('#product-form').reportValidity()){
                let id          = prod_id;
                let quantity    = $("#prod-quantity").val();
                addToCart(prod_id, quantity, size, color, "add-to-cart");
            } 
        }
    </script>

</section>


@endsection
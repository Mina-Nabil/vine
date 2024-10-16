@extends('layouts.site')

@section('content')
    <!-- Breadcrumb -->
    <div class="ws-breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="{{ url('shop') }}">Shop</a></li>
                <li><a
                        href="{{ url('shop/' . $product->subcategory->category->id) }}">{{ $product->subcategory->category->name }}</a>
                </li>
                <li><a href="{{ url('shop/' . $product->subcategory->category->id) }}">{{ $product->subcategory->name }}</a>
                </li>
            </ol>
        </div>
    </div>
    <!-- End Breadcrumb -->

    <!-- Product Content -->
    <div class="container ws-page-container">
        <div class="row">

            <!-- Product Image Carousel -->
            <div class="col-sm-7">
                <div id="ws-products-carousel" class="owl-carousel">
                    @foreach ($product->images as $img)
                        <div class="item">
                            <img src="{{ $image->image_url }}" class="img-responsive" alt="{{ $product->name }}">
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Product Information -->
            <div class="col-sm-5">
                <div class="ws-product-content">
                    <header>
                        <!-- Item Category -->
                        <div class="ws-item-category">{{ $product->subcategory->category->name }} -
                            {{ $product->subcategory->name }}</div>

                        <!-- Title -->
                        <h3 class="ws-item-title">{{ $product->name }}</h3>

                        <div class="ws-separator"></div>

                        <!-- Price -->
                        @if ($product->offer)
                            <div class="ws-item-price"><del>{{ number_format($product->price) }}EGP</del>
                                <ins>{{ number_format($product->price - $product->offer) }}EGP</ins>
                            </div>
                        @else
                            <div class="ws-item-price"><ins>{{ number_format($product->price) }}EGP</ins>
                            </div>
                        @endif
                        <!-- Quantity -->
                        <div class="ws-product-quantity">
                            <a href="#" class="minus">-</a>
                            <input type="text" value="1" size="4">
                            <a href="#" class="plus">+</a>
                        </div>
                    </header>

                    <div class="ws-product-details">
                        {{ $product->desc }}<br><br>{{ $product->arabic_desc }}
                    </div>

                    <!-- Button -->
                    <a class="btn ws-btn-fullwidth">Add To Cart</a><br><br><br>
                </div>
            </div>
        </div>
    </div>
    <!-- Product Content -->

    <!-- Products Description -->
    <div class="ws-products-description-content text-center">

        <!-- Item -->
        <div class="ws-product-description">
            <h3>Share</h3>
            <div class="ws-product-social-icon">
                <a href="https://wa.me/?text='Check this Vine Arts Product!\n{{ url('product/' . $product->id) }}'"
                    target="_blank"><i class="fa fa-whatsapp"></i></a>
            </div>
        </div>

        <!-- Item -->
        <div class="ws-product-description">
            <h3>Material</h3>
            <p>{{ $product->material }}</p>
        </div>

        <!-- Item -->
        <div class="ws-product-description">
            <h3>Dimensions</h3>
            <p>{{ $product->dimensions }}</p>
        </div>

        <!-- Item -->
        <div class="ws-product-description">
            <h3>Topics</h3>
            <p>{{ $product->handled_topics }}</p>
        </div>

    </div>
    <!-- End Products Description -->

    <!-- Related Post -->
    <div class="ws-related-section">
        <div class="container">

            <!-- Title -->
            <div class="ws-related-title">
                <h3>Related Products</h3>
            </div>

            @foreach ($related_products as $prod)
                <div class="col-sm-4">
                    <!-- Item -->
                    <div class="ws-works-item">
                        <a href="{{ url('product/' . $prod->id) }}">
                            <!-- Image -->
                            <figure>
                                <img src="{{ $prod->main_image_url }}" alt="Alternative Text" class="img-responsive">
                            </figure>
                            <div class="ws-works-caption text-center">
                                <!-- Item Category -->
                                <div class="ws-item-category">{{ $prod->subcategory->category->name }} -
                                    {{ $prod->subcategory->name }}</div>

                                <!-- Title -->
                                <h3 class="ws-item-title">{{ $prod->name }}</h3>

                                <div class="ws-item-separator"></div>

                                <!-- Price -->
                                <div class="ws-item-price">{{ number_format($prod->price - $prod->offer) }}EGP</div>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- End Related Post -->
@endsection

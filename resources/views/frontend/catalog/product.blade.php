@extends('layouts.site')

@section('content')
    <!-- HORUS Product Container -->
    <div class="horus-product-container">
        <div class="horus-product-main">
            
            <!-- Product Image Section -->
            <div class="horus-product-image-section">
                <!-- Main Product Image -->
                <div class="horus-product-main-image">
                    <img id="mainProductImage" src="{{ $product->main_image_url }}" alt="{{ $product->name }}">
                </div>
                
                <!-- Thumbnail Images -->
                <div class="horus-product-thumbnails">
                    @foreach ($product->images as $index => $img)
                        <div class="horus-product-thumbnail" onclick="changeMainImage('{{ $img->full_image_url }}')">
                            <img src="{{ $img->full_image_url }}" alt="{{ $product->name }}">
                        </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Product Details Section -->
            <div class="horus-product-details">
                <!-- Product Title -->
                <h1 class="horus-product-title">{{ $product->arabic_name }}</h1>
                
                <!-- Quantity Section -->
                <div class="horus-product-quantity-section">
                    <label class="horus-product-quantity-label">Quantity</label>
                    <div class="horus-quantity-controls">
                        <button type="button" class="horus-quantity-btn" onclick="subCount()">-</button>
                        <input type="text" id="prod_count" class="horus-quantity-input" value="1" readonly>
                        <button type="button" class="horus-quantity-btn" onclick="addCount()">+</button>
                    </div>
                </div>
                
                <!-- Price -->
                <div class="horus-product-price">
                    @if ($product->offer)
                        <del style="color: #cccccc; font-size: 20px;">{{ number_format($product->price) }}EGP</del>
                        {{ number_format($product->price - $product->offer) }}
                    @else
                        {{ number_format($product->price) }}
                    @endif
                </div>
                
                <!-- Order Button -->
                <input type="hidden" id="prod_id" value="{{ $product->id }}" />
                <button class="horus-order-btn btn-add-cart">ORDER</button>
                
                <!-- Product Description -->
                <div class="horus-product-description">
                    <h3 class="horus-description-title">DESCRIPTION</h3>
                    <p class="horus-description-text">{{ $product->arabic_desc }}</p>
                    @if($product->desc)
                        <p class="horus-description-text">{{ $product->desc }}</p>
                    @endif
                </div>
                
                <!-- Back Button -->
                <button class="horus-back-btn" onclick="window.history.back()">BACK</button>
            </div>
        </div>
        
        <!-- Product Information Sections -->
        <div class="horus-product-info-sections">
            <!-- Share Section -->
            <div class="horus-info-section">
                <h3>Share</h3>
                <div class="ws-product-social-icon">
                    <a href="https://wa.me/?text='Check this Horus Arts Product!\n{{ url('product/' . $product->id) }}'"
                        target="_blank" style="color: #FFD700; font-size: 24px;">
                        <i class="fa fa-whatsapp"></i>
                    </a>
                </div>
            </div>
            
            <!-- Material Section -->
            @if($product->material)
            <div class="horus-info-section">
                <h3>Material</h3>
                <p>{{ $product->material }}</p>
            </div>
            @endif
            
            <!-- Dimensions Section -->
            @if($product->dimensions)
            <div class="horus-info-section">
                <h3>Dimensions</h3>
                <p>{{ $product->dimensions }}</p>
            </div>
            @endif
            
            <!-- Topics Section -->
            @if($product->handled_topics)
            <div class="horus-info-section">
                <h3>Topics</h3>
                <p>{{ $product->handled_topics }}</p>
            </div>
            @endif
        </div>
        
        <!-- Related Products -->
        @if($related_products && count($related_products) > 0)
        <div class="horus-related-products">
            <h2 class="horus-related-title">Related Products</h2>
            <div class="horus-related-grid">
                @foreach ($related_products as $prod)
                    <div class="horus-product-card">
                        <a href="{{ url('product/' . $prod->id) }}">
                            <div class="ws-item-offer">
                                <figure>
                                    <img src="{{ $prod->main_image_url }}" alt="{{ $prod->name }}" class="horus-product-image">
                                </figure>
                            </div>
                            <div class="ws-works-caption text-center">
                                <div class="ws-item-category">{{ $prod->subcategory->category->arabic_name }} -
                                    {{ $prod->subcategory->arabic_name }}</div>
                                <h3 class="ws-item-title">{{ $prod->arabic_name }}</h3>
                                <div class="ws-item-separator"></div>
                                <div class="ws-item-price">{{ number_format($prod->price - $prod->offer) }}EGP</div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <script>
        function addCount() {
            let currentValue = parseInt($('#prod_count').val());
            $('#prod_count').val(currentValue + 1);
        }

        function subCount() {
            let currentValue = parseInt($('#prod_count').val());
            if (currentValue > 1) {
                $('#prod_count').val(currentValue - 1);
            }
        }
        
        function changeMainImage(imageUrl) {
            $('#mainProductImage').attr('src', imageUrl);
        }
    </script>
@endsection

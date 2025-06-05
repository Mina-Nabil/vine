@extends('layouts.site')

@section('content')
    <!-- HORUS Cart Container -->
    <div class="horus-cart-container">
        <div class="horus-cart-main">
            
            <!-- Cart Items Section -->
            <div class="horus-cart-items">
                <form method="POST">
                    @csrf
                    
                    @foreach ($cart->items as $item)
                        <div class="horus-cart-item">
                            <!-- Product Image -->
                            <div>
                                <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="horus-cart-item-image">
                            </div>
                            
                            <!-- Product Details -->
                            <div class="horus-cart-item-details">
                                <h3>{{ $item->title }}</h3>
                                <div class="horus-cart-item-status">In stock</div>
                                <div class="horus-cart-item-shipping">Eligible for free shipping</div>
                            </div>
                            
                            <!-- Price -->
                            <div class="horus-cart-item-price">
                                {{ number_format($item->price, 2) }}
                            </div>
                            
                            <!-- Quantity Selector -->
                            <div>
                                <select class="horus-cart-qty-selector" 
                                        id="prod-{{ $item->id }}-quantity" 
                                        name="quantity[]"
                                        onchange="updateQuantity({{ $item->id }}, this.value)">
                                    <option value="0">Qty 0 (Remove)</option>
                                    @for ($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}" @selected($item->quantity == $i)>
                                            Qty {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                                <input type="hidden" name="product[]" value="{{ $item->id }}" />
                            </div>
                            
                            <!-- Actions -->
                            <div class="horus-cart-actions">
                                <button type="button" class="horus-cart-action-btn" onclick="removeItem({{ $item->id }})">
                                    Delete
                                </button>
                                <button type="button" class="horus-cart-action-btn">
                                    Save for later
                                </button>
                                <button type="button" class="horus-cart-action-btn">
                                    Share
                                </button>
                            </div>
                        </div>
                    @endforeach
                    
                    <!-- Hidden Update Button -->
                    <button type="submit" id="updateCartBtn" style="display: none;">Update Cart</button>
                </form>
            </div>
            
            <!-- Cart Sidebar -->
            <div class="horus-cart-sidebar">
                
                <!-- Order Summary -->
                <div class="horus-cart-summary">
                    <h3>
                        <i class="fa fa-check-circle" style="color: #FFD700;"></i>
                        Your Order Qualifies for free shipping
                    </h3>
                    <div class="horus-cart-summary-content">
                        Choose this option at checkout.
                    </div>
                    <div class="horus-cart-subtotal">
                        <span>Subtotal ({{ count($cart->items) }} Items):</span>
                        <span>{{ number_format($cart->total, 2) }}</span>
                    </div>
                    <button class="horus-checkout-btn" onclick="window.location.href='{{ url('checkout') }}'">
                        CHECK OUT
                    </button>
                </div>
                
                <!-- Recommendations -->
                <div class="horus-recommendations">
                    <h3>Customers who bought these items Also viewed these</h3>
                    
                    <!-- Sample Recommendations (you can replace with dynamic data) -->
                    <div class="horus-recommendation-item">
                        <img src="{{ asset('assets/img/sample-artifact1.jpg') }}" alt="Recommendation" class="horus-recommendation-image">
                        <div class="horus-recommendation-details">
                            <h4>Kneeling Offering Statue of Ancient Egyptian King Amenhotep III</h4>
                        </div>
                    </div>
                    
                    <div class="horus-recommendation-item">
                        <img src="{{ asset('assets/img/sample-artifact2.jpg') }}" alt="Recommendation" class="horus-recommendation-image">
                        <div class="horus-recommendation-details">
                            <h4>A vintage replica of an ancient Egyptian godAnubis</h4>
                        </div>
                    </div>
                    
                    <div class="horus-recommendation-item">
                        <img src="{{ asset('assets/img/sample-artifact3.jpg') }}" alt="Recommendation" class="horus-recommendation-image">
                        <div class="horus-recommendation-details">
                            <h4>Statue</h4>
                        </div>
                    </div>
                    
                    <div class="horus-recommendation-item">
                        <img src="{{ asset('assets/img/sample-artifact4.jpg') }}" alt="Recommendation" class="horus-recommendation-image">
                        <div class="horus-recommendation-details">
                            <h4>A vintage replica of an ancient Egyptian goddess Bastet</h4>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <script>
        function updateQuantity(itemId, quantity) {
            // Auto-submit form when quantity changes
            document.getElementById('updateCartBtn').click();
        }
        
        function removeItem(itemId) {
            // Set quantity to 0 and submit
            document.getElementById('prod-' + itemId + '-quantity').value = 0;
            document.getElementById('updateCartBtn').click();
        }
        
        function setQuantity(id, quantity) {
            $('#prod-' + id + '-quantity').val(quantity);
        }
    </script>
@endsection

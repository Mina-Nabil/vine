@extends('layouts.site')

@section('content')
    <!-- HORUS Checkout Container -->
    <div class="horus-checkout-container">
        <form method="POST" action="{{ $submitOrderUrl }}" id="checkoutForm">
            @csrf
            
            <div class="horus-checkout-main">
                
                <!-- Payment Section -->
                <div class="horus-checkout-section">
                    <h2 class="horus-checkout-title">PAYMENT</h2>
                    
                    <!-- Payment Methods -->
                    <div class="horus-payment-methods">
                        <h3 class="horus-payment-method-title">SELECT PAYMENT METHOD</h3>
                        <div class="horus-payment-options">
                            <div class="horus-payment-option">
                                <input type="radio" id="card" name="payment_method" value="card" checked>
                                <label for="card">💳 Card</label>
                            </div>
                            <div class="horus-payment-option">
                                <input type="radio" id="paypal" name="payment_method" value="paypal">
                                <label for="paypal">PayPal</label>
                            </div>
                            <div class="horus-payment-option">
                                <input type="radio" id="applepay" name="payment_method" value="applepay">
                                <label for="applepay">🍎 Pay</label>
                            </div>
                            <div class="horus-payment-option">
                                <input type="radio" id="googlepay" name="payment_method" value="googlepay">
                                <label for="googlepay">G Pay</label>
                            </div>
                        </div>
                        
                        <!-- Card Details -->
                        <div id="cardDetails">
                            <div class="horus-form-group">
                                <label class="horus-form-label">NAME ON CARD</label>
                                <input type="text" class="horus-form-input" placeholder="Enter cardholder name">
                            </div>
                            
                            <div class="horus-form-group">
                                <label class="horus-form-label">CARD NUMBER</label>
                                <input type="text" class="horus-form-input" placeholder="XXXX XXXX XXXX XXXX">
                            </div>
                            
                            <div class="horus-form-row">
                                <div class="horus-form-group">
                                    <label class="horus-form-label">EXPIRATION DATE</label>
                                    <input type="text" class="horus-form-input" placeholder="MM/YY">
                                </div>
                                <div class="horus-form-group">
                                    <label class="horus-form-label">CVV</label>
                                    <input type="text" class="horus-form-input" placeholder="XXX">
                                </div>
                            </div>
                            
                            <div class="horus-save-card">
                                <input type="checkbox" id="saveCard">
                                <label for="saveCard">Securely Save your Card for a faster checkout next time</label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Delivery Address -->
                    <div class="horus-delivery-address">
                        <h3 class="horus-payment-method-title">DELIVERY ADDRESS</h3>
                        
                        <!-- Hidden Fields -->
                        <input type="hidden" name="user" value="@isset($logged_user) {{ $logged_user->id }} @endisset" />
                        <input type="hidden" name="guest" value="@isset($logged_user) 2 @else 1 @endisset" />
                        <input type="hidden" name="area" id="selectedAreaID" value="{{ isset($logged_user) ? $logged_user->area_id : old('area') ?? 1 }}" />
                        
                        <div class="horus-form-row">
                            <div class="horus-form-group">
                                <label class="horus-form-label">FIRST NAME</label>
                                <input type="text" name="guestName" class="horus-form-input" 
                                       @isset($logged_user) value="{{ explode(' ', $logged_user->name)[0] }}" @else value="{{ old('name') }}" @endisset
                                       required>
                                @error('guestName')
                                    <small class="text-danger">{{ $errors->first('guestName') }}</small>
                                @enderror
                            </div>
                            <div class="horus-form-group">
                                <label class="horus-form-label">LAST NAME</label>
                                <input type="text" class="horus-form-input" 
                                       value="@isset($logged_user){{ count(explode(' ', $logged_user->name)) > 1 ? explode(' ', $logged_user->name)[1] : '' }}@endisset">
                            </div>
                        </div>
                        
                        <div class="horus-form-group">
                            <label class="horus-form-label">EMAIL</label>
                            <input type="email" name="phone" class="horus-form-input" 
                                   @isset($logged_user) value="{{ $logged_user->mobile }}" @else value="{{ old('phone') }}" @endif required>
                            @error('phone')
                                <small class="text-danger">{{ $errors->first('phone') }}</small>
                            @enderror
                        </div>
                        
                        <div class="horus-form-group">
                            <label class="horus-form-label">ADDRESS LINE 1</label>
                            <textarea name="address" class="horus-form-input" rows="2" required>@if (isset($logged_user)) {{ $logged_user->address }} @else {{ old('address') }} @endif</textarea>
                            @error('address')
                                <small class="text-danger">{{ $errors->first('address') }}</small>
                            @enderror
                        </div>
                        
                        <div class="horus-form-group">
                            <label class="horus-form-label">ADDRESS LINE 2</label>
                            <input type="text" class="horus-form-input">
                        </div>
                        
                        <div class="horus-form-row-three">
                            <div class="horus-form-group">
                                <label class="horus-form-label">CITY</label>
                                <select onchange="loadShipping()" id="selectedArea" class="horus-form-input" required>
                                    @foreach ($areas as $area)
                                        <option value='{{ $area->id }}%%{{ number_format($area->rate, 2) }}'
                                            @selected(isset($logged_user) && $logged_user->area_id == $area->id)>
                                            {{ $area->name }} - {{ $area->arabic_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('area')
                                    <small class="text-danger">{{ $errors->first('area') }}</small>
                                @enderror
                            </div>
                            <div class="horus-form-group">
                                <label class="horus-form-label">STATE</label>
                                <input type="text" class="horus-form-input" value="Egypt" readonly>
                            </div>
                            <div class="horus-form-group">
                                <label class="horus-form-label">ZIP CODE</label>
                                <input type="text" class="horus-form-input">
                            </div>
                        </div>
                        
                        <!-- Order Notes -->
                        <div class="horus-form-group">
                            <label class="horus-form-label">ORDER NOTES (OPTIONAL)</label>
                            <textarea name="note" class="horus-form-input" rows="2" placeholder="Notes about your order, e.g. special notes for delivery.">{{ old('note') }}</textarea>
                        </div>
                    </div>
                </div>
                
                <!-- Order Details Section -->
                <div class="horus-checkout-section">
                    <h2 class="horus-checkout-title">ORDER DETAILS</h2>
                    
                    <!-- Order Items -->
                    @foreach ($cart->items as $item)
                        <div class="horus-order-item">
                            <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="horus-order-item-image">
                            <div class="horus-order-item-details">
                                <h4>{{ $item->title }}</h4>
                                <div class="horus-order-item-quantity">Quantity: {{ $item->quantity }}</div>
                            </div>
                            <div class="horus-order-item-price">
                                {{ number_format($item->quantity * $item->price, 2) }}
                            </div>
                        </div>
                    @endforeach
                    
                    <!-- Order Summary -->
                    <div class="horus-order-summary">
                        <div class="horus-summary-row">
                            <span>ORDER VALUE</span>
                            <span>{{ number_format($cart->total, 2) }}</span>
                        </div>
                        <div class="horus-summary-row">
                            <span>SHIPPING VALUE</span>
                            <span id="shippingCheckout">0.00</span>
                        </div>
                        <div class="horus-summary-row">
                            <span>VAT</span>
                            <span>0.00</span>
                        </div>
                        <div class="horus-summary-row total">
                            <span>TOTAL</span>
                            <span id="calculatedTotal">{{ number_format($cart->total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Place Order Button -->
            <button type="submit" class="horus-place-order-btn">PLACE ORDER</button>
            
            <!-- WhatsApp Order Button -->
            {{-- <button type="button" class="horus-place-order-btn" onclick="sendWhatsappMsg()" style="margin-top: 10px; background-color: #25D366;">
                <i class="fa fa-whatsapp"></i> ORDER USING WHATSAPP
            </button> --}}
        </form>
    </div>

    <script>
        function loadShipping() {
            var selectedArea = $('#selectedArea').val().split('%%')
            var shippingPrice = parseFloat(selectedArea[1]);
            var selectedAreaID = selectedArea[0];

            $('#selectedAreaID').val(selectedAreaID)

            $('#shippingCheckout').html(shippingPrice.toLocaleString(undefined, {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2,
            }))
            var cartTotal = parseFloat({{ number_format($cart->total, 2) }})

            $('#calculatedTotal').html((cartTotal + shippingPrice).toLocaleString(
                undefined, {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2,
                }
            ))
        }

        document.addEventListener('DOMContentLoaded', function() {
            loadShipping()
        })

        function sendWhatsappMsg() {
            if (!$('#checkoutForm')[0].checkValidity()) {
                $('#checkoutForm')[0].reportValidity();
                return;
            }
            var formData = $('#checkoutForm').serialize();

            $.ajax({
                url: "{{ url('order/whatsapp/submit') }}",
                type: 'POST',
                data: formData,
                success: function(response) {
                    window.open(response.url, '_blank');
                },
                error: function(xhr, status, error) {
                    alert('An error occurred while submitting the order via WhatsApp.');
                }
            });
        }
        
        // Toggle payment method details
        document.querySelectorAll('input[name="payment_method"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                const cardDetails = document.getElementById('cardDetails');
                if (this.value === 'card') {
                    cardDetails.style.display = 'block';
                } else {
                    cardDetails.style.display = 'none';
                }
            });
        });
    </script>
@endsection

@extends('layouts.site')

@section('content')
<section id="content" class="clearfix">

    <div class="title-breadcrumb">
        <div class="container">
            <div class="col-md-12">
                <div class="collection-listing-title">
                    <h2 class="collection-title">Checkout</h2>
                </div>
                <!-- Begin breadcrumb -->
                <div class="breadcrumb clearfix">
                    <span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="{{url('home')}}" title="{{env('APP_NAME')}}" itemprop="url"><span itemprop="title">Home</span></a></span>
                    <span class="arrow-space"><i class="fa fa-angle-right"></i></span>
                    <span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="{{url('cart')}}" title="Your Cart" itemprop="url"><span itemprop="title">Checkout</span></a></span>
                </div>
            </div>
        </div>
    </div>
    <div class="container">

        @if( !isset($cart) || $cart->count==0)
        <div class="col-md-12 expanded-message">
            <br>
            <br>
            <h3 class="tc">Your cart is currently empty.</h3>
        </div>
        @else
        <script>
            function updateTotal(){
                let total = '{{$cart->total}}'
                var selectedDel = $('#area option:selected').text();
                let deliveryTotal = selectedDel.slice(selectedDel.indexOf(' - ')+3 , selectedDel.indexOf('EGP') )
                $('#deliveryFee').html(deliveryTotal+'EGP');
                $('#orderTotal').html(new Intl.NumberFormat().format(parseInt(deliveryTotal) + parseInt(total)) + 'EGP');
            }   
            $( document ).ready(function() {
                updateTotal()
            });
        </script>
        <div class="col-md-8">
            <div id="cart">
                <form method="post" id="cartform">
                    @csrf
                    <table>
                        <thead>
                            <tr>
                                <th class="image">Product Name</th>
                                <th class="price">Price</th>
                                <th class="qty">Quantity</th>
                                <th class="total">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cart->items as $item)

                            <tr id="cart-row-{{$loop->index}}">
                                <input type="hidden" name="product[{{$loop->index}}]" value="{{$item->id}}">
                                <input type="hidden" name="color[{{$loop->index}}]" value="{{$item->color->id}}">
                                <input type="hidden" name="size[{{$loop->index}}]" value="{{$item->size->id}}">
                                <td class="image">
                                    <div class="product_image">
                                        <a href="{{url("product/" . $item->id)}}">
                                            <img src="{{$item->image_url}}" alt="{{$item->title}}">
                                        </a>
                                    </div>
                                    <div class="product_name">
                                        <a href="{{url("product/" . $item->id)}}">
                                            <strong>{{$item->title}} : {{$item->variant}}</strong>

                                        </a>
                                    </div>
                                </td>
                                <td class="price"><span class="money">{{$item->price}}EGP</span></td>
                                <td class="qty"><span class="money">{{$item->quantity}}</span> </td>
                                <td class="total title-1"><span class="money">{{number_format($item->price * $item->quantity)}}EGP</span></td>
                            </tr>
                            @endforeach

                            <tr class="summary">
                                <td class="total" colspan="1">Cart Total</td>
                                <td class="price cart-total" colspan="1"><span class="total"><strong><span class="money">{{number_format($cart->total)}}EGP</span></strong></span></td>
                                <td class="total" colspan="1">Delivery Fees</td>
                                <td class="price delivery-fee" colspan="1"><span class="total"><strong><span class="money" id="deliveryFee"></span></strong></span></td>
                            </tr>
                            <tr class="summary">
                                <td class="total" colspan="1">Order Total</td>

                                <td class="price order-total" colspan="3"><span class="total"><strong><span class="money" id="orderTotal"></span></strong></span></td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>

        <div class="col-md-4">
            <div id="checkout-form">
                <form method="post" id="create_customer" method="POST" action="{{$submitOrderUrl}}" accept-charset="UTF-8">
                    @csrf
                    <h4>Checkout</h4>

                    @if($is_logged)
                    <input type="hidden" name=user value="{{$logged_user->id}}">
                    <input type="hidden" name=guest value=2>
                    @else
                    <input type="hidden" name=guest value=1>
                    @endif
                    <div id="first_name" class="clearfix large_form">
                        <label for="first_name" class="label">@if($is_logged) Logged In User @endif Name </label>
                        <input type="text" value="{{$is_logged ? $logged_user->name : old('guestName')}}" placeholder="Mohamed Ahmed" @if(!$is_logged) name="guestName" @endif id="first_name" class="text" size="30" {{$is_logged ? 'readonly'
                            : "" }} required>
                        <div style="margin-bottom: 9px">
                            <small class="text-danger">{{$errors->first('name')}}</small>
                        </div>
                    </div>

                    <div id="mobile" class="clearfix large_form">
                        <label for="mobile" class="label">Phone</label>
                        <input type="text" value="{{$is_logged ? $logged_user->mobile : old('mobile')}}" name="phone" id="mobile" class="text" size="30" minlength="11" placeholder="01231230000" required>
                        <div style="margin-bottom: 9px">
                            <small class="text-danger">{{$errors->first('phone')}}</small>
                        </div>
                    </div>

                    <div class="addresses-country">
                        <label class="collection-filters__label" for="area">Delivery Area</label>
                        <div class="select">
                            <select class=" addresses-country__sort" id="area" name="area" aria-describedby="a11y-refresh-page-message" onchange="updateTotal()" required>
                                @foreach ($areas as $area)
                                <option value="{{$area->id}}" @if ($area->id == ($is_logged ? $logged_user->area_id : old('area'))) selected
                                    @endif
                                    >{{$area->name}} - {{$area->rate}}EGP</option>
                                @endforeach
                            </select>
                        </div>
                        <div style="margin-bottom: 9px">
                            <small class="text-danger">{{$errors->first('area')}}</small>
                        </div>
                    </div>

                    <div id="last_name" class="clearfix large_form">
                        <label for="address" class="label">Address</label>
                        <textarea name="address" id="address" class="textarea" size="30" placeholder="Delivery Address" required>{{old("address")}}</textarea>
                        <div style="margin-bottom: 9px">
                            <small class="text-danger">{{$errors->first('address')}}</small>
                        </div>
                    </div>
                    <div id="last_name" class="clearfix large_form">
                        <label for="address" class="label">Note</label>
                        <textarea name="note" id="address" class="textarea" size="30" placeholder="Leave us a note..">{{old('note')}}</textarea>
                        <div style="margin-bottom: 9px">
                            <small class="text-danger">{{$errors->first('note')}}</small>
                        </div>
                    </div>
                    <p>Payment Option: Cash On Delivery</p>
                    <input type="hidden" name=option value=1>



                    <div class="action_bottom">
                        <input class="btn btn-3" type="submit" value="Submit Order">
                    </div>
                </form>
            </div>

        </div>
        @endif
    </div>
</section>
@endsection
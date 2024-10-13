@extends('layouts.site')

@section('content')
<section id="content" class="clearfix">
    <div id="cart">
        <div class="title-breadcrumb">
            <div class="container">
                <div class="col-md-12">
                    <div class="collection-listing-title">
                        <h2 class="collection-title">Your Cart</h2>
                    </div>
                    <!-- Begin breadcrumb -->
                    <div class="breadcrumb clearfix">
                        <span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="{{url('home')}}" title="{{env('APP_NAME')}}" itemprop="url"><span itemprop="title">Home</span></a></span>
                        <span class="arrow-space"><i class="fa fa-angle-right"></i></span>
                        <span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="{{url('cart')}}" title="Your Cart" itemprop="url"><span itemprop="title">Your Cart</span></a></span>
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
            <div class="col-md-12">
                <div class="row">
                    <form method="post" id="cartform">
                        @csrf
                        <table>
                            <thead>
                                <tr>
                                    <th class="image">Product Name</th>
                                    <th class="price">Price</th>
                                    <th class="qty">Quantity</th>
                                    <th class="total">Total</th>
                                    <th class="remove">Remove</th>
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
                                    <td class="qty">
                                        <div class="quantity-wrapper">
                                            <div class="wrapper">
                                                <span class="qty-down btooltip decrease" data-toggle="tooltip" data-placement="top" data-src="#cart_qty_{{$loop->index}}" data-original-title="Decrease">
                                                    <i class="fa fa-minus"></i>
                                                </span>
                                                <input type="number" size="4" name="quantity[{{$loop->index}}]" id="cart_qty_{{$loop->index}}" min="1" max="{{$item->availableItems}}" class="tc item-quantity"
                                                    value="{{$item->quantity}}">
                                                <span class="qty-up btooltip increase" data-toggle="tooltip" data-placement="top" data-src="#cart_qty_{{$loop->index}}" data-original-title="Increase">
                                                    <i class="fa fa-plus"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="total title-1"><span class="money">{{number_format($item->price * $item->quantity)}}EGP</span></td>
                                    <td class="remove"><a href="javascript:void(0)" onclick="removeRow('cart-row-{{$loop->index}}')" class="cart"><i class="fa fa-trash"></i></a></td>
                                </tr>
                                @endforeach

                                <tr class="summary">
                                    <td class="total" colspan="2">Total</td>
                                    <td class="price" colspan="3"><span class="total"><strong><span class="money">{{number_format($cart->total)}}EGP</span></strong></span></td>
                                </tr>
                            </tbody>

                        </table>
                        <div class="col-md-12 cart-buttons">
                            <div class="buttons row">
                                <input type="submit" id="update-cart" class="btn btn-3" name="update" value="Update Cart">
                                <input type="button" id="continue-cart" class="btn btn-3" name="continue" value="Continue Shopping" onclick="location.href='{{url('all')}}'">
                                <input type="submit" id="checkout" class="btn btn-3" name="checkout" value="Proceed to Check Out">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endif

        </div>
    </div>
</section>

@endsection

@section('js_content')
<script>
    function removeRow(rowID){
        $("#" + rowID).remove();
    }

</script>
@endsection
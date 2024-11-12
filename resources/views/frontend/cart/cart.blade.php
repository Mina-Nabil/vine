@extends('layouts.site')

@section('content')
    <!-- Page Content -->
    <div class="container ws-page-container">
        <div class="row">                                                                 

            <!-- Cart Content -->
            <div class="ws-cart-page">
                <div class="col-sm-8">
                    <div class="ws-mycart-content">                
                        <table class="table"> 
                            <thead>
                                <tr>
                                    <th class="cart-item-head">&nbsp;</th>
                                    <th class="cart-item-head">Item</th> 
                                    <th class="cart-item-head">Price</th> 
                                    <th class="cart-item-head">Quantity</th> 
                                    <th class="cart-item-head">Total</th>
                                    <th class="cart-item-head">&nbsp;</th>
                                </tr> 
                            </thead>    

                            <tbody>
                                <tr class="cart-item"> 
                                    <td class="cart-item-cell cart-item-thumb">                                
                                        <a href="#">
                                            <img src="assets/img/works/illustrated/4.jpg" class="img-responsive" alt="Alternative Text">
                                        </a>                                                                   
                                    </td>
                                    <td class="cart-item-cell cart-item-title">                                                               
                                        <h3><a href="#">Arkose Factor</a></h3>                                   
                                    </td>                                                       
                                    <td class="cart-item-cell cart-item-price">                                
                                        <span class="amount">$39.00</span>                                
                                    </td> 
                                    <td class="cart-item-cell cart-item-quantity">                                
                                        <input type="number" value="1">                                
                                    </td> 
                                    <td class="cart-item-cell cart-item-subtotal">                                
                                        <span class="amount">$39.00</span>                                
                                    </td>
                                     <td class="cart-item-cell cart-item-remove">                                
                                        <span><a href="#x"><i class="fa fa-times"></i></a></span>                            
                                    </td> 
                                </tr> 

                                <tr class="cart-item">                            
                                    <td class="cart-item-cell cart-item-thumb">                                
                                        <a href="#">
                                            <img src="assets/img/works/illustrated/2.jpg" class="img-responsive" alt="Alternative Text">
                                        </a>                                                                   
                                    </td>
                                    <td class="cart-item-cell cart-item-title">                                            
                                        <h3><a href="#">Pinning Moon</a></h3>                                  
                                    </td> 
                                    <td class="cart-item-cell cart-item-price">                                
                                        <span class="amount">$25.00</span>                                
                                    </td> 
                                    <td class="cart-item-cell cart-item-quantity">                                
                                        <input type="number" value="1">                                
                                    </td> 
                                    <td class="cart-item-cell cart-item-subtotal">                                
                                        <span class="amount">$25.00</span>                                
                                    </td>
                                    <td class="cart-item-cell cart-item-remove">                                
                                        <span><a href="#x"><i class="fa fa-times"></i></a></span>                                
                                    </td> 
                                </tr>    

                                <tr>
                                    <td colspan="6">

                                        <!-- Update Cart -->
                                        <div class="ws-update-cart">                                        
                                            <a class="btn ws-small-btn-black">Update Cart</a>                                              
                                        </div>
                                    </td>
                                </tr>    

                            </tbody> 
                        </table>                    
                    </div>
                </div>

                <!-- Cart Total -->
                <div class="col-sm-4">
                    <div class="ws-mycart-total">  
                        <h2>Cart Totals</h2>                    
                        <table>
                            <tbody>
                                <tr class="cart-subtotal">
                                    <th>Subtotal</th>
                                    <td><span class="amount">$64.00</span></td>
                                </tr>

                                <tr class="shipping">
                                    <th>Shipping</th>
                                    <td><span class="amount">$20.00</span></td>
                                </tr>                                

                                <tr class="order-total">
                                    <th>Total</th>
                                    <td><strong><span class="amount">$84.00</span></strong></td>
                                </tr>
                            </tbody>
                        </table>
                        <a class="btn ws-btn-fullwidth">Check Out</a>  
                    </div>
                </div>  
            </div>                

        </div>
    </div>
    <!-- End Page Content -->

@endsection

@section('js_content')
<script>
    function removeRow(rowID){
        $("#" + rowID).remove();
    }

</script>
@endsection
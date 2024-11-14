@extends('layouts.site')

@section('content')
<div class="ws-checkout-content clearfix">             

    <!-- Cart Content -->
    <div class="col-sm-7">

        <!-- Billing Details -->
        <div class="ws-checkout-billing">
            <h3>Order Details</h3>
            
            <!-- Form Inputs -->
            <form class="form-inline">        

                <!-- Name -->
                <div class="ws-checkout-first-row">
                    <div class="col-no-p ws-checkout-input col-sm-6">                                 
                        <label>First Name <span> * </span></label><br>                          
                        <input type="text">                                
                    </div>
                                                                
                    <div class="col-no-p ws-checkout-input col-sm-6">                                
                        <label>Last Name <span> * </span></label><br>                          
                        <input type="text">                                
                    </div> 
                </div>                                     

                <!-- Company -->
                <div class="col-no-p ws-checkout-input col-sm-12">                                
                    <label>Company Name <span> * </span></label><br>                          
                    <input type="text">                                
                </div>    

                <!-- Email -->
                <div class="ws-checkout-first-row">
                    <div class="col-no-p ws-checkout-input col-sm-6">                                 
                        <label>Email Adress <span> * </span></label><br>                          
                        <input type="email" placeholder="yourmail@gmail.com">                                
                    </div>
                                                                
                    <div class="col-no-p ws-checkout-input col-sm-6">                                
                        <label>Phone <span> * </span></label><br>                          
                        <input type="tel">                                
                    </div>  
                </div>  

                <!-- Country -->
                <div class="col-no-p ws-checkout-input col-sm-12">                                
                    <label>Country <span> * </span></label><br>                          
                    <input type="text" placeholder="United States">                                      
                </div>    

                <!-- Adress -->
                <div class="col-no-p ws-checkout-input col-sm-12">                                
                    <label>Adress <span> * </span></label><br>                          
                    <input type="text" placeholder="Street adresss">                                      
                </div>  

                <div class="col-no-p ws-checkout-input col-sm-12">
                    <input type="text" placeholder="Apartment, suite, unit etc.(optional)">                                      
                </div>

                <!-- Town -->
                <div class="col-no-p ws-checkout-input col-sm-12">                                
                    <label>Town / City <span> * </span></label><br>                          
                    <input type="text" placeholder="Town / City">                                      
                </div> 

                <!-- State -->
                <div class="ws-checkout-first-row">
                    <div class="col-no-p ws-checkout-input col-sm-6">                                 
                        <label>State / Country <span> * </span></label><br>                          
                        <input type="text">                                
                    </div>
                                                                
                    <div class="col-no-p ws-checkout-input col-sm-6">                                
                        <label>Postcode / ZIP <span> * </span></label><br>                          
                        <input type="text" placeholder="Postcode / ZIP">                                
                    </div>  
                </div>  

                <!-- Order Notes -->
                <div class="col-no-p ws-checkout-input col-sm-12">                                
                    <label>Order Notes</label><br>                          
                    <textarea placeholder="Notes about your order, e.g. special notes for delivery." rows="2" cols="5"></textarea>
                </div>                                            
            </form>

        </div>
    </div>

    <!-- Cart Total -->
    <div class="col-sm-5">
        <div class="ws-checkout-order">                        
            <h2>Your Oder</h2>      

            <!-- Order Table -->              
            <table>

                <!-- Title -->
                <thead>
                    <tr>
                        <th class="ws-order-product">Product</th>
                        <th class="ws-order-total">Total</th>
                    </tr>
                </thead>

                <!-- Products -->
                <tbody>
                    <tr>
                        <th>Arkose Factor x 1</th>
                        <td><span>$64.00</span></td>
                    </tr>

                    <tr>
                        <th>Pinning Moon x 1</th>
                        <td><span>$20.00</span></td>
                    </tr> 

                    <tr>
                        <th>Interstellar x 1</th>
                        <td><span>$20.00</span></td>
                    </tr>  
                    <tr>
                        <th>Subtotal</th>
                        <td><span>$104.00</span></td>
                    </tr>                                                              
                </tbody>

                <!-- Shipping -->
                <tfoot class="ws-checkout-shipping">                                
                    <tr>
                        <th>Shipping</th>
                        <td>                                       
                            <div class="radio">
                                <label><input type="radio" name="optradio">International Courier: <span>$35.00</span></label>
                            </div>                                                                                            
                      
                            <div class="radio">
                                <label><input type="radio" name="optradio">International Express Courier: <span>$228.00</span></label>
                            </div>                                                                                                                                    
                        </td>
                    </tr>
                    <tr class="ws-shipping-total">
                        <th>Total</th>
                        <td><span>$139.00</span></td>
                    </tr>
                </tfoot>
            </table>

            <!-- Payment Metod -->
            <div class="ws-shipping-payment">
                <div class="radio">
                    <label><input type="radio" name="optradio" checked >Paypal</label> 
                    <img src="assets/img/paypal.png" class="img-responsive" alt="PayPal Acceptance Mark">
                </div>   
                <p>Pay via PayPal, you can pay with your credit card if you don’t have a PayPal account.</p>
            </div>
            <a class="btn ws-btn-fullwidth">Proceed to PayPal</a>                          
        </div>                    
    </div>  

</div>
@endsection
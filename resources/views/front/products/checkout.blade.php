
<?php
use App\Cart;
use App\Product;
?>
@extends('layouts.front_layout.front_layout')
@section('content')

<div class="span9">
    <ul class="breadcrumb">
		<li><a href="{{url('/')}}">Home</a> <span class="divider">/</span></li>
		<li class="active">check out</li>
    </ul>
	<h3> check out [ <small><span class="totalCartItems">{{totalCartItems()}}</span> Item(s) </small>]<a href="{{url('/cart')}}" class="btn btn-large pull-right"><i class="icon-arrow-left"></i>back to cart </a></h3>	
	<hr class="soft"/>
	
	@if (Session::has('success_message'))
	<div class="alert alert-success " role="alert">
		{{Session::get('success_message')}}
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	@endif

	@if (Session::has('error_message'))
	<div class="alert alert-danger " role="alert">
		{{Session::get('error_message')}}
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	@endif

	<form id="checkoutForm" name="checkoutForm" action="{{url('/checkout')}}" method="post">
    <table class="table table-bordered">
		<tr><th> <strong> Delivery Addresses</strong> <a href="{{url('add-edit-delivery-address')}}">Add</a></th></tr>
        @foreach ($deliveryAddress as $address)
          
		 <tr> 
		 <td>
				<div class="control-group" style="float: left;margin-top:-2px;margin-right:5px">

					<input type="radio" id="address{{$address['id']}}" name="address_id" value="{{$address['id']}}" placeholder="Username">
				</div>
				<div class="control-group">
                      <label class="control-label">{{$address['name']}} , {{$address['address']}}
                    , {{$address['city']}} , {{$address['state']}} , {{$address['country']}}
                    
                    </label>
				</div>
			
				</div>
		  </td>

		  <td>
			  <a href="{{url('/add-edit-delivery-address/'.$address['id'])}}">Edit</a>
			  <a href="{{url('/delete-delivery-address/'.$address['id'])}}">Delete</a>
		  </td>
		  </tr>
          @endforeach
	</table>	
		
            <table class="table table-bordered">
			<tbody>
				 <tr>
                  <td> 
				<form action="javascript:void(0)" method="post" id="applyCoupon" class="form-horizontal" @if (Auth::check())
				user="1"
				@endif>
					@csrf
				<div class="control-group">
				<label class="control-label"><strong> Coupon CODE: </strong> </label>
				<div class="controls">
				<input  id="code" name="code" type="text" class="input-medium" placeholder="Enter Coupon CODE" >
				<button type="submit" class="btn"> Apply </button>
				</div>
				</div>
				</form>
				</td>
                </tr>
				
			</tbody>
			</table>


            <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Product</th>
                    <th colspan="2">Description</th>
                    <th>Quantity/Update</th>
                    <th>unit Price</th>
                    <th>Discount</th>
                
                    <th>sub Total</th>
                  </tr>
                </thead>
                <tbody>
             <?php $total_price=0?>
                  @foreach ($userCartItems as $item)
                  <tr>
                      <td > <img width="60" src="{{asset('images/product_images/small.'.$item['product']['main_image'])}}" alt=""/></td>
                      <td colspan="2">{{$item['product']['product_name']}}  ({{$item['product']['product_code']}})<br/>
                          Color : {{$item['product']['product_color']}}<br/>
                      size : {{$item['size']}}
                      </td>
                      <td>
                        <div class="input-append">
                          {{$item['quantity']}}
                        
                        </div>
                      </td>
                    
					  <?php $price=Cart::getProductAttribute($item['product_id'],$item['size']);
					  $attrPrice=Product::getDiscountedAttrPrice($item['product_id'],$item['size']);
				  
					  ?>
                      <td>Rs.{{$attrPrice['product_price']}}</td>
                      <td>Rs.{{$attrPrice['discount']}}</td>
                      
                      <td>Rs.{{$attrPrice['discounted_price']*$item['quantity']}}</td>
                    </tr>
                    <?php $total_price=$total_price+($attrPrice['discounted_price']*$item['quantity'])?>
            
                  @endforeach
                 
              
                  
                  
                  <tr>
                    <td colspan="6" style="text-align:right">Total Price:	</td>
                    <td> Rs.{{$total_price}}</td>
                  </tr>
                   <tr>
                    <td colspan="6" style="text-align:right">Coupon Discount:	</td>
                    <td class="couponAmount">
                      @if (Session::has('couponAmount'))
                          Rs.{{Session::get('couponAmount')}}
                      @else
                          Rs.0
                      @endif
                     </td>
                  </tr>
             
                   <tr>
                    <td colspan="6" style="text-align:right"><strong>grand TOTAL ({{$total_price}} - <span class="couponAmount">  @if (Session::has('couponAmount'))
                      Rs.{{Session::get('couponAmount')}}
                  @else
                      Rs.0
                  @endif</span>  ) =</strong></td>
                    <td class="label label-important" style="display:block"> <strong class="grand_total"> Rs.{{$grand_total=$total_price -Session::get('couponAmount')}} </strong></td>
                <?php Session::put('grand_total',$grand_total);?>  
				</tr>
                  </tbody>
              </table>

			  <table class="table table-bordered">
					<tbody>
						<tr>
							<td>
								<div class="control-group">
									<label for="" class="control-label">
									<strong>payment methods</strong>	
									</label>
									<div class="controls">
										<span>
											<input type="radio" name="payment_gateway" id="cod" value="cod"><strong>cod</strong>
											&nbsp;&nbsp;&nbsp;
											<input type="radio" name="payment_gateway" id="paypal" value="paypal"><strong>paypal</strong>
											&nbsp;&nbsp;&nbsp;
											
										</span>
									</div>
								</div>
							</td>
						</tr>
						
					</tbody>
			  </table>
			
			<!-- <table class="table table-bordered">
			 <tr><th>ESTIMATE YOUR SHIPPING </th></tr>
			 <tr> 
			 <td>
				<form class="form-horizontal">
				  <div class="control-group">
					<label class="control-label" for="inputCountry">Country </label>
					<div class="controls">
					  <input type="text" id="inputCountry" placeholder="Country">
					</div>
				  </div>
				  <div class="control-group">
					<label class="control-label" for="inputPost">Post Code/ Zipcode </label>
					<div class="controls">
					  <input type="text" id="inputPost" placeholder="Postcode">
					</div>
				  </div>
				  <div class="control-group">
					<div class="controls">
					  <button type="submit" class="btn">ESTIMATE </button>
					</div>
				  </div>
				</form>				  
			  </td>
			  </tr>
            </table> -->		
	<a href="{{url('/cart')}}" class="btn btn-large"><i class="icon-arrow-left"></i>back to cart </a>
<button type="submit" class="btn btn-large pull-right">place order <i class="icon-arrow-left"></i></button>	

</form>
</div>
@endsection

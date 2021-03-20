<?php
 use App\Cart;
 use App\Product;
?>
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
                <input class="span1" style="max-width:34px" value="{{$item['quantity']}}" id="appendedInputButtons" size="16" type="text">
                <button class="btn  btnItemUpdate qtyMinus" cartId="{{$item['id']}}" type="button"><i class="icon-minus"></i></button>
                <button class="btn btnItemUpdate qtyPlus" cartId="{{$item['id']}}" type="button"><i class="icon-plus"></i></button>
                <button class="btn btn-danger btnItemDelete" cartId="{{$item['id']}}"type="button"><i class="icon-remove icon-white"></i></button>				</div>
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
        <td colspan="6" style="text-align:right"><strong>Drang TOTAL ({{$total_price}} - <span class="couponAmount">  @if (Session::has('couponAmount'))
          Rs.{{Session::get('couponAmount')}}
      @else
          Rs.0
      @endif</span>  ) =</strong></td>
        <td class="label label-important" style="display:block"> <strong class="grand_total"> Rs.{{$total_price -Session::get('couponAmount')}} </strong></td>
      </tr>
      </tbody>
  </table>
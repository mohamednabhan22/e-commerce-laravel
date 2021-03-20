<?php use App\Product; ?>

<div class="tab-pane" id="listView">
          
    <hr class="soft"/>
    @foreach ($categoryProducts as $product)
    <div class="row">
        <div class="span2">
            <?php $product_image_path="images/product_images/small/".$product['main_Image'] ?>
                    @if (!empty($product['main_Image'])&&file_exists($product_image_path))
                    <img style="width: 150px" src="{{asset('images/product_images/small/'.$product['main_Image'])}}" alt=""></a>

                    @else
                    <img style="width: 150px" src="{{asset('images/product_images/small/no-image.png')}}" alt=""></a>

                    @endif
        </div>
        <div class="span4">
            <h3 > {{$product['product_name']}} </h3>
            <hr class="soft"/>
            <h5> {{$product['brand']['name']}}</h5>
          
              <p> {{$product['description']}}
            </p>
            <a class="btn btn-small pull-right" href="product_details.html">View Details</a>
            <br class="clr"/>
        </div>
        <div class="span3 alignR">
            <form class="form-horizontal qtyFrm">
                <h3>{{$product['product_price']}}</h3>
 
                
                <a href="product_details.html" class="btn btn-large btn-primary"> Add to <i class=" icon-shopping-cart"></i></a>
                <a href="product_details.html" class="btn btn-large"><i class="icon-zoom-in"></i></a>
                
            </form>
        </div>
    </div>
    <hr class="soft"/>
    @endforeach
 
     
    </div>
    <hr class="soft"/>

<div class="tab-pane  active" id="blockView">
    <ul class="thumbnails">
        @foreach ($categoryProducts as $product)
        <li class="span3">
            <div class="thumbnail">
                <a href="{{url('product/'.$product['id'])}}">
                    <?php $product_image_path="images/product_images/small/".$product['main_Image'] ?>
                    @if (!empty($product['main_Image'])&&file_exists($product_image_path))
                    <img style="width: 150px" src="{{asset('images/product_images/small/'.$product['main_Image'])}}" alt=""></a>

                    @else
                    <img style="width: 150px" src="{{asset('images/product_images/small/no-image.png')}}" alt=""></a>

                    @endif

                </a>
                <div class="caption">
                    <h5>{{$product['product_name']}}</h5>
                    <p>
                        {{$product['brand']['name']}}
                    </p>

                    <?php $discounted_price=Product::getDiscountedPrice($product['id']);   ?>
                    <form class="form-horizontal qtyFrm" method="post" action="{{url('add-to-cart')}}">
                        @csrf
                    <h4 style="text-align:center">
                        <input type="hidden" name="size" value="small">
                        <input type="hidden" name="quantity" value="1">
                        <input type="hidden" name="product_id" value=" {{$product['id']}}">
                        <button type="submit" class="btn btn-large btn-primary btn-block"> Add to <i class=" icon-shopping-cart"></i></button> 
                            @if ($discounted_price>0)
                                <del>  Rs.{{$product['product_price']}}</del>
                            @else
                             Rs.{{$product['product_price']}}   
                            @endif
                          </a></h4></form>
                          @if ($discounted_price>0)
                          <h4 > <font color="red">Discounted Price : {{$discounted_price}}</font> </h4>
                              
                          @endif
                </div>
            </div>
        </li>
        @endforeach
       
    
    </ul>
    <hr class="soft"/>
</div>
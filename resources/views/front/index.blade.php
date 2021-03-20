
<?php use App\Product; ?>

@extends('layouts.front_layout.front_layout')
@section('content')
<div class="span9">
    <div class="well well-small">
        <h4>Featured Products <small class="pull-right">{{$featuredItemsCount}} featured products</small></h4>
        <div class="row-fluid">
            <div id="featured" @if ($featuredItemsCount >4) class="carousel slide"  @endif >
                <div class="carousel-inner">
                @foreach ($featuredItemsChunk as $key=>  $featuredItem)
                <div class="item  @if ($key==1) active @endif">
                    <ul class="thumbnails">
                        @foreach ($featuredItem as $item)
                        <li class="span3">
                            <div class="thumbnail">
                                <i class="tag"></i>
                                <a href="{{url('product/'.$item['id'])}}">
                                    <?php $product_image_path="images/product_images/small/".$item['main_Image'] ?>
                                    @if (!empty($item['main_Image'])&&file_exists($product_image_path))
                                    <img style="width: 150px" src="{{asset('images/product_images/small/'.$item['main_Image'])}}" alt=""></a>
 
                                    @else
                                    <img style="width: 150px" src="{{asset('images/product_images/small/no-image.png')}}" alt=""></a>

                                    @endif

                                <div class="caption">
                                    <h5> {{$item['product_name']}}</h5>
                                    <?php $discounted_price=Product::getDiscountedPrice($item['id']);   ?>
                                    <h4 style="margin-left: 4rem;">
                                    @if ($discounted_price>0)
                                    <del>  Rs.{{$item['product_price']}}</del>
                                @else
                                 Rs.{{$item['product_price']}}   

                                @endif 
                            </h4>        
                                @if ($discounted_price>0)
                                    <h4 > <font color="red">Discounted Price : {{$discounted_price}}</font> </h4>
                                        
                                    @endif
                                </div>
                            </div>
                        </li>
                        @endforeach
                       
                     
                    </ul>
                </div>
                @endforeach
                   
                 
                </div>
                <a class="left carousel-control" href="#featured" data-slide="prev">‹</a>
                <a class="right carousel-control" href="#featured" data-slide="next">›</a>
            </div>
        </div>
    </div>
    <h4>Latest Products </h4>
    <ul class="thumbnails">
        @foreach ($newProducts as $product)
        <li class="span3">
            <div class="thumbnail">
                <a  href="{{url('product/'.$product['id'])}}">
                    <?php $product_image_path="images/product_images/small/".$product['main_Image'] ?>
                    @if (!empty($product['main_Image'])&&file_exists($product_image_path))
                    <img style="width: 150px" src="{{asset('images/product_images/small/'.$product['main_Image'])}}" alt=""></a>

                    @else
                    <img  style="width: 150px" src="{{asset('images/product_images/small/no-image.png')}}" alt=""></a>

                    @endif
                   </a>
                <div class="caption">
                    <h5>{{$product['product_name']}}</h5>
                    <p>
                        {{$product['product_code']}}
                    </p>
                    <p>
                        {{$product['product_color']}}
                    </p>
                    <?php $discounted_price=Product::getDiscountedPrice($item['id']);   ?>

                    <form class="form-horizontal qtyFrm" method="post" action="{{url('add-to-cart')}}">
@csrf
                    <h4 style="text-align:center">
                        
                        <input type="hidden" name="size" value="small">
                        <input type="hidden" name="quantity" value="1">
                        <input type="hidden" name="product_id" value=" {{$product['id']}}">
                        <button type="submit" class="btn btn-large btn-primary btn-block"> Add to <i class=" icon-shopping-cart"></i></button>     
                            @if ($discounted_price>0)
                            <del>  Rs.{{$item['product_price']}}</del>
                        @else
                         Rs.{{$item['product_price']}}   

                        @endif 
                    </h4>        
                        @if ($discounted_price>0)
                            <h4 > <font color="red">Discounted Price : {{$discounted_price}}</font> </h4>
                                
                            @endif</a></h4>       </form>         </div>
            </div>
        </li>
        @endforeach
       
      
    </ul>
</div>
@endsection

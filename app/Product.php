<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function section(){
        return $this->belongsTo('App\Section','section_id');
    }
    public function category(){
        return $this->belongsTo('App\Category','category_id');
    }
    public function brand(){
        return $this->belongsTo('App\Brand','brand_id');
    }

    public function attributes(){
        return $this->hasMany('App\ProductsAttribute');
    }
    public function images(){
        return $this->hasMany('App\ProductsImage');
    }

    public static function productFilters(){
            //filters Arrays
            $productFilters['fabricArray']=array('cotton','polyester','wool');
            $productFilters['sleeveArray']=array('full slleve','half sleeve','short sleeve','sleeveless');
            $productFilters['patternArray']=array('checked','plain','printed','self','solid');
            $productFilters['fitArray']=array('Regular','slim');
            $productFilters['occasionArray']=array('casual','formal');

            return $productFilters;

    }


    public static function getDiscountedPrice($product_id){
        $proDetails=Product::where('id',$product_id)->first()->toArray();

        $catDetails=Category::select('category_discount')->where('id',$proDetails['category_id'])->first()->toArray();
        if($proDetails['product_discount']>0){
            //if product discount is added from admin panel
            $discounted_price=$proDetails['product_price']-($proDetails['product_price']*$proDetails['product_discount']/100);
            //sale price =cost price-discount price
                            //500-(500*10/100=50)   =450
        }else if($catDetails['category_discount']>0){
             //if product discount is added from admin panel
             $discounted_price=$proDetails['product_price']-($proDetails['product_price']*$catDetails['category_discount']/100);
            
        }else{
            $discounted_price=0;
        }
       return $discounted_price; 

    }

    public static function getDiscountedAttrPrice($product_id,$size){
        $proAttrPrice=ProductsAttribute::where(['product_id'=>$product_id,'size'=>$size])->first()->toArray();

        $proDetails=Product::where('id',$product_id)->first()->toArray();

        $catDetails=Category::select('category_discount')->where('id',$proDetails['category_id'])->first()->toArray();
        if($proDetails['product_discount']>0){
            //if product discount is added from admin panel
            $discounted_price=$proAttrPrice['price']-($proAttrPrice['price']*$proDetails['product_discount']/100);
            $discount=$proAttrPrice['price']-$discounted_price;
            //sale price =cost price-discount price
                            //500-(500*10/100=50)   =450
        }else if($catDetails['category_discount']>0){
             //if product discount is added from admin panel
             $discounted_price=$proAttrPrice['price']-($proAttrPrice['price']*$catDetails['category_discount']/100);
             $discount=$proAttrPrice['price']-$discounted_price; 
        }else{
            $discounted_price=0;
            $discount=0;
        }
       return array('discounted_price'=> $discounted_price,'product_price'=>$proAttrPrice['price'],'discount'=>$discount) ; 

    }
}

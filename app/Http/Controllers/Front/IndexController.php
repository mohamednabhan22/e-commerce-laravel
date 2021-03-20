<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(){
        $page_name="index";
     $featuredItemsCount=Product::where('is_featured','yes')->where('status',1)->count();

     $featuredItems=Product::where('is_featured','yes')->where('status',1)->get()->toArray();
    // dd($featuredItems)
     $featuredItemsChunk=array_chunk($featuredItems,4);//هتقسم جدول المنتجات علي كذا اراي كل اراي  فيهم4 منتجات
    //  echo"<pre>" ;print_r($featuredItemsChunk);die;
   
    //get new products
    $newProducts=Product::orderBy('id','Desc')->where('status',1)->limit(6)->get()->toArray();
     return view('front.index',compact('page_name','featuredItemsChunk','featuredItemsCount','newProducts'));
    }
}

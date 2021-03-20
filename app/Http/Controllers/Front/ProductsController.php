<?php

namespace App\Http\Controllers\Front;

use App\Cart;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Session;
use App\Category;
use App\Coupon;
use App\DeliveryAddress;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrdersProduct;
use App\Product;
use App\ProductsAttribute;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
  public function listing(Request $request){
    if($request->ajax()){
$data=$request->all();
$url=$data['url'];
$categoryCount=Category::where(['status'=>1,'url'=>$url])->count();
if($categoryCount>0){

  $categoryDetails=Category::categoryDetails($url);
  // dd( $categoryDetails);
  $categoryProducts=Product::with('brand')->whereIn('category_id',$categoryDetails['catIds'])->where('status',1);
  // dd( $categoryProducts);

//if fabric filter is selected

if(isset($data['fabric'])&&!empty($data['fabric'])){
$categoryProducts->whereIn("fabric",$data['fabric']);

}

//if sleeve filter is selected

if(isset($data['sleeve'])&&!empty($data['sleeve'])){
  $categoryProducts->whereIn("sleeve",$data['sleeve']);
  
  }

  //if fit filter is selected

if(isset($data['fit'])&&!empty($data['fit'])){
  $categoryProducts->whereIn("fit",$data['fit']);
  
  }
  //if pattern filter is selected

if(isset($data['pattern'])&&!empty($data['pattern'])){
  $categoryProducts->whereIn("pattern",$data['pattern']);
  
  }
  //if occasion filter is selected

if(isset($data['occasion'])&&!empty($data['occasion'])){
  $categoryProducts->whereIn("occasion",$data['occasion']);
  
  }

  //if sort option is selected
  if(isset($data['sort'])&&!empty($data['sort'])){

    if($data['sort']=="product_latest"){
      $categoryProducts->orderBy('id','Desc');
    } else if($data['sort']=="product_name_a_z"){
      $categoryProducts->orderBy('product_name','Asc');
    } 
    else if($data['sort']=="product_name_z_a"){
      $categoryProducts->orderBy('product_name','Desc');
    } 
    else if($data['sort']=="price_lowest"){
      $categoryProducts->orderBy('product_price','Asc');
    } 
    else if($data['sort']=="price_highest"){
      $categoryProducts->orderBy('product_price','Desc');
    }else{
      $categoryProducts->orderBy('id','Desc');
    } 
  }
  $categoryProducts= $categoryProducts->paginate(10);
  return view('front.products.ajax_products_listing',compact('categoryDetails','categoryProducts','url'));
}else{
abort(404);


}
    }else{
      $url=Route::getFacadeRoot()->current()->uri();
      $categoryCount=Category::where(['status'=>1,'url'=>$url])->count();
      if($categoryCount>0){
    
        $categoryDetails=Category::categoryDetails($url);
        // dd( $categoryDetails);
        $categoryProducts=Product::with('brand')->whereIn('category_id',$categoryDetails['catIds'])->where('status',1);
        // dd( $categoryProducts);

       
        $categoryProducts= $categoryProducts->paginate(20);


            //product filters 
            $productFilters=Product::productFilters();
            $fabricArray=$productFilters['fabricArray'];
            $sleeveArray=$productFilters['sleeveArray'];
            $patternArray=$productFilters['patternArray'];
            $fitArray=$productFilters['fitArray'];
            $occasionArray=$productFilters['occasionArray'];
            $page_name="listing";
        return view('front.products.listing',compact('page_name','categoryDetails','categoryProducts','url','fabricArray','sleeveArray','patternArray','fitArray','occasionArray',));
    }else{
      abort(404);


      }
    }
   
  }


  public function detail($id){

    $productDetails=Product::with(['category','brand','attributes'=>function($query){
      $query->where('status',1);
    },'images'])->find($id)->toArray();

    $total_stock=ProductsAttribute::where('product_id',$id)->sum('stock');

    $relatedProducts=Product::where('category_id',$productDetails['category_id'])->where('id','!=',$id)->limit(3)->inRandomOrder()->get()->toArray();

    return view('front.products.detail',compact('productDetails','total_stock','relatedProducts'));
  }


  public function getProductPrice(Request $request){
if($request->ajax()){
$data=$request->all();
$getDiscountedAttrPrice=Product::getDiscountedAttrPrice($data['product_id'],$data['size']);
return $getDiscountedAttrPrice;


}

  }
  public function addtocart(Request $request){

$data=$request->all();

//check product stock is available or not
  $getProductStock=ProductsAttribute::where(['product_id'=>$data['product_id'],'size'=>$data['size']])->first()->toArray();



    if($getProductStock['stock']<$data['quantity']){
      $message="Required Quantity is not available ";
      $request->session()->flash('error_message', $message);
      return redirect()->back();
    }
    //Generate session id if not exist
    $session_id=$request->session()->get('session_id');;
    if(empty($session_id)){
$session_id=Session::getId();
// Session::set('session_id', $session_id );
session()->put('session_id', $session_id);

// Session::put('session_id', $session_id);
    }

//check product if  already exist in cart

if(Auth::check()){

  //user is logged in
$user_id=Auth::user()->id;
  $countProduct=Cart::where(['product_id'=>$data['product_id'],'size'=>$data['size'],'user_id'=>Auth::user()->id])->count();

}else{
  //user is not logged in
  $user_id=0;

  $countProduct=Cart::where(['product_id'=>$data['product_id'],'size'=>$data['size'],'session_id'=>Session::get('session_id')])->count();


}
if($countProduct>0){
  $message="product already exist in cart ";
  $request->session()->flash('error_message', $message);
  return redirect()->back();
}


//save product in cart 
// Cart::insert(['session_id'=>$session_id,'product_id'=>$data['product_id'],'size'=>$data['size'],'quantity'=>$data['quantity']]);
$cart=new Cart;
$cart->session_id=$session_id;
$cart->product_id=$data['product_id'];
$cart->size=$data['size'];
$cart->quantity=$data['quantity'];
$cart->user_id=$user_id;

$cart->save();



$message="product has been added in cart !";
$request->session()->flash('success_message', $message);
return redirect('cart');



  }

  public function cart(Request $request){
    $userCartItems=Cart::userCartItems();
    // dd($userCartItems);
    $userCartItemsCount=Cart::count();

    return view('front.products.cart',compact('userCartItems','userCartItemsCount'));
  }

  public function updateCartItemQty(Request $request){
if($request->ajax()){
  $data=$request->all();

$cartDetails=Cart::find($data['cartId']);

$availableStock=ProductsAttribute::select('stock')->where(['product_id'=>$cartDetails['product_id'],'size'=>$cartDetails['size']])->first()->toArray();

//check stock is available or not

if($data['qty']>$availableStock['stock']){
  $userCartItems=Cart::userCartItems();

  return response()->json([
   'message'=>'product stock is not available',
    'status'=>false,
    'view'=>(String)View::make('front.products.cart_items',compact('userCartItems'))
  ]);
}
  Cart::where('id',$data['cartId'])->update(['quantity'=>$data['qty']]);
  $userCartItems=Cart::userCartItems();
  $totalCartItems=totalCartItems();

  // return response()->json(['view'=>(String)View::make('front.products.cart_items',compact('userCartItems'))]);
  return response()->json([
     'status'=>true,
     'totalCartItems'=>$totalCartItems,
     'view'=>(String)View::make('front.products.cart_items',compact('userCartItems'))
   ]);}
  }


  public function deleteCartItem(Request $request){
 
    if($request->ajax()){
      $data=$request->all();
    Cart::where('id',$data['cartId'])->delete();
    $totalCartItems=totalCartItems();

    $userCartItems=Cart::userCartItems();

    // return response()->json(['view'=>(String)View::make('front.products.cart_items',compact('userCartItems'))]);
    return response()->json([
      'totalCartItems'=>$totalCartItems,

       'view'=>(String)View::make('front.products.cart_items',compact('userCartItems'))
     ]);
    }
 
  }

  public function applyCoupon(Request $request){

    if($request->ajax()){
      $data=$request->all();
  

    $userCartItems=Cart::userCartItems();
$couponCount=Coupon::where('coupon_code',$data['code'])->count();

if($couponCount==0){
  $totalCartItems=totalCartItems();

    $userCartItems=Cart::userCartItems();
        // return response()->json(['view'=>(String)View::make('front.products.cart_items',compact('userCartItems'))]);
        return response()->json([
          'status'=>false,
          'totalCartItems'=>$totalCartItems,
          'message'=>'this coupon is not valid',
           'view'=>(String)View::make('front.products.cart_items',compact('userCartItems'))
         ]);
}else{
  //get coupon details

  $couponDetails=Coupon::where('coupon_code',$data['code'])->first();
    //check if coupon is inactive
    if($couponDetails->status==0){
      $message="this coupon is not active";
    }

    //check if coupon is Expired
    $expiry_date=$couponDetails->expiry_date;
    $current_date=date('Y-m-d');
    if($expiry_date<$current_date){
      $message="this coupon is expired";
    }
    //check if coupon is from selected categories
    //get all selected categories from coupon
    $catArr=explode(",",$couponDetails->categories);
    //get cart items
    $userCartItems=Cart::userCartItems();
    
    //check if any item belong to coupon category
    foreach($userCartItems as $key =>$item){
      if(!in_array($item['product']['category_id'],$catArr)){
        $message="this coupon is not for one of the selected products !";
      }
    }

    //check if coupon belongs to loggedIn user
    //get all selected users of coupon 

    if(!empty($couponDetails->users)){
      $usersArr=explode(",",$couponDetails->users);

      //get user ID's of all selected users
  
      foreach($usersArr as $key =>$user){

        $getUserId=User::select('id')->where('email',$user)->first()->toArray();
        $userID[]=$getUserId['id'];
      }
    }
  

    //get cart total amount
    $total_amount=0;

    foreach($userCartItems as $key =>$item){
      if(!empty($couponDetails->users)){

      if(!in_array($item['user_id'],$userID)){
        $message="this coupon is not for you !";


      }}

      $attrPrice=Product::getDiscountedAttrPrice($item['product_id'],$item['size']);
$total_amount=$total_amount+($attrPrice['discounted_price']+$item['quantity']);
    }



    if(isset($message)){
      $totalCartItems=totalCartItems();

      $userCartItems=Cart::userCartItems();
          // return response()->json(['view'=>(String)View::make('front.products.cart_items',compact('userCartItems'))]);
          return response()->json([
            'status'=>false,
            'totalCartItems'=>$totalCartItems,

            'message'=>$message,
             'view'=>(String)View::make('front.products.cart_items',compact('userCartItems'))
           ]);
    }else{

      //check if amount type is fixed or percentage

      if($couponDetails->amount_type=="fixed"){
        $couponAmount=$couponDetails->amount;
      }else{
        $couponAmount=$total_amount+($couponDetails->amount/100);
      }
$grand_total=$total_amount-$couponAmount;
      //add coupon code & amount in session variables
      Session::put('couponAmount',$couponAmount);
      Session::put('couponCode',$data['code']);
      $message="coupon code successfully applied. you are availing discount !";
      $totalCartItems=totalCartItems();
      $userCartItems=Cart::userCartItems();

      return response()->json([
        'status'=>true,
        'totalCartItems'=>$totalCartItems,
        'couponAmount'=>$couponAmount,
        'grand_total'=>$grand_total,
        'message'=>$message,
         'view'=>(String)View::make('front.products.cart_items',compact('userCartItems'))
       ]);
    }

}

    }
  }


public function checkout(Request $request){
  if($request->isMethod('post')){
$data=$request->all();
if(empty($data['address_id'])){
  $message="please select Delivery address!";
  Session::flash('error_message',$message);
  return redirect()->back();
}  
  
if(empty($data['payment_gateway'])){
  $message="please select payment_method!";
  Session::flash('error_message',$message);
  return redirect()->back();
}  

if($data['payment_gateway']=="cod"){
  $payment_method="cod";
}else{
  $payment_method="prepaid";

}
//get delivery address from address_id
$deliveryAddress=DeliveryAddress::where('id',$data['address_id'])->first()->toArray();

DB::beginTransaction();
//insert order details
$order=new Order;
$order->user_id=Auth::user()->id;
$order->name=$deliveryAddress['name'];
$order->address=$deliveryAddress['address'];
$order->city=$deliveryAddress['city'];
$order->state=$deliveryAddress['state'];
$order->pinCode=$deliveryAddress['pinCode'];
// $order->email=Auth::user()->email;
$order->shipping_charges=0;
$order->mobile=$deliveryAddress['mobile'];
// $order->country=$deliveryAddress['country'];
$order->coupon_code=Session::get('couponCode');
$order->coupon_amount=Session::get('couponAmount');
$order->grand_total=Session::get('grand_total');

$order->order_status="new";
$order->payment_method=$payment_method;
$order->payment_gateway=$data['payment_gateway'];
// $order->coupon_code=0;
// $order->coupon_amount=0;
$order->save();

//get last insertd order_id
$order_id=DB::getPdo()->lastInsertId();

//get user cart items
$cartItems=Cart::where('user_id',Auth::user()->id)->get()->toArray();
foreach($cartItems as $key => $item){

  $cartItem=new OrdersProduct;
  $cartItem->order_id=$order_id; 
  $cartItem->user_id=Auth::user()->id; 

  $getProductDetails=Product::select('product_code','product_name','product_color')->where('id',$item['product_id'])->first()->toArray();
  $cartItem->product_id=$item['product_id']; 
  $cartItem->product_code=$getProductDetails['product_code']; 
  $cartItem->product_name=$getProductDetails['product_name']; 
  $cartItem->product_color=$getProductDetails['product_color']; 
  $cartItem->product_size=$item['size']; 
  $getDiscountedAttrPrice=Product::getDiscountedAttrPrice($item['product_id'],$item['size']);
  $cartItem->product_price=$getDiscountedAttrPrice['discounted_price'];
  $cartItem->product_qty=$item['quantity']; 
  $cartItem->save();


}


DB::commit();

if($data['payment_gateway']=="cod"){

        return redirect('/thanks');
        }else{
          echo"prepaid method coming soon";
        }
        echo"order placed"; die;

  }
  $userCartItems=Cart::userCartItems();
$deliveryAddress=DeliveryAddress::deliveryAddress();
  return view('front.products.checkout',compact('userCartItems','deliveryAddress'));
}

public function thanks(){
  if(Session::has('order_id')){
  //empty the user  cart
  Cart::where('user_id',Auth::user()->id)->delete();

  return view('front.products.thanks');

  }else{
    return redirect('cart');
  }


}


public function addEditDeliveryAddress($id=null,Request $request){

  if($id==""){
$title="add delivery address";
$address=new DeliveryAddress;
$message="Delivery Address added successfully";
   }else{
    $title="edit delivery address";
    $address=DeliveryAddress::find($id);
    $message="Delivery Address updated successfully";

  }

    
    
    if($request->isMethod('post')){

    $data=$request->all();
    
  $rules=[
    'name'=>'required',
    'address'=>'required',
    'city'=>'required',
    'state'=>'required',
    'country'=>'required',
    'pinCode'=>'required|numeric|digits:6',
    'mobile'=>'required|numeric|digits:11',

           ];
    
           $customMessages=[
            'name.required'=>'name is required',
            'mobile.required'=>'mobile is required',
            'address.required'=>'address is required',
            'city.required'=>'city is required',
            'country.required'=>'country is required',
            'pinCode.numeric'=>'valid pinCode is required',
            'pinCode.digits'=>' pinCode must be of 6  digit',
            'mobile.digits'=>' mobile must be of 11  digit',
            'pinCode.required'=>' pinCode is required',

            'state.required'=>'state is required',
            'mobile.numeric'=>'invalid mobile number',
                   ];
    
                   $this->validate($request,$rules,$customMessages);

    $address->user_id=Auth::user()->id;

    $address->name=$data['name'];
    $address->address=$data['address'];
    $address->country=$data['country'];
    $address->city=$data['city'];
    $address->state=$data['state'];
    $address->pinCode=$data['pinCode'];
    $address->mobile=$data['mobile'];
    $address->status=1;

    $address->save();
    $request->session()->flash('success_message', $message);
    return redirect('checkout');
    
}
return view('front.products.add_edit_delivery_address',compact('title','address'));

}

public function deleteDeliveryAddress($id){

  DeliveryAddress::where('id',$id)->delete();
  $message="Delivery Address deleted successfully";
  Session::flash('success_message', $message);
  return redirect()->back();


}

}

<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Coupon;
use App\Http\Controllers\Controller;
use App\Section;
use App\User;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Str;


class CouponController extends Controller 
{
    public function coupons(){
        Session::Put('page','coupons');
        $coupons=Coupon::get()->toArray();
        return view('admin.coupons.coupons',compact('coupons'));
    }

    public function updateCouponStatus(Request $request){
        if($request->ajax()){
            $data=$request->all();
          
            if($data['status']=="active"){
                $status=0;
            }else{
                $status=1;
            }
            Coupon::where('id',$data['coupon_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'coupon_id'=>$data['coupon_id']]);
        }
       
            }




            public function addEditCoupon(Request $request, $id=null){
                if($id==""){
                    $title="Add Coupon";
                   $coupon=new Coupon(); 
                   $CouponData=[];
                   $selCats=[];
                   $selUsers=[];
                //    $getCategories=[];
                   $message= "Coupon added successfully";
               }else{
                   $title="Edit Coupon";
                   $coupon=Coupon::find($id);
                   $selCats=explode(',',$coupon['categories']);
                   $selUsers=explode(',',$coupon['users']);
                   $message= "Coupon updated successfully";
                  
               
                }
                if($request->isMethod('post')){
                   $data=$request->all();
    //validation
                   $rules=[
                       'categories'=>'required',
                       'coupon_option'=>'required',
                      
                       'coupon_type'=>'required',
                       'amount_type'=>'required',
                       'amount'=>'required|numeric',
                       'expiry_date'=>'required',
                     
                   ];
                   $customMessages=[
                     'categories.required'=>'select categories',
                     'coupon_option.required'=>' select coupon_option',
                     'coupon_type.required'=>'select coupon_type',
                     'amount_type.required'=>'select amount_type',
                     'amount.numeric'=>'enter valid amount',
                     'expiry_date.required'=>'enter expiry_date',
                   
                
    
     
                 ];
                 $this->validate($request,$rules,$customMessages);
    
    
    // if(empty($data['title'])){
    //     $data['title']="";
    //  }
     
    // if(empty($data['alt'])){
    //    $data['alt']="";
    // }
    // if(empty($data['link'])){
    //    $data['link']="";
    // }
    
    if(isset($data['users'])){
        $users=implode(',',$data['users']);
    }else{
        $users="";
    }
    
    if(isset($data['categories'])){
        $categories=implode(',',$data['categories']);
    }

    if($data['coupon_option']=="automatic"){
        $coupon_code=Str::random(8);
    }else{
        $coupon_code=$data['coupon_option'];

    }
                   $coupon->coupon_option=$data['coupon_option'];
    
                   $coupon->coupon_code=$coupon_code;
                   $coupon->categories=$categories;
                   $coupon->users=$users;
                   $coupon->coupon_type=$data['coupon_type'];
                   $coupon->amount_type=$data['amount_type'];
                   $coupon->amount=$data['amount'];
                   $coupon->expiry_date=$data['expiry_date'];

                 
                   $coupon->status=1;
    
                   $coupon->save();
                   $request->session()->flash('success_message',$message);
                   return redirect('admin/coupons');
    
              }
              
                // $getSections=Section::get();
              
    
                $Coupons=Coupon::get()->toArray();
              $sections=Section::with('categories')->get();
              $users=User::select('email')->where('status',1)->get()->toArray();
                return view('admin.Coupons.add_edit_Coupon',compact('title','Coupons','coupon','sections','users','selCats','selUsers'));
    
               }


               public function deleteCoupon($id){
Coupon::find($id)->delete();
return redirect('admin/coupons');

               }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Brand;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Image;

class BrandController extends Controller
{
   public function brands(Request $request){
       $request->session()->put('page', 'brands');
       $brands=Brand::get();
       return view('admin.brands.brands',compact('brands'));
   }



   public function updateBrandStatus(Request $request){
    if($request->ajax()){
        $data=$request->all();
        if($data['status']=="active"){
            $status=0;
        }else{
            $status=1;
        }
        Brand::where('id',$data['brand_id'])->update(['status'=>$status]);
        return response()->json(['status'=>$status,'brand_id'=>$data['brand_id']]);
    }
   
        }


        public function addEditBrand(Request $request, $id=null){
            if($id==""){
               $title="Add Brand";
               $brand=new Brand(); 
               $brandData=[];
               $getCategories=[];
               $message= "brand added successfully";
           }else{
               $title="Edit brand";
               
               $brandData=Brand::where('id',$id)->first();
             

               $brand=Brand::find($id);
               $message= "brand updated successfully";

            }
            if($request->isMethod('post')){
               $data=$request->all();
//validation
               $rules=[
                   'brand_name'=>'required',
                
               ];
               $customMessages=[
                 'brand_name.required'=>'brand Name is required',
              
 
             ];
             $this->validate($request,$rules,$customMessages);

                  

               $brand->name=$data['brand_name'];
            
               $brand->status=1;
               $brand->save();
               $request->session()->flash('success_message',$message);
               return redirect('admin/brands');

            }
          
            
            return view('admin.brands.add_edit_brands',compact('title','brandData'));

           }

           public function deleteBrand(Request $request, $id){

            Brand::where('id',$id)->delete();
            $message="brand has been deleted successfully";
            $request->session()->flash('success_message', $message);
              return redirect()->back();
        }
}

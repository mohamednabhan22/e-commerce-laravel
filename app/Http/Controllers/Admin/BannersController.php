<?php

namespace App\Http\Controllers\Admin;

use App\Banner;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Image;
class BannersController extends Controller
{
    public function banners(Request $request){
        $request->session()->put('page','banners');
        $banners=Banner::get()->toArray();
        return view('admin.banners.banners',compact('banners'));
    }


    public function updateBannerStatus(Request $request){
        if($request->ajax()){
            $data=$request->all();
            if($data['status']=="active"){
                $status=0;
            }else{
                $status=1;
            }
            Banner::where('id',$data['banner_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'banner_id'=>$data['banner_id']]);
        }
       
            }

            
        public function addEditBanner(Request $request, $id=null){
            if($id==""){
                $title="Add Banner";
               $banner=new Banner(); 
               $bannerData=[];
            //    $getCategories=[];
               $message= "Banner added successfully";
           }else{
               $title="Edit Banner";
               $banner=Banner::find($id);
               $bannerData=Banner::find($id);
            //    $getCategories=Category::with('subcategories')->where([
            //        'parent_id'=>0,'section_id'=>$categoryData['section_id']
            //    ])->get();

             $Banner=Banner::find($id);
               $message= "Banner updated successfully";



            }
            if($request->isMethod('post')){
               $data=$request->all();
//validation
               $rules=[
                   'alt'=>'required',
                   'title'=>'required',
                  
                   'link'=>'required',
                 
               ];
               $customMessages=[
                 'alt.required'=>'Banner alt is required',
                 'title.required'=>' Banner title is required',
                 'link.required'=>'Banner  link is required',
               
            

 
             ];
             $this->validate($request,$rules,$customMessages);


if(empty($data['title'])){
    $data['title']="";
 }
 
if(empty($data['alt'])){
   $data['alt']="";
}
if(empty($data['link'])){
   $data['link']="";
}



//upload Banner images
if($request->hasFile('image')){
    // $banner=new Banner(); 
                   
    $image_tmp=$request->file('image');
    if($image_tmp->isValid()){
       
        $extension=$image_tmp->getClientOriginalExtension();
        $imageName=rand(111,99999).'.'.$extension;
        $banner_image_Path='images/Banner_images/'.$imageName;
      

        //upload the image
        Image::make($image_tmp)->resize(1170,480)->save($banner_image_Path);
       
        //save Banner image
        $banner->image=$imageName; 
       

   
    }}

   



//save Banner details to products table
// $categoryDetails=Category::find($data['category_id']);

            //    $product->section_id=$categoryDetails['section_id'];
               $banner->link=$data['link'];

               $banner->title=$data['title'];
               $banner->alt=$data['alt'];
             
             
               $banner->status=1;

               $banner->save();
               $request->session()->flash('success_message',$message);
               return redirect('admin/banners');

          }
          
            // $getSections=Section::get();
          

            $banners=Banner::get()->toArray();
          
            return view('admin.banners.add_edit_banner',compact('title','banners','bannerData'));

           }

            public function deleteBanner(Request $request,$id){

                $banner=Banner::where('id',$id)->first();
                // dd($banner);
                $bannerImagePath="images/banner_images/";
                
                if(file_exists($bannerImagePath.$banner->image)){
                    unlink($bannerImagePath.$banner->image);
                }

                Banner::where('id',$id)->delete();
                $request->session()->flash('success_message', 'Banner deleted successfully');
                return redirect()->back();
            }
}

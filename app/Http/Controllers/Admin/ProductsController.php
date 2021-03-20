<?php

namespace App\Http\Controllers\Admin;

use App\Brand;
use App\Category;
use App\DeliveryAddress;
use App\Http\Controllers\Controller;
use App\Product;
use App\ProductsAttribute;
use App\ProductsImage;
use App\Section;
use Illuminate\Http\Request;
use Image;

class ProductsController extends Controller
{
public function products(Request $request){
    $request->session()->put('page', 'products');
    $products=Product::with(['section'=>function($query){
        $query->select('id','name');
    },'category'=>function($query){
        $query->select('id','category_name');
    }])->get();
    return view('admin.products.products',compact('products'));
}


public function updateProductStatus(Request $request){
    if($request->ajax()){
        $data=$request->all();
        if($data['status']=="active"){
            $status=0;
        }else{
            $status=1;
        }
        Product::where('id',$data['product_id'])->update(['status'=>$status]);
        return response()->json(['status'=>$status,'product_id'=>$data['product_id']]);
    }
   
        }


        public function deleteProduct(Request $request, $id){

            Product::where('id',$id)->delete();
            $message="product  has been deleted successfully";
            $request->session()->flash('success_message', $message);
              return redirect()->back();
        }



        public function addEditProduct(Request $request, $id=null){
            if($id==""){
                $title="Add Product";
               $product=new Product(); 
               $productData=[];
            //    $getCategories=[];
               $message= "product added successfully";
           }else{
               $title="Edit Product";
               
               $productData=Product::find($id);
            //    $getCategories=Category::with('subcategories')->where([
            //        'parent_id'=>0,'section_id'=>$categoryData['section_id']
            //    ])->get();

             $product=Product::find($id);
               $message= "Product updated successfully";



            }
            if($request->isMethod('post')){
               $data=$request->all();
//validation
               $rules=[
                   'product_name'=>'required',
                   'brand_id'=>'required',
                  
                   'product-code'=>'required',
                   'product-price'=>'required|numeric',
                   'product-color'=>'required'
               ];
               $customMessages=[
                 'product_name.required'=>'product Name is required',
                 'product_code.required'=>' product code is required',
                 'product_price.required'=>'product  price is required',
                 'product_price.numeric'=>'Valid product price is required',
                 'product_color.required'=>'product  color is required'

 
             ];
             $this->validate($request,$rules,$customMessages);


if(empty($data['occasion'])){
    $data['occasion']="";
 }
 
if(empty($data['sleeve'])){
   $data['sleeve']="";
}
if(empty($data['fit'])){
   $data['fit']="";
}
if(empty($data['pattern'])){
   $data['pattern']="";
}
if(empty($data['wash_care'])){
    $data['wash_care']="";
 }
if(empty($data['description'])){
    $data['description']="";
 }
if(empty($data['product_video'])){
    $data['product_video']="";
 }
 if(empty($data['main_image'])){
    $data['main_image']="";
 }
if(empty($data['fabric'])){
   $data['fabric']="";
}
if(empty($data['meta_title'])){
    $data['meta_title']="";
 }
 if(empty($data['meta_description'])){
    $data['meta_description']="";
 }
 if(empty($data['meta_keywords'])){
    $data['meta_keywords']="";
 }
if(empty($data['is_featured'])){
  $is_featured="no";
}else{
   $is_featured="yes";
}


//upload product images
if($request->hasFile('main_image')){
                   
    $image_tmp=$request->file('main_image');
    if($image_tmp->isValid()){
        $image_name=$image_tmp->getClientOriginalName();
        $extension=$image_tmp->getClientOriginalExtension();
        $imageName=$image_name.'-'.rand(111,99999).'.'.$extension;
        $large_image_Path='images/product_images/large/'.$imageName;
        $medium_image_Path='images/product_images/medium/'.$imageName;
        $small_image_Path='images/product_images/small/'.$imageName;

        //upload the image
        Image::make($image_tmp)->save($large_image_Path);
        Image::make($image_tmp)->resize(520,600)->save($medium_image_Path);
        Image::make($image_tmp)->resize(260,300)->save($small_image_Path);

        //save product image
        $product->main_Image=$imageName; 
       

   
    }}

    //upload product  video
    if($request->hasFile('product_video')){
                   
        $video_tmp=$request->file('product_video');
        if($video_tmp->isValid()){
            $video_name=$video_tmp->getClientOriginalName();
            $extension=$video_tmp->getClientOriginalExtension();
            $videoName=$video_name.'-'.rand(111,99999).'.'.$extension;
            $video_Path='videos/product_videos/'.$videoName;
           
            //upload the video
           $video_tmp->move($video_Path,$videoName);
           

            //save product video
            $product->product_video=$video_name; 
           

       
        }}





//save product details to products table
$categoryDetails=Category::find($data['category_id']);

               $product->section_id=$categoryDetails['section_id'];
               $product->brand_id=$data['brand_id'];

               $product->category_id=$data['category_id'];
               $product->product_name=$data['product_name'];
               $product->product_price=$data['product-price'];
               $product->product_code=$data['product-code'];
               $product->product_color=$data['product-color'];
               $product->product_discount=$data['product-discount'];
               $product->product_weight=$data['product-weight'];
               $product->description=$data['description'];
               $product->wash_care=$data['wash_care'];
               $product->fabric=$data['fabric'];
               $product->pattern=$data['pattern'];
               $product->sleeve=$data['sleeve'];
               $product->fit=$data['fit'];
               $product->occasion=$data['occasion'];
               $product->product_video=$data['product_video'];
               $product->meta_title=$data['meta_title'];
               $product->meta_description=$data['meta_description'];
               $product->meta_keywords=$data['meta_keywords'];
               $product->is_featured=$is_featured;
               $product->status=1;

               $product->save();
               $request->session()->flash('success_message',$message);
               return redirect('admin/products');

          }
          
            // $getSections=Section::get();
            //product filters 
          $productFilters=Product::productFilters();
            $fabricArray=$productFilters['fabricArray'];
            $sleeveArray=$productFilters['sleeveArray'];
            $patternArray=$productFilters['patternArray'];
            $fitArray=$productFilters['fitArray'];
            $occasionArray=$productFilters['occasionArray'];


            $brands=Brand::where('status',1)->get();
        $sections=Section::with('categories')->get();
            return view('admin.products.add_edit_product',compact('title','fabricArray','sleeveArray','patternArray','fitArray','occasionArray','sections','productData','brands'));

           }


           public function deleteProductImage(Request $request, $id){
            //get category image
$productImage=Product::select('main_Image')->where('id',$id)->first();

//get product image path
$small_image_path='images/product_images/small/';
$medium_image_path='images/product_images/medium/';
$large_image_path='images/product_images/large/';


//delete product image from product_images_folder if exists
if(file_exists($small_image_path.$productImage->main_Image)){
 unlink($small_image_path.$productImage->main_Image);
}
if(file_exists($medium_image_path.$productImage->main_Image)){
    unlink($medium_image_path.$productImage->main_Image);
   }
   if(file_exists($large_image_path.$productImage->main_Image)){
    unlink($large_image_path.$productImage->main_Image);
   }
//delete product image from product table

Product::where('id',$id)->update(['main_Image'=>'']);
$message="product image has been deleted successfully";
$request->session()->flash('success_message', $message);
return redirect()->back();
        }



        public function deleteProductVideo(Request $request, $id){
            //get product video
$productVideo=product::select('product_video')->where('id',$id)->first();

//get product video path
$product_video_path='videos/product_videos/';

//delete product video from product_videos_folder if exists
if(file_exists($product_video_path.$productVideo->product_video)){
 unlink($product_video_path.$productVideo->product_video);
}
//delete product video from product table

Product::where('id',$id)->update(['product_video'=>'']);
$message="product video has been deleted successfully";
$request->session()->flash('success_message', $message);
return redirect()->back();
        }




        public function addAttributes(Request $request,$id){
            if($request->isMethod('post')){
                $data=$request->all();
                foreach ($data['sku'] as $key =>$value){
                   if(!empty($value)){

                       //sku already exists check
                    $attrCountSku=ProductsAttribute::where('sku',$value)->count();
                    if($attrCountSku>0){
                        $message='sku already exists. please add another sku';
                        $request->session()->flash('error_message', $message);
                        return redirect()->back();
                    }

                        //size already exists check
                        $attrCountSize=ProductsAttribute::where(['product_id'=>$id,'size'=>$data['size'][$key]])->count();
                        if($attrCountSize>0){
                            $message='size already exists. please add another sku';
                            $request->session()->flash('error_message', $message);
                            return redirect()->back();
                        }

                       $attribute=new ProductsAttribute;
                       $attribute->product_id=$id;
                       $attribute->sku=$value;
                       $attribute->size=$data['size'][$key];
                       $attribute->price=$data['price'][$key];
                       $attribute->stock=$data['stock'][$key];
                       $attribute->status=1;
                       $attribute->save();
                       $message='product attributes has been added successfully';
                       $request->session()->flash('success_message', $message);
                       return redirect()->back();


                   } 
                }
            }

$productData=Product::select('id','product_name','product_code','product_color','product_price','main_Image')->with('attributes')->find($id);
$title="add attributes";
return view('admin.products.add_attributes',compact('productData','title'));
        }



        public function editAttributes(Request $request,$id){
            if($request->isMethod('post')){
                $data=$request->all();
                foreach ($data['attrId'] as $key =>$value){
                   if(!empty($value)){
ProductsAttribute::where('id',$value)->update(['price'=>$data['price'][$key],'stock'=>$data['stock'][$key]]);

                   }}
                   $message='product attributes has been updated successfully';
                   $request->session()->flash('success_message', $message);
                   return redirect()->back();


        }
        
}

public function updateAttributeStatus(Request $request){
    if($request->ajax()){
        $data=$request->all();
        if($data['status']=="active"){
            $status=0;
        }else{
            $status=1;
        }
        ProductsAttribute::where('id',$data['attribute_id'])->update(['status'=>$status]);
        return response()->json(['status'=>$status,'attribute_id'=>$data['attribute_id']]);
    }
   
        }

        public function updateImageStatus(Request $request){
            if($request->ajax()){
                $data=$request->all();
                if($data['status']=="active"){
                    $status=0;
                }else{
                    $status=1;
                }
                ProductsImage::where('id',$data['image_id'])->update(['status'=>$status]);
                return response()->json(['status'=>$status,'image_id'=>$data['image_id']]);
            }
           
                }


        public function deleteAttribute(Request $request, $id){

            ProductsAttribute::where('id',$id)->delete();
            $message="product Attribute  has been deleted successfully";
            $request->session()->flash('success_message', $message);
              return redirect()->back();
        }


//addImages to product

        public function addImages(Request $request,$id){
          
            if($request->isMethod('post')){
                $data=$request->all();
            
                if($request->hasFile('images')){
                  $images=$request->file('images'); 
            foreach($images as $key=>$image){

                $productImage=new ProductsImage;
                $image_tmp=$request->file('images')[$key];

                $extension=$image_tmp->getClientOriginalExtension();
                $imageName=rand(111,99999).'.'.$extension;
                $large_image_Path='images/product_images/large/'.$imageName;
                $medium_image_Path='images/product_images/medium/'.$imageName;
                $small_image_Path='images/product_images/small/'.$imageName;
        
                //upload the image
                Image::make($image_tmp)->save($large_image_Path);
                Image::make($image_tmp)->resize(520,600)->save($medium_image_Path);
                Image::make($image_tmp)->resize(260,300)->save($small_image_Path);
        
                //save product image
                $productImage->image=$imageName; 
                $productImage->product_id=$id; 
                $productImage->status=1; 
                $productImage->save(); 
               
            }       
            $message="product Images  has been added successfully";
            $request->session()->flash('success_message', $message);
              return redirect()->back();
            
            }}

$productData=Product::with('images')->select('id','product_name','product_code','product_color','main_Image')->find($id);
$title="add images";
return view('admin.products.add_images',compact('productData','title'));
        }


        //delete product images  from product images table
        public function deleteImage(Request $request, $id){
            //get category image
$productImage=ProductsImage::select('image')->where('id',$id)->first();

//get product image path
$small_image_path='images/product_images/small/';
$medium_image_path='images/product_images/medium/';
$large_image_path='images/product_images/large/';


        //delete product images  from product images table
        if(file_exists($small_image_path.$productImage->image)){
 unlink($small_image_path.$productImage->image);
}
if(file_exists($medium_image_path.$productImage->image)){
    unlink($medium_image_path.$productImage->image);
   }
   if(file_exists($large_image_path.$productImage->image)){
    unlink($large_image_path.$productImage->image);
   }
//delete product image from product table

ProductsImage::where('id',$id)->delete();
$message="product image has been deleted successfully";
$request->session()->flash('success_message', $message);
return redirect()->back();
        }

     
}
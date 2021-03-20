<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Section;
use Illuminate\Http\Request;
use Image;
class CategoryController extends Controller
{
    public function categories(Request $request){

        $request->session()->put('page', 'categories');
        
        $categories=Category::with(['section','parentCategory'])->get();
        return view('admin.categories.categories',compact('categories'));
    }


    public function updateCategoryStatus(Request $request){
        if($request->ajax()){
            $data=$request->all();
            if($data['status']=="active"){
                $status=0;
            }else{
                $status=1;
            }
            Category::where('id',$data['category_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'category_id'=>$data['category_id']]);
        }
       
            }

            public function addEditCategory(Request $request, $id=null){
             if($id==""){
                $title="Add Category";
                $category=new Category(); 
                $categoryData=[];
                $getCategories=[];
                $message= "Category added successfully";
            }else{
                $title="Edit Category";
                
                $categoryData=Category::where('id',$id)->first();
                $getCategories=Category::with('subcategories')->where([
                    'parent_id'=>0,'section_id'=>$categoryData['section_id']
                ])->get();

                $category=Category::find($id);
                $message= "Category updated successfully";

             }
             if($request->isMethod('post')){
                $data=$request->all();
//validation
                $rules=[
                    'category_name'=>'required',
                    'section_id'=>'required|numeric',
                    'url'=>'required',
                    'category_image'=>'image',
                ];
                $customMessages=[
                  'category_name.required'=>'category Name is required',
                  'section_id.required'=>'section is required',
                  'url.required'=>' category URL is required',
                  'category_image.image'=>'Valid image is required'
  
              ];
              $this->validate($request,$rules,$customMessages);
//upload Category images
                if($request->hasFile('category_image')){
                    $category=new Category(); 
                    $image_tmp=$request->file('category_image');
                    if($image_tmp->isValid()){
                        $extension=$image_tmp->getClientOriginalExtension();
                        $imageName=rand(111,99999).'.'.$extension;
                        $imagePath='images/category_images/'.$imageName;
                        //upload the image
                        Image::make($image_tmp)->resize(300,400)->save($imagePath);
                        //save Category image
                        $category->category_Image=$imageName; 
                       

                   
                    }}
if(empty($data['category_discount'])){
    $data['category_discount']="";
}
if(empty($data['description'])){
    $data['description']="";
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
                $category->parent_id=$data['parent_id'];
                $category->section_id=$data['section_id'];
                $category->category_name=$data['category_name'];
                $category->category_discount=$data['category_discount'];
                $category->description=$data['description'];
                $category->url=$data['url'];
                
                $category->meta_title=$data['meta_title'];

                $category->meta_description=$data['meta_description'];
                $category->meta_keywords=$data['meta_keywords'];
                $category->status=1;
                $category->save();
                $request->session()->flash('success_message',$message);
                return redirect('admin/categories');

             }
           
             $getSections=Section::get();
             return view('admin.categories.add_edit_category',compact('title','getSections','categoryData','getCategories'));

            }

            public function appendCategoryLevel(Request $request){
if($request->ajax()){
$data=$request->all();
$getCategories=Category::with('subcategories')->where(['section_id'=>$data['section_id'],'parent_id'=>0,
'status'=>1
])->get();
return view('admin.categories.append_categories_level',compact('getCategories'));

}

            }

            public function deleteCategoryImage(Request $request, $id){
                //get category image
$categoryImage=Category::select('category_Image')->where('id',$id)->first();

 //get category image path
 $category_image_path='images/category_images/';

 //delete category image from category_images_folder if exists
 if(file_exists($category_image_path.$categoryImage->category_Image)){
     unlink($category_image_path.$categoryImage->category_Image);
 }
  //delete category image from category table

  Category::where('id',$id)->update(['category_Image'=>'']);
$message="category image has been deleted successfully";
$request->session()->flash('success_message', $message);
  return redirect()->back();
            }


            public function deleteCategory(Request $request, $id){

                Category::where('id',$id)->delete();
                $message="category  has been deleted successfully";
                $request->session()->flash('success_message', $message);
                  return redirect()->back();
            }

}



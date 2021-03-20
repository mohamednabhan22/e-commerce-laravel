<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function subcategories(){
        return $this->hasMany('App\Category','parent_id')->where('status',1);
    }

    public function section(){
        return $this->belongsTo('App\Section','section_id')->select('id','name');
    }

    public function parentCategory(){
        return $this->belongsTo('App\Category','parent_id')->select('id','category_name');
    }


    public static function categoryDetails($url){
        $categoryDetails=Category::select('id','parent_id','category_name','url','description')->with(['subcategories'=>function($query){
            $query->select('id','parent_id','category_name','url','description')->where('status',1);
        }])->where('url',$url)->first()->toArray();
        // dd( $categoryDetails);

        if($categoryDetails['parent_id']==0){
            //only show main category in breadcrumb
            $breadcrumbs="<a href='".url($categoryDetails['url'])."'>".$categoryDetails['category_name']."</a>";
           
        } else{
        //show main and sub  category in breadcrumb   
        $parentCategory=Category::select('category_name','url')->where('id',$categoryDetails['parent_id'])->first()->toArray();
        $breadcrumbs="<a href='".url($parentCategory['url'])."'>".$parentCategory['category_name']."</a> &nbsp;&nbsp;<span class='divider'>/</span><a href='"
        .url($categoryDetails['url'])."'>".$categoryDetails['category_name']."</a> "
        ;

        }

        $catIds=array();
        $catIds[]=$categoryDetails['id'];
        foreach($categoryDetails['subcategories'] as $key=>$subCat){
            $catIds[]=$subCat['id'];
        }
        return array('catIds'=>$catIds,'categoryDetails'=>$categoryDetails,'breadcrumbs'=>$breadcrumbs);
    }
}

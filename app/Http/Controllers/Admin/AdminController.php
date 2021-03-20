<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Hash;
use Image;

class AdminController extends Controller
{
    public function dashboard(Request $request){
        $request->session()->put('page', 'dashboard');
        return view('admin.admin_dashboard');
    } 


    public function setting(Request $request){
        $request->session()->put('page', 'settings');

        $adminDetails=Admin::where('email',Auth::guard('admin')->user()->email)->first();
        return view('admin.admin_setting',compact('adminDetails'));
    } 


    public function login(Request $request){
        if($request->isMethod('post')){
            $data=$request->all();
            $validatedData=$request->validate([
                'email'=>'required|email|max:255',
                'password'=>'required',

            ]);
            if(Auth::guard('admin')->attempt(['email'=>$data['email'],'password'=>$data['password']])){
                return redirect('admin/dashboard');
            }else{
                $request->session()->flash('error_message','Invalid Email or Password');
                return redirect()->back();
            }
        }
        return view('admin.admin_login');
    } 



    public function logout(){
        Auth::guard('admin')->logout();
        return redirect('admin');
    } 


    public function checkCurrentPassword(Request $request){
      $data=$request->all();
      if(Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)){
          echo"true";}
          else{
            echo "false";
          }
      }

      
      public function updateCurrentPassword(Request $request){
          
        $request->session()->put('page', 'update-password');

        $data=$request->all();
        // check if current user is correct
        if(Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)){
             // check if new confirm pass  is matching
           if($data['new_pwd']==$data['confirm_pwd']){
            Admin::where('id',Auth::guard('admin')->user()->id)->update(['password'=> bcrypt($data['new_pwd'])]);
            $request->session()->flash('success_message',' password has been updated successfully');

           }else{
            $request->session()->flash('error_message','new password and confirm password not match');;
           
           }
        
        }
            else{
             $request->session()->flash('error_message','Your current password is incorrect');;
            }
            return redirect()->back();
      }



      public function updateAdminDetails(Request $request){
        $request->session()->put('page', 'update-admin-details');

        if($request->isMethod('post')){
              $data=$request->all();
              $rules=[
                  'admin_name'=>'required|alpha',
                  'admin_mobile'=>'required|numeric',
                  'admin_image'=>'image'
              ];
              $customMessages=[
                'admin_name.required'=>' Name is required',
                'admin_name.alpha'=>' Valid Name is required',
                'admin_mobile.required'=>'Mobile is required',
                'admin_mobile.numeric'=>' Valid Mobile is required',
                'admin_image.image'=>'Valid image is required'

            ];
            $this->validate($request,$rules,$customMessages);

            if($request->hasFile('admin_image')){
                $image_tmp=$request->file('admin_image');
                if($image_tmp->isValid()){
                    $extension=$image_tmp->getClientOriginalExtension();
                    $imageName=rand(111,99999).'.'.$extension;
                    $imagePath='images/admin_images/admin_photos/'.$imageName;
                    //upload the image
                    Image::make($image_tmp)->resize(300,400)->save($imagePath);

                }else if(!empty($data['current_admin_image'])){
                    $imageName=$data['current_admin_image'];
                }else{
                    $imageName="";
                }
            }
                //update admin details
                Admin::where('email',Auth::guard('admin')->user()->email)->update(['name'=> $data['admin_name'],'mobile'=> $data['admin_mobile'],'image'=> $imageName]);
                $request->session()->flash('success_message',' Admin Details has been updated successfully');
                return redirect()->back();
          }else {
          return view('admin.update_admin_details');
      }}
    } 


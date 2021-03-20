<?php

namespace App\Http\Controllers\Front;

use App\Cart;
use App\Http\Controllers\Controller;
use App\Sms;
use App\User;
use Illuminate\Http\Request;
use Session;
use Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    public function loginRegister(){
        return view('front.users.login_register');
    }

    public function registerUser(Request $request){
       
        $data=$request->all();
    
        $rules=[
          'name'=>'required',
          'address'=>'required',
          'email'=>'required',
          'password'=>'required',
          'mobile'=>'required|numeric|digits:11',
      
                 ];
          
                 $customMessages=[
                  'name.required'=>'name is required',
                  'mobile.required'=>'mobile is required',
                  'address.required'=>'address is required',
                  'password.required'=>'password is required',
                 
                  'mobile.digits'=>' mobile must be of 11  digit',
                  
                  'mobile.numeric'=>'invalid mobile number',
                         ];
          
                         $this->validate($request,$rules,$customMessages);

        $userCount=User::where('email',$data['email'])->count();

        if($userCount>0){
            $message="Email already exists !";
            $request->session()->flash('error_message', $message);
            return redirect()->back();
        }else{
            $user=new User;
            $user->name=$data['name'];
            $user->mobile=$data['mobile'];
            $user->address=$data['address'];
            $user->city='d';
            $user->country='d';
            $user->pinCode='d';
            $user->state='d';
            $user->status=0;

            $user->email=$data['email'];
            $user->password=bcrypt($data['password']) ;
           
            $user->save();

            //send confirmation Email 
            
            $email=$data['email'];
            $messageData=[
                'email'=>$data['email'],
                'name'=>$data['name'],
                'code'=>base64_encode( $data['email'])


            ];
            // Mail::send('emails.confirmation', $messageData, function ($message) use ($email) {
            //     // $message->from('john@johndoe.com', 'John Doe');
            //     // $message->sender('john@johndoe.com', 'John Doe');
            //     $message->to($email);
            //     // $message->cc('john@johndoe.com', 'John Doe');
            //     // $message->bcc('john@johndoe.com', 'John Doe');
            //     // $message->replyTo('john@johndoe.com', 'John Doe');
            //     $message->subject('confirm your E-commerce Account');
            //     // $message->priority(3);
            //     // $message->attach('pathToFile');
            // });


            // $message="please confirm your email to activate your account";
            // $request->session()->put('success_message', $message);
            // return redirect()->back();

            if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){
                if(!empty(Session::get('session_id'))){
                    $user_id=Auth::user()->id;
                    $session_id=Session::get('session_id');
                    Cart::where('session_id',$session_id)->update(['user_id'=>$user_id]);
                }

                //send register sms
                $message='dear customer you have been successefully registered ';
                // $mobile=$data['mobile'];
                // Sms::sendSms($message,$mobile);
                $request->session()->flash('success_message', $message);

                return redirect('cart');
            }



        }
    }

    public function loginUser(Request $request){
        $data=$request->all();
        if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){
            
            if(!empty(Session::get('session_id'))){
                $user_id=Auth::user()->id;
                $session_id=Session::get('session_id');
                Cart::where('session_id',$session_id)->update(['user_id'=>$user_id]);
            }
            return redirect('cart');
        }else{
            $message="invalid email or password !";
            $request->session()->flash('error_message', $message);
            return redirect()->back();
        }
    }
    public function logout(){
        Auth::logout();
        return redirect('/');

    }

    public function account(Request $request){
        

   

$user_id=Auth::user()->id;
$userDetails=User::find($user_id)->toArray();

if($request->isMethod('post')){
    
$data=$request->all();
$rules=[
    'name'=>'required',
    'mobile'=>'required|numeric',
           ];
    
           $customMessages=[
            'name.required'=>'name is required',
            'mobile.required'=>'mobile is required',
            'mobile.numeric'=>'invalid mobile number',
                   ];
    
                   $this->validate($request,$rules,$customMessages);
$user=User::find($user_id);
$user->name=$data['name'];
$user->address=$data['address'];
$user->country=$data['country'];
$user->city=$data['city'];
$user->state=$data['state'];
$user->pinCode=$data['pinCode'];
$user->mobile=$data['mobile'];
$user->save();
$message="your account details has been updated successfully";
$request->session()->flash('success_message', $message);
return redirect()->back();

}

return view('front.users.account',compact('userDetails'));

    }

    public function updateCurrentPassword(Request $request){
          
       

        $data=$request->all();
        // check if current user is correct
        if(Hash::check($data['current_pwd'], Auth::user()->password)){
             // check if new confirm pass  is matching
           if($data['new_pwd']==$data['confirm_pwd']){
            User::where('id',Auth::user()->id)->update(['password'=> bcrypt($data['new_pwd'])]);
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
}

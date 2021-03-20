<?php

use App\Cart;


function makeImageFromName($name) {
    $userImage = "";
    $shortName = "";

    $names = explode(" ", $name);

    foreach ($names as $w) {
        $shortName .= $w[0];
    }

    $userImage = '<div class="name-image bg-primary">'.$shortName.'</div>';
    return $userImage;
}


function totalCartItems(){

    if(Auth::check()){

$user_id=Auth::user()->id;

$totalCartItems=Cart::where('user_id',$user_id)->sum('quantity');
}else{

    $session_id=Session::get('session_id');
    $totalCartItems=Cart::where('session_id',$session_id)->sum('quantity');

}
return $totalCartItems;

}
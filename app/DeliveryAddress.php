<?php

namespace App;
use Auth;
use Illuminate\Database\Eloquent\Model;

class DeliveryAddress extends Model
{
    public static function deliveryAddress(){
$user_id=Auth::user()->id;
$deliveryAddress=DeliveryAddress::where('user_id',$user_id)->get()->toArray();

return $deliveryAddress;
    }
}

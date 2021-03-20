
<?php
use App\Cart;
use App\Product;
?>
@extends('layouts.front_layout.front_layout')
@section('content')

<div class="span9">
    <ul class="breadcrumb">
		<li><a href="{{url('/')}}">Home</a> <span class="divider">/</span></li>
		<li class="active">thanks</li>
    </ul>
	<h3> thanks  </h3>	
	<hr class="soft"/>
	
<div class="center">
    <h3>your order has been placed successfully</h3>
    <p>your order number is {{Session::get('order_id')}} and grand total is INR{{Session::get('grand_total')}}</p>
</div>
	
</div>
@endsection
<?php
Session::forget('grand_total');
Session::forget('order_id');
?>
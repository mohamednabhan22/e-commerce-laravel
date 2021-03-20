
@extends('layouts.front_layout.front_layout')
@section('content')
<div class="span9">
    <ul class="breadcrumb">
		<li><a href="{{url('/')}}">Home</a> <span class="divider">/</span></li>
		<li class="active"><a href="{{url('/orders')}}">orders</a></li>
    </ul>
	<h3> order #{{$orderDetails['id']}} Details</h3>	
	<hr class="soft"/>
	<div class="row">
	

        <div class="span7">
            <table class="table table-striped table-bordered">
<tr>
    <td colspan="2"><strong>order Details</strong> </td>
</tr>
<tr>
    <td>order date</td>
    <td>{{ date('d-m-y',strtotime($orderDetails['created_at'])) }}</td>
</tr>
<tr>
    <td>order status</td>
    <td>{{$orderDetails['order_status']}}</td>
</tr>
<tr>
    <td>order total</td>
    <td>{{$orderDetails['grand_total']}}</td>
</tr>
<tr>
    <td>shipping charges</td>
    <td>INR {{$orderDetails['shipping_charges']}}</td>
</tr>
<tr>
    <td>coupon code</td>
    <td>{{$orderDetails['coupon_code']}}</td>
</tr>
<tr>
    <td>coupon amount </td>
    <td>{{$orderDetails['coupon_amount']}}</td>
</tr>
<tr>
    <td>payment method </td>
    <td>{{$orderDetails['payment_method']}}</td>
</tr>
            </table>
        </div>
    </div>
	<div class="row">
		<div class="span8">
            <table class="table table-striped table-bordered">
<tr>
    <th>product code</th>
    <th>product name</th>
    <th>product size</th>
    <th>product color</th>
    <th>product Qty</th>
    <th> </th>
</tr>
@foreach ($orderDetails['orders_products'] as $product)
    <tr>
        
        <td>{{$product['product_code']}}</td>
        <td>{{$product['product_name']}}</td>
        <td>{{$product['product_size']}}</td>
        <td>{{$product['product_color']}}</td>
        <td>{{$product['product_qty']}}</td>

    </tr>
@endforeach
            </table>
		
		</div>
   
	
	</div>
</div>
 @endsection
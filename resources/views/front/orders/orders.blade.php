
@extends('layouts.front_layout.front_layout')
@section('content')
<div class="span9">
    <ul class="breadcrumb">
		<li><a href="{{url('/')}}">Home</a> <span class="divider">/</span></li>
		<li class="active">orders</li>
    </ul>
	<h3> orders</h3>	
	<hr class="soft"/>

	
	<div class="row">
		<div class="span8">
            <table class="table table-striped table-bordered">
<tr>
    <th>order id</th>
    <th>order products</th>
    <th>payment method</th>
    <th>grand total</th>
    <th>created on</th>
    <th> </th>
</tr>
@foreach ($orders as $order)
    <tr>
        <td><a href="{{url('orders/'.$order['id'])}}">{{$order['id']}}</a> </td>
        <td>
            @foreach ($order['orders_products'] as $pro)
                {{$pro['product_code']}}
            @endforeach
        </td>
        <td>{{$order['payment_method']}}</td>
        <td>{{$order['grand_total']}}</td>
        <td>{{ date('d-m-y',strtotime($order['created_at'])) }}</td>
        <td><a href="{{url('orders/'.$order['id'])}}">View details</a> </td>

    </tr>
@endforeach
            </table>
		
		</div>
		</div>
	
	
</div>
 @endsection
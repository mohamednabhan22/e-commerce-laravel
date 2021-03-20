
@extends('layouts.front_layout.front_layout')
@section('content')
<div class="span9">
    <ul class="breadcrumb">
		<li><a href="index.html">Home</a> <span class="divider">/</span></li>
		<li class="active">delivery addresses</li>
    </ul>
	<h3>{{$title}}</h3>	
	<hr class="soft"/>
	@if ($errors->any())
	<div class="alert alert-danger" role="alert">
	   <ul>
		   @foreach ($errors->all() as $error)
			 <li>{{$error}}</li>  
		   @endforeach
	   </ul>
	  </div>
	@endif
	@if (Session::has('success_message'))
	<div class="alert alert-success " role="alert">
		{{Session::get('success_message')}}
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	@endif	
	@if (Session::has('error_message'))
	<div class="alert alert-danger " role="alert">
		{{Session::get('error_message')}}
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	@endif	
	<div class="row">
		<div class="span4">

			<div class="well">
			Enter your delivery address details <br/><br/><br/>
			<form id="deliveryAddress" @if (empty($address['id']))
            action="{{url('/add-edit-delivery-address/')}}"
            @else
            action="{{url('/add-edit-delivery-address/'.$address['id'])}}"
            @endif  method="post">
                @csrf
                <div class="control-group">
                    <label class="control-label" for="name">name </label>
                    <div class="controls">
                      <input class="span3"  type="text" id="name" name="name"@isset($address['name'])
					  value="{{$address['name']}}"
					  @else value="{{ old('name') }}"
					  @endisset  placeholder="enter name">
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="address">address </label>
                    <div class="controls">
                      <input class="span3"  type="text" id="address" name="address"@isset($address['address'])
					  value="{{$address['address']}}"
					  @else value="{{ old('address') }}"
					  @endisset  placeholder="enter address">
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="city">city </label>
                    <div class="controls">
                      <input class="span3"  type="text" id="city" name="city"@isset($address['city'])
					  value="{{$address['city']}}"
					  @else value="{{ old('city') }}"
					  @endisset placeholder="enter city">
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="state">state </label>
                    <div class="controls">
                      <input class="span3"  type="text" id="state" name="state" @isset($address['state'])
					  value="{{$address['state']}}"
					  @else value="{{ old('state') }}"
					  @endisset  placeholder="enter state">
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="country">country </label>
                    <div class="controls">
                      <input class="span3"  type="text" id="country" @isset($address['country'])
					  value="{{$address['country']}}"
					  @else value="{{ old('country') }}"
					  @endisset   name="country" placeholder="enter country">
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="pinCode">pinCode </label>
                    <div class="controls">
                      <input class="span3"  type="text" id="pinCode" @isset($address['pinCode'])
					  value="{{$address['pinCode']}}"
					  @else value="{{ old('pinCode') }}"
					  @endisset  name="pinCode" placeholder="enter pinCode">
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="mobile"> mobile</label>
                    <div class="controls">
                      <input class="span3"  type="text" id="mobile"  name="mobile" @isset($address['mobile'])
					  value="{{$address['mobile']}}"
					  @else value="{{ old('mobile') }}"
					  @endisset  placeholder="enter mobile">
                    </div>
                  </div>
			
			

            
			  <div class="controls">
			  <button type="submit" class="btn block">submit</button>
              <a style="float: right"  class="btn block" href="{{url('checkout')}}">back</a>

			  </div>
			</form>
		</div>
		</div>
		<div class="span1"> &nbsp;</div>
		<div class="span4">
			<div class="well">
			<h5>update password </h5>
			<form action="{{url('/update-password')}}" method="post" id="passwordForm">
				@csrf
				
				
	
				  <div class="control-group">
					<label class="control-label" for="password">current password </label>
					<div class="controls">
					  <input class="span3"  type="text" id="password" name="password" placeholder="enter password">
					</div>
				  </div>
                  <div class="control-group">
					<label class="control-label" for="password">new password </label>
					<div class="controls">
					  <input class="span3"  type="text" id="password" name="password" placeholder="enter password">
					</div>
				  </div>
                  <div class="control-group">
					<label class="control-label" for="password">confirm password </label>
					<div class="controls">
					  <input class="span3"  type="text" id="password" name="password" placeholder="enter password">
					</div>
				  </div>
			  <div class="control-group">
				<div class="controls">
				  <button type="submit" class="btn">update </button> 
				</div>
			  </div>
			</form>
		</div>
		</div>
	</div>	
	
</div>
 @endsection
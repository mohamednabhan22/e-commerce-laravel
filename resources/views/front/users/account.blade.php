
@extends('layouts.front_layout.front_layout')
@section('content')
<div class="span9">
    <ul class="breadcrumb">
		<li><a href="index.html">Home</a> <span class="divider">/</span></li>
		<li class="active">Login</li>
    </ul>
	<h3>my Account</h3>	
	<hr class="soft"/>
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
			<h5>contact details</h5><br/>
			Enter your contact details <br/><br/><br/>
			<form id="accountForm" action="{{url('/account')}}" method="post">
                @csrf
                <div class="control-group">
                    <label class="control-label" for="name">name </label>
                    <div class="controls">
                      <input class="span3"  type="text" id="name" name="name"value={{$userDetails['name']}} placeholder="enter name">
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="address">address </label>
                    <div class="controls">
                      <input class="span3"  type="text" id="address" name="address"value={{$userDetails['address']}} placeholder="enter address">
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="city">city </label>
                    <div class="controls">
                      <input class="span3"  type="text" id="city" name="city" value={{$userDetails['city']}} placeholder="enter city">
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="state">state </label>
                    <div class="controls">
                      <input class="span3"  type="text" id="state" name="state" value={{$userDetails['state']}} placeholder="enter state">
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="country">country </label>
                    <div class="controls">
                      <input class="span3"  type="text" id="country" value={{$userDetails['country']}}  name="country" placeholder="enter country">
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="pinCode">pinCode </label>
                    <div class="controls">
                      <input class="span3"  type="text" id="pinCode" value={{$userDetails['pinCode']}}  name="pinCode" placeholder="enter pinCode">
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="mobile"> mobile</label>
                    <div class="controls">
                      <input class="span3"  type="text" id="mobile" value={{$userDetails['mobile']}}  name="mobile" placeholder="enter mobile">
                    </div>
                  </div>
			
			

            
			  <div class="controls">
			  <button type="submit" class="btn block">update</button>
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
					<label class="control-label" for="current_pwd">current password </label>
					<div class="controls">
					  <input class="span3"  type="text" id="current_pwd" name="current_pwd" placeholder="enter password">
					</div>
				  </div>
                  <div class="control-group">
					<label class="control-label" for="new_pwd">new password </label>
					<div class="controls">
					  <input class="span3"  type="text" id="new_pwd" name="new_pwd" placeholder="enter new password">
					</div>
				  </div>
                  <div class="control-group">
					<label class="control-label" for="confirm_pwd">confirm password </label>
					<div class="controls">
					  <input class="span3"  type="text" id="confirm_pwd" name="confirm_pwd" placeholder="confirm password">
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
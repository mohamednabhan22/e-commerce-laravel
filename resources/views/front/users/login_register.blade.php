
@extends('layouts.front_layout.front_layout')
@section('content')
<div class="span9">
    <ul class="breadcrumb">
		<li><a href="index.html">Home</a> <span class="divider">/</span></li>
		<li class="active">Login</li>
    </ul>
	<h3> Login/Register</h3>	
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
			<h5>CREATE YOUR ACCOUNT</h5><br/>
			Enter your details to create an account.<br/><br/><br/>
			<form action="{{url('/register')}}" method="post">
                @csrf
                <div class="control-group">
                    <label class="control-label" for="name">name </label>
                    <div class="controls">
                      <input class="span3"  type="text" id="name" name="name" placeholder="enter name">
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="mobile"> mobile</label>
                    <div class="controls">
                      <input class="span3"  type="text" id="mobile" name="mobile" placeholder="enter mobile">
                    </div>
                  </div>
			  <div class="control-group">
				<label class="control-label" for="email">E-mail </label>
				<div class="controls">
				  <input class="span3"  type="email" id="email"name="email" placeholder="enter Email">
				</div>
			  </div>
			  <div class="control-group">
				<label class="control-label" for="address"> address</label>
				<div class="controls">
				  <input class="span3"  type="text" id="address"name="address" placeholder="enter address">
				</div>
			  </div>

              <div class="control-group">
				<label class="control-label" for="password">password </label>
				<div class="controls">
				  <input class="span3"  type="text" id="password" name="password" placeholder="enter password">
				</div>
			  </div>
			  <div class="controls">
			  <button type="submit" class="btn block">Create Your Account</button>
			  </div>
			</form>
		</div>
		</div>
		<div class="span1"> &nbsp;</div>
		<div class="span4">
			<div class="well">
			<h5>ALREADY REGISTERED ?</h5>
			<form action="{{url('/login')}}" method="post" id="loginForm">
				@csrf
				<div class="control-group">
					<label class="control-label" for="email">E-mail </label>
					<div class="controls">
					  <input class="span3"  type="email" id="email"name="email" placeholder="enter Email">
					</div>
				  </div>
				
	
				  <div class="control-group">
					<label class="control-label" for="password">password </label>
					<div class="controls">
					  <input class="span3"  type="text" id="password" name="password" placeholder="enter password">
					</div>
				  </div>
			  <div class="control-group">
				<div class="controls">
				  <button type="submit" class="btn">Sign in</button> <a href="forgetpass.html">Forget password?</a>
				</div>
			  </div>
			</form>
		</div>
		</div>
	</div>	
	
</div>
 @endsection
@extends('layouts.admin_layout.admin_layout')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Cataloges </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">coupons</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        @if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
   <ul>
       @foreach ($errors->all() as $error)
         <li>{{$error}}</li>  
       @endforeach
   </ul>
  </div>
@endif
@if (Session::has('success_message'))
<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
    {{Session::get('success_message')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
@endif
        <!-- SELECT2 EXAMPLE -->
        <form  name="couponForm" id="couponForm"
        @if (empty($coupon['id']))
        action="{{url('admin/add-edit-coupons')}}"
        @else
        action="{{url('admin/add-edit-coupons/'.$coupon['id'])}}"
        @endif
        method="post" enctype="multipart/form-data">
          @csrf
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">{{$title}} </h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              
              <!-- /.col -->
                     

                 

              <div class="col-md-6">
              
                <!-- /.form-group -->
  

                @if (empty($coupon['coupon_code']))
                <div class="form-group">

                    <label for="link">coupon option  </label>
                  <span> <input type="radio" name="coupon_option" id="automaticCoupon" value="automatic" >Automatic&nbsp;</span>&nbsp;&nbsp; 
                  <span> <input type="radio" name="coupon_option" id="manualCoupon" value="manual" >manual&nbsp;</span> &nbsp;
                  </div>
                    
                 
                <!-- /.form-group -->
                <div class="form-group" style="display: none;" id="couponField">

                  
                    <label for="coupon_code">coupon code  </label>
                    <input type="text" name="coupon_code" class="form-control" id="coupon_code" placeholder="Enter coupon code" >
                  </div> 
                @else
                <input type="hidden" name="coupon_option" value="{{$coupon['coupon_option']}}">
                <input type="hidden" name="coupon_code" value="{{$coupon['coupon_code']}}">
                <div class="form-group"  >

                  
                    <label for="coupon_code">coupon code : &nbsp;&nbsp; </label>

                    <span>{{$coupon['coupon_code']}}</span>
                  </div> 
                @endif
              

                  <div class="form-group">

                  
                    <label for="link">coupon type  </label>
                  <span> <input type="radio" name="coupon_type"  value="multiple times"
                    @if (isset($coupon['coupon_type'])&& $coupon['coupon_type']=="multiple times"))
                        checked
                        @elseif(!isset($coupon['coupon_type']))
                        checked
                        
                    @endif
                    >multiple times&nbsp;</span>&nbsp;&nbsp; 
                  <span> <input type="radio" name="coupon_type"  value="single times" 
                    @if (isset($coupon['coupon_type'])&& $coupon['coupon_type']=="single times"))
                    checked  
                    
                    @endif
                    >single times&nbsp;</span> &nbsp;
                  </div>
                  <div class="form-group">

                  
                    <label for="link">amount type  </label>
                  <span> <input type="radio" name="amount_type"  value="percentage"
                    @if (isset($coupon['amount_type'])&& $coupon['amount_type']=="percentage"))
                    checked  
                    
                    @endif
                    >percentage&nbsp; (in  % )</span>&nbsp;&nbsp; 
                  <span> <input type="radio" name="amount_type"  value="fixed" 
                    @if (isset($coupon['amount_type'])&& $coupon['amount_type']=="fixed"))
                    checked  
                    
                    @endif
                    >fixed&nbsp;(in  INR or USD)</span> &nbsp;
                  </div>


                  <div class="form-group"  >

                  
                    <label for="link">amount  </label>
                    <input type="text" name="amount" class="form-control" id="amount" placeholder="Enter amount"  @if (isset($coupon['amount']))
                    value={{$coupon['amount']}}  
                    
                    @endif >
                  </div>
              </div>
          
              <div class="col-12 col-sm-6">
             
            
            
             
                <div class="form-group" >

                  
                    <label for="categories">select categories </label>

                    <select  name="categories[]"  class="form-control select2" multiple>
                        <option value="">Select</option>
                        @foreach ($sections as $section)
                            <optgroup label="{{$section->name}}"></optgroup>
                            @foreach ($section['categories'] as $category)
                        <option value="{{$category['id']}}"
                      @if (in_array($category['id'],$selCats))
                          selected
                      @endif
                        >&nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;{{$category['category_name']}}</option>
                          
                        @foreach ($category['subcategories'] as $subcategory)
                        <option value="{{$subcategory['id']}}"
                        @if (in_array($subcategory['id'],$selCats))
                          selected
                      @endif
                        >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;{{$subcategory['category_name']}}</option>
  
                        @endforeach
                        @endforeach
                        @endforeach
                   
                        
                       
                      </select>
                  </div>
                  <div class="form-group" >

                  
                    <label for="users">select users </label>

                    <select  name="users[]"  class="form-control select2" multiple>
                        <option value="">Select</option>
                        @foreach ($users as $user)
                          <option value="{{$user['email']}}"  @if (in_array($user['email'],$selUsers))
                          selected
                      @endif>{{$user['email']}}</option>
                        @endforeach
                   
                        
                       
                      </select>
                  </div>

                  <div class="form-group" >

                  
                    <label for="users">expiry date </label>

                    <input type="text" name="expiry_date" class="form-control" id="expiry_date" placeholder="Enter expiry date"  @if (isset($coupon['expiry_date']))
                    value={{$coupon['expiry_date']}}  
                    
                    @endif >

                  </div>
            

                
                 </div>

             

             
                
             
           
            <!-- /.row -->
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
           <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </div>
      </form>
 
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

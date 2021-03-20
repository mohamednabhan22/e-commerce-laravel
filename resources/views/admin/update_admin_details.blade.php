@extends('layouts.admin_layout.admin_layout')
@section('content')
    <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <div class="content-header">
     <div class="container-fluid">
       <div class="row mb-2">
         <div class="col-sm-6">
           <h1 class="m-0 text-dark">Settings</h1>
         </div><!-- /.col -->
         <div class="col-sm-6">
           <ol class="breadcrumb float-sm-right">
             <li class="breadcrumb-item"><a href="#">Home</a></li>
             <li class="breadcrumb-item active">update Admin details</li>
           </ol>
         </div><!-- /.col -->
       </div><!-- /.row -->
     </div><!-- /.container-fluid -->
   </div>
   <!-- /.content-header -->
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">update Admin details</h3>
            </div>
            <!-- /.card-header -->

            @if (Session::has('error_message'))
<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
    {{Session::get('error_message')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
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
@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
   <ul>
       @foreach ($errors->all() as $error)
         <li>{{$error}}</li>  
       @endforeach
   </ul>
  </div>
@endif
            <!-- form start -->
            <form role="form" method="POST"  name="updateAdminDetails" enctype="multipart/form-data" id="updateAdminDetails">
              @csrf
                <div class="card-body"> 
 
                <div class="form-group">
                  <label for="exampleInputEmail1">Admin Email </label>
                  <input  class="form-control" readonly="" value="{{Auth::guard('admin')->user()->email}}"  >
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Admin Type </label>
                    <input  class="form-control" readonly="" value="{{Auth::guard('admin')->user()->type}}"  >
                  </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Name</label>
                  <input type="text" name="admin_name" id="admin_name" required="" value="{{Auth::guard('admin')->user()->name}}"  class="form-control"  placeholder="Enter Admin Name">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Mobile</label>
                    <input type="text" name="admin_mobile" id="admin_mobile" required="" value="{{Auth::guard('admin')->user()->mobile}}" class="form-control"  placeholder="Enter Admin Mobile">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Image  </label>
                    <input type="file"name="admin_image" id="admin_image" class="form-control" accept="image/*" >
                    @if (!empty(Auth::guard('admin')->user()->image))
                <a href="{{url('images/admin_images/admin_photos/'.Auth::guard('admin')->user()->image)}} "
                   target="_blank">View image</a>  
                <input type="hidden" name="current-admin-image" 
                value="{{Auth::guard('admin')->user()->image}}" >                      
                    @endif
                  </div>
              
                
              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
          <!-- /.card -->

          <!-- Form Element sizes -->
        
          <!-- /.card -->
          <!-- Horizontal Form -->
          
          <!-- /.card -->

        </div>
        <!--/.col (left) -->
        <!-- right column -->
        
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->

 </div>
 <!-- /.content-wrapper -->
@endsection

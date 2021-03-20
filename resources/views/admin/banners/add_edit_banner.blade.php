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
              <li class="breadcrumb-item active">banners</li>
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
        <form  name="bannerForm" id="bannerForm"
        @if (empty($bannerData['id']))
        action="{{url('admin/add-edit-banner')}}"
        @else
        action="{{url('admin/add-edit-banner/'.$bannerData['id'])}}"
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
  
                      <div class="form-group">

                  
                  
                        <label for="exampleInputFile">Banner  Image</label>
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" name="image" id="image">
                            <label class="custom-file-label" for="image">Choose file</label>
                          </div>
                          <div class="input-group-append">
                            <span class="input-group-text" id="">Upload</span>
                          </div>
                        </div>
                        @if (!empty($bannerData['image']))
                        <div>
                          <img style="width: 80px;margin-top:5px" src="{{asset('images/banner_Images/'.$bannerData['image'])}}" alt="">&nbsp;
                        </div>
                    @endif
                     
                      </div>
                    
                 
                <!-- /.form-group -->
                <div class="form-group">

                  
                    <label for="link">banner link  </label>
                    <input type="text" name="link" class="form-control" id="link" placeholder="Enter banner link"
                    @if (!empty($bannerData['link']))
                        value="{{$bannerData['link']}}"
                    @else
                    value="{{old('link')}}"
                    @endif
                    >
                  </div>
              </div>
          
              <div class="col-12 col-sm-6">
                <div class="form-group">

                  
                    <label for="title">banner title  </label>
                    <input type="text" name="title" class="form-control" id="title" placeholder="Enter banner title"
                    @if (!empty( $bannerData['title']))
                        value="{{$bannerData['title']}}"
                    @else
                    value="{{old('title')}}"
                    @endif
                    >
                  </div>      
        
        
              
            
            
             
            
                <div class="form-group"   @if (!empty($bannerData['image']))style="margin-top:3.4rem" @endif>

                  
                    <label for="alt">banner Alternate text  </label>
                    <input type="text" name="alt" class="form-control" id="alt" placeholder="Enter banner alt"
                    @if (!empty( $bannerData['alt']))
                    value="{{$bannerData['alt']}}"
                @else
                value="{{old('alt')}}"
                @endif
                    >
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

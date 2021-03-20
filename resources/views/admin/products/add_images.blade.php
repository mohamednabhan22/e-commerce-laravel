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
              <li class="breadcrumb-item active">Product images</li>
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

@if (Session::has('error_message'))
<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
    {{Session::get('error_message')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
@endif
        <!-- SELECT2 EXAMPLE -->
        <form  name="addImageForm" id="addImageForm" method="post" action="{{url('admin/add-images/
        '.$productData['id'])}}" enctype="multipart/form-data" >
          @csrf
        <div class="card card-default">
          <div class="card-header">
            <h1 class="card-title">{{$title}} </h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
           
                <div class="form-group">
                    <label for="product_name">product Name:&nbsp;&nbsp; <span class="text-muted"> {{$productData['product_name']}}</span> </label>
              
              </div>
              <!-- /.col -->
                     
                            <div class="form-group">
                                <label for="product-code">product Code: &nbsp;&nbsp; <span class="text-muted"> {{$productData['product_code']}}</span> </label>
                            
                              </div>
                              <div class="form-group">
                                <label for="product-color">product color:&nbsp;&nbsp; <span class="text-muted"> {{$productData['product_color']}}</span> </label>
                              
                              </div>
                            
                        </div>

          
                 <div class="col-md-6">
                    <div class="form-group">
                   
                
                   
                      <img style="width: 80px;margin-top:5px" src="{{asset('images/product_Images/small/'.$productData['main_Image'])}}" alt="">&nbsp;
                   
                    </div>
                  </div>
                  <div class="col-md-7">
                    <div class="form-group">
                   
                
                   
                        <div class="field_wrapper">
                            <div>
                                <input multiple     id="image" type="file" name="images[]" value=""/>
                            
                            </div>
                        </div>                   
                    </div>
                  </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

          </div>
          <!-- /.card-body -->
          <div class="card-footer">
           <button type="submit" class="btn btn-primary">add Images</button>
          </div>
        </div>
      </form>






  <form  name="editimageForm" id="editimageForm" method="post" action="{{url('admin/edit-images/
        '.$productData['id'])}}" >
          @csrf
      <div class="card">
        <div class="card-header">
          <h1 class="card-title">Added Product images</h1>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>ID </th>
                <th>Images </th>

               
              
             
                <th>Actions  </th>

              </tr>
              </thead>
              <tbody>
                @foreach ($productData['images'] as $image)
                <input style="display: none"   type="text" name="attrId[]" value="{{$image['id']}}" />

                <tr>
                  <td>{{$image['id']}}</td>
                  <td>
                    <img style="width: 80px;margin-top:5px" src="{{asset('images/product_Images/small/'.$image['image'])}}" alt="">&nbsp;

                     </td>
                   
                    <td>
                        @if ($image['status']==1)
                        <a class="updateImageStatus" id="image-{{$image['id']}}" image_id="{{$image['id']}}" href="javascript:void(0)">active</a> 
                         @else
                         <a class="updateImageStatus" id="image-{{$image['id']}}" image_id="{{$image['id']}}" href="javascript:void(0)">Inactive</a> 
                         
                     @endif  
                      &nbsp;
                     
                            
                                  <a  title="delete image" class="confirmDelete" name="image " href="{{url('admin/delete-image/'.$image['id'])}}"><i class="fas fa-trash"></i></a>
                                  
                              </td>
                    
               
             
                </tr>
                @endforeach
            
              </tbody>
              </tfoot>
            </table>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <button type="submit" class="btn btn-primary">update images</button>
         </div>
      </div>
  </form>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

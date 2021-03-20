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
              <li class="breadcrumb-item active">Product attributes</li>
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
        <form  name="addAttributeForm" id="addAttributeForm" method="post" action="{{url('admin/add-attributes/
        '.$productData['id'])}}" >
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

                              <div class="form-group">
                                <label for="product-color">product price:&nbsp;&nbsp; <span class="text-muted"> {{$productData['product_price']}}</span> </label>
                              
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
                                <input  style="width: 120px"   id="size" type="text" name="size[]" value="" placeholder="size"/>
                                <input  style="width: 120px"  id="sku" type="text" name="sku[]" value="" placeholder="sku"/>
                                <input  style="width: 120px"  id="price" type="number" name="price[]" value="" placeholder="price"/>
                                <input  style="width: 120px"  id="stock" type="number" name="stock[]" value="" placeholder="stock"/>

                                <a href="javascript:void(0);" class="add_button" title="Add field">Add</a>
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
           <button type="submit" class="btn btn-primary">add Atributes</button>
          </div>
        </div>
      </form>






  <form  name="editAttributeForm" id="editAttributeForm" method="post" action="{{url('admin/edit-attributes/
        '.$productData['id'])}}" >
          @csrf
      <div class="card">
        <div class="card-header">
          <h1 class="card-title">Added Product attributes</h1>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>ID </th>
                <th>Size </th>
                <th>Sku </th>
               
                <th>Price  </th>
                <th>stock  </th>
             
                <th>Actions  </th>

              </tr>
              </thead>
              <tbody>
                @foreach ($productData['attributes'] as $attribute)
                <input style="display: none"   type="text" name="attrId[]" value="{{$attribute['id']}}" />

                <tr>
                  <td>{{$attribute['id']}}</td>
                  <td>{{$attribute['size']}}</td>
                      <td>{{$attribute['sku']}}</td>

                          <td>
                            <input  style="width: 120px"  type="number" name="price[]" value="{{$attribute['price']}}" />

                          </td>
                              <td>
                                <input  style="width: 120px"  type="number" name="stock[]" value="{{$attribute['stock']}}" />

                                <td>
                                  @if ($attribute['status']==1)
                                     <a class="updateAttributeStatus" id="attribute-{{$attribute['id']}}" attribute_id="{{$attribute['id']}}" href="javascript:void(0)">active</a> 
                                      @else
                                      <a class="updateAttributeStatus" id="attribute-{{$attribute['id']}}" attribute_id="{{$attribute['id']}}" href="javascript:void(0)">Inactive</a> 
                                      
                                  @endif  
                                   &nbsp;
                                  <a  title="delete attribute" class="confirmDelete" name="attribute " href="{{url('admin/delete-attribute/'.$attribute['id'])}}"><i class="fas fa-trash"></i></a>
                                  
                              </td>
                    
                </td>
             
                </tr>
                @endforeach
            
              </tbody>
              </tfoot>
            </table>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <button type="submit" class="btn btn-primary">update Attributes</button>
         </div>
      </div>
  </form>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

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
              <li class="breadcrumb-item active">Products</li>
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
        <form  name="productForm" id="productForm"
        @if (empty($productData['id']))
        action="{{url('admin/add-edit-product')}}"
        @else
        action="{{url('admin/add-edit-product/'.$productData['id'])}}"
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
              <div class="col-md-6">
                <div class="form-group">
                    <label>Select Category</label>
                    <select  name="category_id"  id="category_id"class="form-control select2" style="width: 100%;">
                      <option value="">Select</option>
                      @foreach ($sections as $section)
                          <optgroup label="{{$section->name}}"></optgroup>
                          @foreach ($section['categories'] as $category)
                      <option value="{{$category['id']}}"
                      @if (!empty(@old('category_id'))&&$category['id']== @old('category_id'))
                          selected
                          @elseif(!empty($productData['category_id'])&& $productData['category_id'] ==$category['id'] ) 
                      selected
                          @endif
                      >&nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;{{$category['category_name']}}</option>
                        
                      @foreach ($category['subcategories'] as $subcategory)
                      <option value="{{$subcategory['id']}}"
                      @if (!empty(@old('category_id'))&&$subcategory['id']== @old('category_id'))
                      selected
                      @elseif(!empty($productData['category_id'])&& $productData['category_id'] ==$subcategory['id'] ) 
                      selected
                  @endif
                      >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;{{$subcategory['category_name']}}</option>

                      @endforeach
                      @endforeach
                      @endforeach
                 
                      
                     
                    </select>
                  </div> 

                  <div class="form-group">
                    <label>Select brand</label>
                    <select  name="brand_id"  id="brand_id"class="form-control select2" style="width: 100%;">
                      <option value="">Select</option>
                      @foreach ($brands as $brand)
                      <option value="{{$brand['id']}}"
                      @if (!empty($productData['brand_id'])&&$productData['brand_id']==$brand['id'])
                      selected
                  @endif
                      >{{$brand['name']}}</option>
                      @endforeach
                    
                    </select>
                  </div>
                <div class="form-group">
                    <label for="product_name">product Name </label>
                    <input type="text" name="product_name" class="form-control" id="product_name" placeholder="Enter product Name"
                    @if (!empty( $productData['product_name']))
                        value="{{$productData['product_name']}}"
                    @else
                    value="{{old('product_name')}}"
                    @endif
                    >
                  </div>
            
              
             
              </div>
              <!-- /.col -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="product-code">product Code </label>
                                <input type="text" name="product-code" class="form-control" id="product-code" placeholder="Enter product code"
                                @if (!empty($productData['product_code']))
                                    value="{{$productData['product_code']}}"
                                @else
                                value="{{old('product-code')}}"
                                @endif
                                >
                              </div>
                              <div class="form-group">
                                <label for="product-color">product color </label>
                                <input type="text" name="product-color" class="form-control" id="product-color" placeholder="Enter product color"
                                @if (!empty($productData['product_color']))
                                    value="{{$productData['product_color']}}"
                                @else
                                value="{{old('product-color')}}"
                                @endif
                                >
                              </div>
                            
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="product-price">product price </label>
                                <input type="text" name="product-price" class="form-control" id="product-price" placeholder="Enter product price"
                                @if (!empty( $productData['product_price']))
                                    value="{{$productData['product_price']}}"
                                @else
                                value="{{old('product-price')}}"
                                @endif
                                >
                              </div>
                              <div class="form-group">
                                <label for="product-discount">product discount (%) </label>
                                <input type="text" name="product-discount" class="form-control" id="product-discount" placeholder="Enter product discount"
                                @if (!empty( $productData['product_discount']))
                                    value="{{$productData['product_discount']}}"
                                @else
                                value="{{old('product-discount')}}"
                                @endif
                                >
                              </div>
                            
                        </div>

              <div class="col-md-6">
              
                <!-- /.form-group -->
                <div class="form-group">

                    <div class="form-group">
                        <label for="product-weight">product weight  </label>
                        <input type="text" name="product-weight" class="form-control" id="product-weight" placeholder="Enter product weight"
                        @if (!empty( $productData['product_weight']))
                            value="{{$productData['product_weight']}}"
                        @else
                        value="{{old('product-weight')}}"
                        @endif
                        >
                      </div>
                    <label for="exampleInputFile">product Main  Image</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="main_image" id="main_image">
                        <label class="custom-file-label" for="main_image">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text" id="">Upload</span>
                      </div>
                    </div>
                    @if (!empty($productData['main_Image']))
                    <div>
                      <img style="width: 80px;margin-top:5px" src="{{asset('images/product_Images/small/'.$productData['main_Image'])}}" alt="">&nbsp;
                      <a href="{{url('admin/delete-product-image/'.$productData['id'])}}">Delete Image</a>
                    </div>
                @endif
                 
                  </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
              <div class="col-12 col-sm-6">
              
                <div class="input-group">
                    <label for="exampleInputFile">product Video</label>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" name="product_video" id="product_video">
                    <label class="custom-file-label" for="product_video">Choose file</label>
                  </div>
                  <div class="input-group-append">
                    <span class="input-group-text" id="">Upload</span>
                  </div>
              
                </div>
                @if (!empty($productData['product_video']))
                <div>
                  <a href="{{url('videos/product_videos/'.$productData['product_video'])}} "download>Download</a>
                  <a href="{{url('admin/delete-video-image/'.$productData['id'])}}">Delete Video</a>

                </div>
            @endif
        
                <!-- /.form-group -->
                  
                <div class="form-group">
                    <label for="description">product Description </label>
                    <textarea id="description" name="description" class="form-control"  name="" id="" cols="3" rows="3" placeholder="Enter description"
                 
                    >   @if (!empty( $productData['description']))
                   {{$productData['description']}}
                @else
                {{old('description')}}
                @endif</textarea>
                  </div>
                <!-- /.form-group -->
            
              </div>
              <!-- /.col -->
              <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="wash_care">wash care </label>
                    <textarea id="wash_care" name="wash_care" class="form-control"  name="" id="" cols="3" rows="3" placeholder="Enter wash_care"
                 
                    >   @if (!empty( $productData['wash_care']))
                   {{$productData['wash_care']}}
                @else
                {{old('wash_care')}}
                @endif</textarea>
                  </div>

                  <div class="form-group">
                    <label>Select fabric</label>
                    <select  name="fabric"  id="fabric_id"class="form-control select2" style="width: 100%;">
                      <option value="">Select</option>
                      @foreach ($fabricArray as $fabric)
                      <option value="{{$fabric}} "
                      @if (!empty($productData['fabric'])&&$productData['fabric']==$fabric)
                          selected
                      @endif
                      
                      >{{$fabric}}</option>
                      @endforeach
                    
                    </select>
                  </div>
                 </div>

                 <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <label>Select sleeve</label>
                    <select  name="sleeve"  id="sleeve_id"class="form-control select2" style="width: 100%;">
                      <option value="">Select</option>
                      @foreach ($sleeveArray as $sleeve)
                      <option value="{{$sleeve}}"
                      @if (!empty($productData['sleeve'])&&$productData['sleeve']==$sleeve)
                      selected
                  @endif
                      >{{$sleeve}}</option>
                      @endforeach
                    
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Select pattern</label>
                    <select  name="pattern"  id="pattern_id"class="form-control select2" style="width: 100%;">
                      <option value="">Select</option>
                      @foreach ($patternArray as $pattern)
                      <option value="{{$pattern}}"
                      @if (!empty($productData['pattern'])&&$productData['pattern']==$pattern)
                      selected
                  @endif
                      >{{$pattern}}</option>
                      @endforeach
                    
                    </select>
                  </div>
                 </div>
                 <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <label>Select fit</label>
                    <select  name="fit"  id="fit_id"class="form-control select2" style="width: 100%;">
                      <option value="">Select</option>
                      @foreach ($fitArray as $fit)
                      <option value="{{$fit}}"
                      @if (!empty($productData['fit'])&&$productData['fit']==$fit)
                      selected
                  @endif
                      >{{$fit}}</option>
                      @endforeach
                    
                    </select>
                  </div>
               
                  <div class="form-group">
                    <label>Select occasion</label>
                    <select  name="occasion"  id="occasion_id"class="form-control select2" style="width: 100%;">
                      <option value="">Select</option>
                      @foreach ($occasionArray as $occasion)
                      <option value="{{$occasion}}"
                      @if (!empty($productData['occasion'])&&$productData['occasion']==$occasion)
                      selected
                  @endif
                      >{{$occasion}}</option>
                      @endforeach
                    
                    </select>
                  </div>
                
                </div>
                <div class="col-12 col-sm-6">
               
                  <div class="form-group">
                    <label for="meta_title">Meta Title </label>
                    <textarea class="form-control"  name="meta_title" id="meta_title" cols="3" rows="3" placeholder="Enter meta title"
                   
                    > @if (!empty( $productData['meta_title']))
                   {{$productData['meta_title']}}
                @else
               {{old('meta_title')}}
                @endif</textarea>
                  </div>
                <!-- /.form-group -->
              </div>

              <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="meta_description">Meta Description  </label>
                    <textarea class="form-control"  name="meta_description" id="meta_description" cols="3" rows="3" placeholder="Enter meta description"
                 
                    >   @if (!empty( $productData['meta_description']))
                  {{$productData['meta_description']}}
                @else
              {{old('meta_description')}}
                @endif</textarea>
                  </div>
                
                <!-- /.form-group -->
              </div>
              <div class="col-12 col-sm-6">
               
                  <div class="form-group">
                    <label for="meta_keywords">Meta Keywords </label>
                    <textarea class="form-control"  name="meta_keywords" id="meta_keywords" cols="3" rows="3" placeholder="Enter meta keywords"
                
                    >    @if (!empty( $productData['meta_keywords']))
                   {{$productData['meta_keywords']}}
                @else
               {{old('meta_keywords')}}
                @endif</textarea>
                  </div>

                  <div class="form-group">
                    <label for="meta_keywords">featured item </label>
                 <input type="checkbox" name="is_featured" id="is_featured" value="yes"
                 @if (!empty($productData['is_featured'])&&$productData['is_featured']=="yes")
                 checked
             @endif
                 >
                  </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
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

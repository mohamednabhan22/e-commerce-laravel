
@extends('layouts.front_layout.front_layout')
@section('content')

<div class="span9">
    <ul class="breadcrumb">
        <li><a href="{{url('/')}}">Home</a> <span class="divider">/</span></li>
        <li class="active"><?php echo $categoryDetails['breadcrumbs']?></li>
    </ul>
    <h3>{{$categoryDetails['categoryDetails']['category_name']}}<small class="pull-right"> {{count($categoryProducts)}} &nbsp; products are available </small></h3>
    <hr class="soft"/>
    <p>
        {{$categoryDetails['categoryDetails']['description']}}
    </p>
    <hr class="soft"/>
    <form id="sortProducts" name="sortProducts" class="form-horizontal span6">
        @csrf
        <input type="hidden" name="url" id="url" value="{{$url}}">
        <div class="control-group">
            <label class="control-label alignL">Sort By </label>
            <select id="sort" name="sort">
                <option value=""> Select</option>
                <option value="product_latest" @if(isset($_GET['sort'])&&$_GET['sort']=="product_latest")selected @endif>product latest</option>
                <option value="product_name_a_z" @if(isset($_GET['sort'])&&$_GET['sort']=="product_name_a_z")selected @endif>Product name A - Z</option>
                <option value="product_name_z_a" @if(isset($_GET['sort'])&&$_GET['sort']=="product_name_z_a")selected @endif>Priduct name Z - A</option>
                <option value="price_lowest" @if(isset($_GET['sort'])&&$_GET['sort']=="price_lowest")selected @endif> lowest price first </option>
                <option value="price_highest" @if(isset($_GET['sort'])&&$_GET['sort']=="price_highest")selected @endif> highest price first </option>            </select>
        </div>
    </form>
    
   
    <br class="clr"/>
    <div class="tab-content filter-products">
       @include('front.products.ajax_products_listing')
    </div>
    <div class="pagination">
        @if (isset($_GET['sort'])&&!empty($_GET['sort']))
        {{$categoryProducts->appends(['sort'=>$_GET['sort']])->links()}}
       
        @else
        {{$categoryProducts->links()}}
    
        @endif
      
    </div>
    <br class="clr"/>
</div>
@endsection

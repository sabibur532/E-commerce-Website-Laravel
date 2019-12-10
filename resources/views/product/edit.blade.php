@extends('layouts.app')
@section('content')
  <div class="container">
    <div class="row">
      <div class="col-6  offset-3">
        <div class="card">
          <div class="card-header">
            <h1 class="text-center">Edit Product Add </h1>
          </div>
          <div class="card-body">
            @if (session('status'))
              <div class="alert alert-success">
                {{ session('status') }}
              </div>
            @endif
            <form action="{{ url('product/edit/insert') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="form-group">
                <label><strong>Product Name</strong></label>
                <input type="hidden" name="product_id" value="{{ $product_info->id }}" >
                <input type="text" value="{{ $product_info->product_name }}" name="product_name" class="form-control" placeholder="Enter Your Product name">
              </div>
              <div class="form-group">
                <label><strong>Product Description</strong></label>
                <textarea name="product_description" name="product_description" class="form-control" placeholder="Enter Your Product Description">{{ $product_info->product_description }}</textarea>
              </div>
              <div class="form-group">
                <label><strong>Product Value</strong></label>
                <input type="number" value="{{ $product_info->product_value }}" class="form-control" name="product_value" placeholder="Enter Your Product Value">
              </div>
              <div class="form-group">
                <label><strong>Product Quantity</strong></label>
                <input type="number" value="{{ $product_info->product_quantity }}"class="form-control" name="product_quantity" placeholder="Enter Your Product Quantity">
              </div>
              <div class="form-group">
                <label><strong>Product Alart Quantity</strong></label>
                <input type="number" value="{{ $product_info->alart_quantity }}" class="form-control" name="alart_quantity" placeholder="Enter Your Product Alart Quantity">
              </div>
              <div class="form-group">
                <label><strong>Product Image</strong></label>
                <input type="file" class="form-control" name="product_image">
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-info">Edit Product</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

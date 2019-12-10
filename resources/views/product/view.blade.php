@extends('layouts.app')
@section('content')
  <div class="mx-3">
    <div class="row">
      <div class="col-8">
        <div class="card">
          <div class="card-header">
            <h1 class="text-center">Product List</h1>
          </div>
          <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">Si</th>
                    <th scope="col">Name</th>
                    <th scope="col">Category</th>
                    <th scope="col">Description</th>
                    <th scope="col">Price</th>
                    <th scope="col">Image</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>

                  @forelse ($products as $product)

                  <tr>
                    <td>{{ $loop->index+1}}</td>
                    <td>{{$product->product_name}}</td>
                    {{-- <td>{{  App\Category::find($product->category_id)->category_name }}</td> --}}
                    <td>{{ $product->category->category_name }}</td>
                    <td>{{$product->product_description}}</td>
                    <td>{{$product->product_value}}</td>
                    <td>
                      <img src="{{ asset('uploads/product_images') }}\{{$product->product_image}}" alt="Not Found" width="100" height="100">
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm" role="group" >
                        <a href="{{ url('/product/edit') }}/{{ $product->id }}"type="button" class="btn btn-info">Edit</a>
                        <a href="{{ url('/product/delete') }}/{{ $product->id }}" type="button" class="btn btn-danger text-white">Delete</a>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr class="text-danger text-center">
                    <td colspan="5">No Data available</td>
                  </tr>
                @endforelse
                </tbody>
              </table>
              {{ $products->links() }}
          </div>
        </div>
      </div>
      <div class="col-4">
        <div class="card">
          <div class="card-header">
            <h1 class="text-center">Product Add </h1>
          </div>
          <div class="card-body">
            @if (session('status'))
              <div class="alert alert-success">
                {{ session('status') }}
              </div>
            @endif
            <form action="{{ url('product/insert') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="form-group">
                <label><strong>Category Name</strong></label>
                <select class="form-control" name="category_id">
                  <option >--Select--</option>
                  @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>

                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label><strong>Product Name</strong></label>
                <input type="text" name="product_name" class="form-control" placeholder="Enter Your Product name" value="{{ old('product_name') }}">
              </div>
              <div class="form-group">
                <label><strong>Product Description</strong></label>
                <textarea name="product_description" name="product_description" class="form-control" placeholder="Enter Your Product Description">{{ old('product_description') }}</textarea>
              </div>
              <div class="form-group">
                <label><strong>Product Value</strong></label>
                <input type="number" class="form-control" name="product_value" placeholder="Enter Your Product Value" value="{{ old('product_value') }}">
              </div>
              <div class="form-group">
                <label><strong>Product Quantity</strong></label>
                <input type="number" class="form-control" name="product_quantity" placeholder="Enter Your Product Quantity" value="{{ old('product_quantity') }}">
              </div>
              <div class="form-group">
                <label><strong>Product Alart Quantity</strong></label>
                <input type="number" class="form-control" name="alart_quantity" placeholder="Enter Your Product Alart Quantity" value="{{ old('alart_quantity') }}">
              </div>

              <div class="form-group">
                <label><strong>Product Image</strong></label>
                <input type="file" class="form-control" name="product_image">
              </div>

              @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif
              <div class="text-center">
                <button type="submit" class="btn btn-primary">Add Product</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

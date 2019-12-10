@extends('layouts.app')
@section('content')
  <div class="container">
    <div class="row">
      <div class="col-6">
        <div class="card">
          <div class="card-header">
            <h1 class="text-center">Category List</h1>
          </div>
          <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">SI</th>
                    <th scope="col">Name</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created_at</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>

                  @forelse ($categories as $category )

                  <tr>
                    <td>{{ $loop->index+1 }}</td>
                    <td>{{$category->category_name}}</td>
                    <td>
                      @if ($category->category_status==1)
                        {{ "Active" }}
                      @else
                        {{ "Deactive" }}
                      @endif

                    </td>
                    <td>{{$category->created_at->diffForHumans( )}}</td>
                    <td>
                        <div class="btn-group btn-group-sm" role="group" >
                        <a href="{{ url('/category/status') }}/{{ $category->id }}"type="button" class="
                          @if ($category->category_status==1)
                          {{ "btn btn-warning" }}
                          @else
                          {{ "btn btn-success" }}
                          @endif">
                          @if ($category->category_status==1)
                            {{ "Deactive" }}
                          @else
                            {{ "Active" }}
                          @endif
                        </a>
                        <a href="{{ url('/category/delete') }}/{{ $category->id }}" type="button" class="btn btn-danger text-white">Delete</a>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr class="text-danger text-center">
                    <td colspan="4">No Data available</td>
                  </tr>
                @endforelse
                </tbody>
              </table>

                {{ $categories->links() }}

          </div>
        </div>
      </div>
      <div class="col-6">
        <div class="card">
          <div class="card-header">
            <h1 class="text-center">Category Add </h1>
          </div>
          <div class="card-body">
            @if (session('status'))
              <div class="alert alert-success">
                {{ session('status') }}
              </div>
            @endif
            <form action="{{ url('category/insert') }}" method="POST">
              @csrf
              <div class="form-group">
                <label><strong>Category Name</strong></label>
                <input type="text" name="category_name" class="form-control" placeholder="Enter Your Category name" value="{{ old('category_name') }}">
              </div>
              <div class="form-group">
                <select class="custom-select mr-sm-2" name="category_status">
                  <option selected>Choose Status</option>
                  <option value="1">Active</option>
                  <option value="2">Deactive</option>
                </select>
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
                <button type="submit" class="btn btn-primary">Add Category</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

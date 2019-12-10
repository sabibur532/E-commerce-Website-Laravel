@extends('layouts.app')
@section('content')
  <div class="container">
    <div class="row">
      <div class="col-6">
        <div class="card">
          <div class="card-header">
            <h1 class="text-center">Banner List</h1>
          </div>
          <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">SI</th>
                    <th scope="col">Image</th>
                    <th scope="col">Title</th>
                    <th scope="col">Subtitle</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>

                  @forelse ($banners as $banner )

                  <tr>
                    <td>{{ $loop->index+1 }}</td>

                    <td>{{$banner->banner_image}}</td>
                    <td>{{$banner->title}}</td>
                    <td>{{$banner->subtitle}}</td>

                    <td>
                        <a href="{{ url('/banner/delete') }}/{{ $banner->id }}" type="button" class="btn btn-danger text-white">Delete</a>
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

                {{ $banners->links() }}

          </div>
        </div>
      </div>
      <div class="col-6">
        <div class="card">
          <div class="card-header">
            <h1 class="text-center">Banner Add </h1>
          </div>
          <div class="card-body">
            @if (session('status'))
              <div class="alert alert-success">
                {{ session('status') }}
              </div>
            @endif
            <form action="{{ url('banner/insert') }}" method="POST" enctype="multipart/form-data">
              @csrf

              <div class="form-group">
                <label><strong>Banner Image</strong></label>
                <input type="file" name="banner_image" class="form-control"  >
              </div>
              <div class="form-group">
                <label><strong>Banner Title</strong></label>
                <input type="text" name="title" class="form-control"  placeholder="Enter Your banner title" value="{{ old('product_value') }}">
              </div>
              <div class="form-group">
                <label><strong>Banner Subtitle</strong></label>
                <input type="text" name="subtitle" class="form-control" placeholder="Enter Your banner subtitle" value="{{ old('product_value') }}" >
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

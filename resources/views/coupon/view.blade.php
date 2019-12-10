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
                    <th scope="col">Coupon Name</th>
                    <th scope="col">Discount Amount</th>
                    <th scope="col">Valid Till </th>
                    <th scope="col">Delete</th>
                  </tr>
                </thead>
                <tbody>

                  @forelse ($coupons as $coupon )

                  <tr>
                    <td>{{ $loop->index+1 }}</td>
                    <td>{{$coupon->coupon_name}}</td>
                    <td>{{$coupon->discount}}</td>
                    <td>{{$coupon->valid_till}}</td>
                    <td>
                    <a href="{{ url('/coupon/delete') }}/{{ $coupon->id }}" type="button" class="btn btn-danger text-white">Delete</a>
                    </td>
                  </tr>
                @empty
                  <tr class="text-danger text-center">
                    <td colspan="4">No Data available</td>
                  </tr>
                @endforelse
                </tbody>
              </table>



          </div>
        </div>
      </div>
      <div class="col-6">
        <div class="card">
          <div class="card-header">
            <h1 class="text-center">Coupon Add </h1>
          </div>
          <div class="card-body">
            @if (session('status'))
              <div class="alert alert-success">
                {{ session('status') }}
              </div>
            @endif

            <form action="{{ url('coupon/insert') }}" method="POST">
              @csrf
              <div class="form-group">
                <label><strong>Coupon Name</strong></label>
                <input type="text" name="coupon_name" class="form-control" placeholder="Enter Your Coupon name" value="{{ old('coupon_name') }}">
              </div>
              <div class="form-group">
                <label><strong>Discount Amount</strong></label>
                <input type="number" name="discount" class="form-control" placeholder="Enter Your Discount Amount" value="{{ old('coupon_name') }}">
              </div>
              <div class="form-group">
                <label><strong>Valid Till</strong></label>
                <input type="date" name="valid_till" class="form-control">
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
                <button type="submit" class="btn btn-primary">Add Coupon</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

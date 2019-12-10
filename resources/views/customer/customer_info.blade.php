@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="col-6 m-auto">
      <div class="card">
        <div class="card-header">
          <h3 class="text-center">Update Your Information</h3>
        </div>
        <div class="card-body">
          @if (App\Profile::where('user_id',Auth::id())->exists())
            @php
              $info = App\Profile::where('user_id',Auth::id())->first();
            @endphp
            <form action="{{ url('customer/profile/update') }}" method="POST" >
              @csrf

              <div class="form-group">
                <label for="">Enter Your first name</label>
                <input type="text" name="first_name" class="form-control" placeholder="Enter Your first name" value="{{ $info->first_name }}">
              </div>

              <div class="form-group">
                <label for="">Enter Your last name</label>
                <input type="text" name="last_name" class="form-control" placeholder="Enter Your last name" value="{{ $info->last_name }}">
              </div>
              <div class="form-group">
                <label for="">Enter Your Phone No</label>
                <input type="text" name="phone" class="form-control" placeholder="Enter Your  Phone No" value="{{ $info->phone }}">
              </div>
              <div class="form-group">
                <label for="">Enter Your Address</label>
                <input type="text" name="address" class="form-control" placeholder="Enter Your  Address" value="{{ $info->address }}">
              </div>
              <div class="form-group">
                <label for="">Enter Your Zip COde</label>
                <input type="text" name="zip" class="form-control" placeholder="Enter Your  Zip COde" value="{{  $info->zip  }}">
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-warning">Update Your Information</button>
              </div>
            </form>

            @else
              <form action="{{ url('customer/profile/insert') }}" method="POST" >
            @csrf
            @if (session('info'))
              <div class="alert alert-danger">
                {{ session('info') }}
              </div>

            @endif
            <div class="form-group">
              <label for="">Enter Your first name</label>
              <input type="text" name="first_name" class="form-control" placeholder="Enter Your first name" >
            </div>

            <div class="form-group">
              <label for="">Enter Your last name</label>
              <input type="text" name="last_name" class="form-control" placeholder="Enter Your last name" >
            </div>
            <div class="form-group">
              <label for="">Enter Your Phone No</label>
              <input type="text" name="phone" class="form-control" placeholder="Enter Your  Phone No" >
            </div>
            <div class="form-group">
              <label for="">Enter Your Address</label>
              <input type="text" name="address" class="form-control" placeholder="Enter Your  Address" >
            </div>
            <div class="form-group">
              <label for="">Enter Your Zip COde</label>
              <input type="text" name="zip" class="form-control" placeholder="Enter Your  Zip COde" >
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Add Your Information</button>
            </div>
          </form>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection

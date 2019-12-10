@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-8 m-auto">
        <div class="card">
          <div class="card-header">
            <h1 class="text-center">Order List</h1>
          </div>
          <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">SI</th>
                    <th scope="col">Shipping_id</th>
                    <th scope="col">Grand Total</th>
                    <th scope="col">Perches At</th>
                    <th scope="col">Action</th>

                  </tr>
                </thead>
                <tbody>
                  @php
                     $orders = App\Sale::where('user_id', Auth::id())->get();
                  @endphp
                  @forelse ($orders as $order )

                  <tr>
                  <td>{{ $loop->index+1 }}</td>
                  <td>{{ $order->shipping_id }}</td>
                  <td>{{ $order->grand_total }}</td>
                  <td>{{ $order->created_at->diffForHumans() }}</td>
                  <td>
                    <a href="{{ url('order/details/view') }}" class="btn btn-primary">View details</a>
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
    </div>
  </div>
@endsection

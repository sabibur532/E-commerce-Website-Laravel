@extends('layouts.master')

@section('main')

<!-- Page Info -->
	<div class="page-info-section page-info">
		<div class="container">
			<div class="site-breadcrumb">
				<a href="">Home</a> /
				<a href="">Cart</a> /
				<span>Checkout</span>
			</div>
			<img src="img/page-info-art.png" alt="" class="page-info-art">
		</div>
	</div>
	<!-- Page Info end -->


	<!-- Page -->
	<div class="page-area cart-page spad">
		<div class="container">
			<form class="checkout-form" action="{{ url('checkout/insert') }}" method="post">
				@csrf
				<div class="row">
					<div class="col-lg-6">
						<h4 class="checkout-title">Billing Address</h4>
						@auth
							<div class="row">
							<div class="col-md-6">
								<input type="text" placeholder="First Name *" name="first_name" value="{{ $info->first_name }}">
							</div>
							<div class="col-md-6">
								<input type="text" placeholder="Last Name *" name="last_name" value="{{ $info->last_name }}">
							</div>
							<div class="col-md-12">
                <input type="text" placeholder="Phone no *"  name="phone" value="{{ $info->phone }}">
                <input type="email" placeholder="Email Address *" value="{{ Auth::user()->email }}">
								<select id="country_id" name="country_id">
									<option>Country *</option>
									@php
										$countries = App\Country::all();
									@endphp
									@foreach ($countries as $country)
										<option value="{{ $country->id }}" >{{ $country->name }}</option>

									@endforeach
								</select>
                <select id='city_list' name="city_id">
                  <option>City/Town *</option>
                </select>
								<input type="text" placeholder="Address *" name="address" value="{{ $info->address }}">
								<input type="text" placeholder="Zipcode *" name="zip" value="{{ $info->zip }}">

							</div>
						</div>
						@else
							Please <a href="{{ url('login') }}">Login</a> Or <a href="{{ url('customer/register') }}">Register</a>

						@endauth
					</div>
					<div class="col-lg-6">
						<div class="order-card">
							<div class="order-details">
								<div class="od-warp">
									<h4 class="checkout-title">Your order</h4>
									<table class="order-table">

										<tfoot>
											<tr class="order-total">
												<th>Total</th>
												<th>${{ $grand_total }}</th>

												<input type="hidden" name="grand_total" value="{{ $grand_total }}">
											</tr>
										</tfoot>
									</table>
								</div>
								<div class="payment-method">
									<div class="pm-item">
										<input type="radio" id="two"name="payment_type" value="1" checked>
										<label for="two">Cash on delievery</label>
									</div>
									<div class="pm-item">
										<input type="radio" id="three" name="payment_type" value="2">
										<label for="three">Credit card</label>
									</div>

								</div>
							</div>
							<button type="submit" class="site-btn btn-full">Place Order</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<!-- Page -->
@endsection

@section('js_script')
	<script>
		$(document).ready(function(){
			$('#country_id').change(function(){
				var country_id = $(this).val();
				$.ajaxSetup({
					    headers: {
					        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					    }
					});
				$.ajax({
					    tyep:'POST',
							url: '/city/list',
							data: {country_id:country_id},
							success: function(data){
								$('#city_list').html(data);
							}
					});

			});
		});
	</script>

@endsection

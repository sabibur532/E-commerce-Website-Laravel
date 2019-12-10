@extends('layouts.master')

@section('main')
  <!-- Page Info -->
<div class="page-info-section page-info">
  <div class="container">
    <div class="site-breadcrumb">
      <a href="">Home</a> /
      <a href="">Sales</a> /
      <a href="">Bags</a> /
      <span>Cart</span>
    </div>
    <img src="{{ asset('fronend_assets/img/page-info-art.png')}}" alt="" class="page-info-art">
  </div>
</div>
<!-- Page Info end -->


<!-- Page -->
<div class="page-area cart-page spad">
  <div class="container">
    <form  action="{{ url('update/cart') }}" method="post">
      @csrf
    <div class="cart-table">
      <table>
        <thead>
          <tr>
            <th class="product-th">Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th class="total-th">Total</th>
            <th class="">Remove</th>
          </tr>
        </thead>
        <tbody>
          @php
            $subtotal = 0;
          @endphp
          @forelse ($cart_items as $cart_item)
            <tr>
            <td class="product-col">
              <img src="{{ asset('uploads/product_images')}}/{{ $cart_item->cartsproduct->product_image }}" alt="" width="150">
              <div class="pc-title">
                <h4>{{ $cart_item->cartsproduct->product_name }}</h4>
              </div>
            </td>
            <td class="price-col">${{ $cart_item->cartsproduct->product_value }}</td>
            <td class="quy-col">
              <div class="quy-input">
                <span>Qty</span>
                <input type="hidden" name="product_id[]" value="{{ $cart_item->product_id }}">
                <input type="number" name="update_quantity[]" value="{{ $cart_item->product_quantity }}">
              </div>
            </td>
            <td class="total-col">${{ $cart_item->cartsproduct->product_value*$cart_item->product_quantity }}</td>
            @php
              $subtotal = $subtotal + ($cart_item->cartsproduct->product_value*$cart_item->product_quantity);
            @endphp
            <td class="total-col"> <a href="{{ url('single/product/delete') }}/{{ $cart_item->id }}" class="fa fa-3x fa-trash"> </a> </td>
          </tr>

          @empty
            <tr class="text-center text-danger">
              <td colspan="5" class="py-3">No Product Is here!</td>
            </tr>
          @endforelse

        </tbody>
      </table>
    </div>
    <div class="row cart-buttons">
      <div class="col-lg-5 col-md-5">
        <a href="{{ url('/') }}" class="site-btn btn-continue">Continue shooping</a>
      </div>
      <div class="col-lg-7 col-md-7 text-lg-right text-left">
        <a href="{{ url('clr/cart') }}" class="site-btn btn-clear">Clear cart</a>
        <button type="submit" class="site-btn btn-line btn-update">Update Cart</button>
      </div>
    </div>
  </form>
  </div>
  <div class="card-warp">
    <div class="container">
      <div class="row">
        <div class="col-lg-4">
          <div class="shipping-info">
            <h4>Shipping method</h4>
            <p>Select the one you want</p>
            <div class="shipping-chooes">
              <div class="sc-item">
                <input type="radio" name="sc" id="one">
                <label for="one" id="lavel_one">Next day delivery<span>$4.99</span></label>
              </div>
              <div class="sc-item">
                <input type="radio" name="sc" id="two">
                <label for="two" id="lavel_two">Standard delivery<span>$1.99</span></label>
              </div>
              <div class="sc-item">
                <input type="radio" name="sc" id="three">
                <label for="three" id="lavel_three">Personal Pickup<span>Free</span></label>
              </div>
            </div>
            <h4>Cupon code</h4>
            <p>Enter your cupone code</p>
            <div class="cupon-input">
              <input type="text"  id="coupon_name" value="{{ $coupon_name }}">
              <button class="site-btn" id="apply_coupon_btn">Apply</button>
            </div>
            @if (session('status'))
              <div style="font-size:20px; margin:10px; background-color:#FF4500;
                            border-radius:5px; padding: 5px; color: White;  text-align:center;">
                {{ session('status') }}
              </div>
            @endif
          </div>
        </div>
        <div class="offset-lg-2 col-lg-6">
          <div class="cart-total-details">
            <h4>Cart total</h4>
            <p>Final Info</p>
            <ul class="cart-total-card">
              <li>Subtotal<span>${{ $subtotal }}</span></li>
              <li>Discount<span>{{ $coupon_discount }}%</span></li>
              <li>Shipping<span id='shipa'>Free</span></li>
              <li class="total">Total
                <span id="total">{{ ($subtotal/100)*(100-$coupon_discount) }}</span><span>$</span></br>
                <span style="display:none" id="take_total">{{ ($subtotal/100)*(100-$coupon_discount) }}</span>
              </li>
            </ul>
            <form class="" action="{{ url('checkout') }}" method="post">
              @csrf
              <input type="hidden" name="grand_total" id="grand_total" value="{{ ($subtotal/100)*(100-$coupon_discount) }}">
              <button class="site-btn btn-full" type='submit'>Proceed to checkout</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Page end -->


@endsection
@section('js_script')
 <script>
	$(document).ready(function(){
		$('#apply_coupon_btn').click(function(){
      var coupon_name = $('#coupon_name').val();
      window.location.href = "{{ url('cart') }}"+'/'+coupon_name;
    });


    $('#lavel_one').click(function() {
      var l1= parseFloat(4.99);
      $('#shipa').html(l1);
      var total = parseFloat($('#take_total').html());
       var grand_total = total + l1;
       $('#total').html(grand_total.toFixed(2));
       $('#grand_total').val(grand_total.toFixed(2));

    });
    $('#lavel_two').click(function() {
      var l2= parseFloat(1.99);
      $('#shipa').html(l2);
      var total = parseFloat($('#take_total').html());
       var grand_total = total + l2;
       $('#total').html(grand_total.toFixed(2));
       $('#grand_total').val(grand_total.toFixed(2));
    });
    $('#lavel_three').click(function() {
      var l3= parseFloat(0);
      $('#shipa').html(l3);
      var total = parseFloat($('#take_total').html());
       var grand_total = total + l3;
       $('#total').html(grand_total.toFixed(2));
       $('#grand_total').val(grand_total.toFixed(2));
    });
	});
 </script>
@endsection

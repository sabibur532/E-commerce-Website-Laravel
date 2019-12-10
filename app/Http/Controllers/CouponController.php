<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coupon;
use Carbon\Carbon;

class CouponController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
      $this->middleware('rolecheaker');
  }

  function couponView()
  {
    $coupons = Coupon::all();
    return view('coupon.view',compact('coupons'));
  }


  function couponInsert(Request $request)
  {
    $request->validate([
      'coupon_name'=>'unique:coupons,coupon_name',
      'discount'=>'numeric|max:50',
    ]);
    Coupon::insert([
      'coupon_name'=>$request->coupon_name,
      'discount'=>$request->discount,
      'valid_till'=>$request->valid_till,
    ]);
    return back()->with('status',"Coupon Insert Successfully!");
  }

  function couponDelete($coupon_id)
  {
    Coupon::find($coupon_id)->delete();
    return back();
  }

}

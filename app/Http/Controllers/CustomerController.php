<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profile;
use Carbon\Carbon;
use Auth;

class CustomerController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }
    function customerdashboard()
    {
      return view('customer.customer');
    }
    function customerprofile()
    {
      return view('customer.customer_info');
    }
    function customerprofileinsert(Request $request)
    {
      Profile::insert([
        'user_id'=>Auth::id(),
        'first_name'=>$request->first_name,
        'last_name'=>$request->last_name,
        'phone'=>$request->phone,
        'address'=>$request->address,
        'zip'=>$request->zip,
        'created_at'=>Carbon::now()
      ]);
      return back();
    }
    function customerprofileupdate(Request $request)
    {
      Profile::where('user_id', Auth::id())->update([
        'first_name'=>$request->first_name,
        'last_name'=>$request->last_name,
        'phone'=>$request->phone,
        'address'=>$request->address,
        'zip'=>$request->zip,
      ]);
      return back();
    }

    function orderdetails()
    {
      return view('customer.order');
    }
    function orderdetailsview()
    {
      return view('customer.orderview');
    }

}

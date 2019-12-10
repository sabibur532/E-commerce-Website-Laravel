<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Banner;
use App\Cart;
use App\Coupon;
use App\User;
use App\Profile;
use App\Country;
use App\City;
use App\Shipping;
use App\Sale;
use App\Billing;
use Carbon\Carbon;
use Auth;
use Session;

class FrontendController extends Controller
{
    function index() {
        $products = Product::all();
        $categories = Category::all();
        $banners = Banner::all();

        return view('index', compact('products','categories','banners'));
    }
    function contact() {
        return view('contact');
    }
    function productDetails($product_id) {
        $singleproduct = Product::find($product_id);
        $reletedproducts = Product::where('category_id',$singleproduct->category_id )->where('id','!=',$product_id)->get();
        return view('product_details', compact('singleproduct','reletedproducts'));
    }
    function categorywiseproduct($category_id)
    {
      $category = Category::find($category_id);
      $products = Product::where('category_id', $category_id)->get();
      return view('category',compact('products','category'));
    }


    function cart($coupon_name = "")
    {
      if ($coupon_name=="") {
        $cart_items = Cart::where('customer_ip', $_SERVER['REMOTE_ADDR'])->get();
        $coupon_discount = 0;
        return view('cart',compact('cart_items','coupon_discount','coupon_name'));
      }
      else {
        if (Coupon::where('coupon_name',$coupon_name)->exists()) {

          if (Carbon::now()->format('Y-m-d') <= Coupon::where('coupon_name',$coupon_name)->first()->valid_till) {
            $cart_items = Cart::where('customer_ip', $_SERVER['REMOTE_ADDR'])->get();
            $coupon_discount =Coupon::where('coupon_name',$coupon_name)->first()->discount;
            return view('cart',compact('cart_items','coupon_discount','coupon_name'));
          }
          else {
            return back()->with('status',"Coupon Expired");
            }
          }
          else {
              return back()->with('status',"Invalid Coupon Name");
            }

      }
    }


    function addcart($product_id)
    {
      $same_product = Cart::where('customer_ip', $_SERVER['REMOTE_ADDR'])->where('product_id',$product_id);
      if ($same_product->exists()) {
        $same_product->increment('product_quantity',1);
        return back();
      }
      else {
        Cart::insert([
          'customer_ip'=> $_SERVER['REMOTE_ADDR'],
          'product_id'=>$product_id,
          'created_at'=>Carbon::now(),
        ]);
        return back();
      }
    }

    function clrcart()
    {
      Cart::where('customer_ip', $_SERVER['REMOTE_ADDR'])->delete();
      return back();
    }
    function singleproductdelete($cart_id)
    {
      Cart::where('id', $cart_id)->delete();
      return back();
    }

    function updatecart(Request $request)
    {
      foreach ($request->product_id as $key => $value) {
         $value;
         $request->update_quantity[$key];
         if ($request->update_quantity[$key] >= 1) {
           if (Product::find($value)->product_quantity >= $request->update_quantity[$key]) {
             Cart::where('customer_ip', $_SERVER['REMOTE_ADDR'])->where('product_id',$value)
             ->update([
               	'product_quantity' => $request->update_quantity[$key],
             ]);
           }
         }

      }
      return back();
    }

    function customerregister()
    {
      return view('customer.customer_register');
    }
    function customerregisterinsert(Request $request)
    {
      User::insert([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>bcrypt($request->password),
        'role'=>2,
        'created_at'=>Carbon::now(),
      ]);
      return back();
    }

    function checkout(Request $request)
    {
      $grand_total = $request->grand_total;
      $info = Profile::where('user_id', Auth::id())->first();
      if (Profile::where('user_id', Auth::id())->exists() ) {
        return view('checkout',compact('info','grand_total'));
      }
      else {
        Session::flash('info','Plese Fill up the information');
        return redirect('customer/profile');
      }

    }

    function citylist(Request $request)
    {
      $sringToSend = "<option>-Select One-</option>";
      $citys = City::where('country_id', $request->country_id)->get();
      foreach ($citys as $city) {
        $sringToSend .= "<option value='".$city->id."'>".$city->name."</option>";
      }
      echo $sringToSend;
    }


    function checkoutinsert(Request $request)
    {
      $shipping_id = Shipping::insertGetId([
        'user_id'=> Auth::id(),
        'first_name'=> $request->first_name,
        'last_name'=> $request->last_name,
        'phone'=> $request->phone,
        'country_id'=> $request->country_id,
        'city_id'=> $request->city_id,
        'address'=> $request->address,
        'zip'=> $request->zip,
        'payment_type'=> $request->payment_type,
        'payment_status'=> $request->payment_type,
        'created_at'=> Carbon::now()
      ]);
      $sale_id = Sale::insertGetId([
        'user_id'=> Auth::id(),
        'shipping_id'=> $shipping_id,
        'grand_total'=> $request->grand_total,
      ]);
      $cart_items = Cart::where('customer_ip', $_SERVER['REMOTE_ADDR'])->get();
      foreach ($cart_items as $cart_item) {
        Billing::insert([
          'sale_id'=> $sale_id,
          'customer_ip'=> $cart_item->customer_ip,
          'product_id'=> $cart_item->product_id,
          'product_quantity'=> $cart_item->product_quantity,
          'created_at'=> Carbon::now(),
        ]);
        Product::where('id',$cart_item->product_id)->decrement('product_quantity', $cart_item->product_quantity);
        $cart_item->delete();
      }
      return redirect('/');
    }
}

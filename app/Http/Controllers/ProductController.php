<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use Image;

class ProductController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
      $this->middleware('rolecheaker');
  }


    function productView()
    {
      $products=Product::paginate(5);
      $categories=Category::all();
      return view('product.view', compact('products','categories'));
    }
    function productInsert( Request $request)
    {
      $request->validate([
          'product_name' => 'required',
          'product_description' => 'required',
          'product_value' => 'required',
          'product_quantity' => 'required',
          'alart_quantity' => 'required',
      ],
      [
          'product_name.required'=>'You must Enter your product name',
          'product_description.required'=>'You must Enter your product description',
          'product_value.required'=>'You must Enter your product value',
          'product_quantity.required'=>'You must Enter your product quantity',
          'alart_quantity.required'=>'You must Enter your alart quantity',
      ]);
      $lastinsertid = Product::insertGetId([
        'category_id'=>$request->category_id,
        'product_name'=>$request->product_name,
        'product_description'=>$request->product_description,
        'product_value'=>$request->product_value,
        'product_quantity'=>$request->product_quantity,
        'alart_quantity'=>$request->alart_quantity,
      ]);

      if ($request->hasFile('product_image')) {
        $mainimage = $request->product_image;
        $imagename = $lastinsertid.'.'.$mainimage->getClientOriginalExtension();
        Image::make($mainimage)->resize(400,450)->save(base_path('public/uploads/product_images/'.$imagename));
        Product::find($lastinsertid)->update([
          'product_image'=> $imagename,
        ]);
      }
      return back()->with('status',"Product Insert Successfully!");
    }

    function productDelete($product_id)
    {
      Product::find($product_id)->delete();
      return back();
    }
    function productEdit($product_id)
    {
      $product_info = Product::find($product_id);
      return view('product.edit', compact('product_info'));
    }
    function productEditInsert(Request $request)
    {

    Product::find($request->product_id)->update([
      'product_name'=>$request->product_name,
      'product_description'=>$request->product_description,
      'product_value'=>$request->product_value,
      'product_quantity'=>$request->product_quantity,
      'alart_quantity'=>$request->alart_quantity,
    ]);
    if ($request->hasFile('product_image')){
      $imagename = Product::find($request->product_id)->product_image;
      if ($imagename != 'default.jpg') {
        unlink(base_path('public/uploads/product_images/'.$imagename));
      }
      $mainimage = $request->product_image;
      $imagename = $request->product_id.'.'.$mainimage->getClientOriginalExtension();
      Image::make($mainimage)->resize(400,450)->save(base_path('public/uploads/product_images/'.$imagename));
      Product::find($request->product_id)->update([
        'product_image'=> $imagename,
          ]);
    }
    return back()->with('status',"Product Edit Successfully!");
    }
}

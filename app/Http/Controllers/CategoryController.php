<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Carbon\Carbon;

class CategoryController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
      $this->middleware('rolecheaker');
  }


  function categoryView()
  {
    $categories = Category::paginate(7);
    return view('category/view', compact('categories'));
  }
  function categoryInsert(Request $request)
  {
    $request->validate([
      'category_name' => 'required',
      'category_status' => 'required',

    ],
      [
        'category_name.required'=>'You must be Enter your category',
        'category_status.required'=>'You must be Enter your category status',
      ]);
      Category::insert([
        'category_name'=>$request->category_name,
        'category_status'=>$request->category_status,
        'created_at' => Carbon::now(),
      ]);
      return back()->with('status',"Category Insert Successfully!");

    }

    function categoryDelete($category_id)
    {
      Category::find($category_id)->delete();
      return back();
    }
    function categoryStatus($category_id)
    {
      $all = Category::find($category_id);
      if ($all->category_status==1) {

       $all->increment('category_status',1);
      }
      else {

        $all->decrement('category_status',1);
      }

      return back();
    }
}

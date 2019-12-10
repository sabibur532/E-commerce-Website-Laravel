<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Banner;
use Image;

class BannerController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
      $this->middleware('rolecheaker');
  }


    function bannerView()
    {
      $banners= Banner::paginate(10);
      return view('banner.view', compact('banners'));
    }

    function bannerInsert(Request $request)
    {
      $request->validate([
        'banner_image'=>'required',
        'title'=>'required',
        'subtitle'=>'required',
      ]);
      $lastid = Banner::insertGetId([
        'title'=>$request->title,
        'subtitle'=>$request->subtitle,
      ]);
      if ($request->hasFile('banner_image')) {
        $mainimage=$request->banner_image;
        $imagename=$lastid.'.'.$mainimage->getClientOriginalExtension();
        Image::make($mainimage)->resize(1040,850)->save(base_path('public/uploads/banners/'.$imagename));
        Banner::find($lastid)->update([
          'banner_image'=>$imagename,
        ]);
      }
      return back();
    }

    function bannderDelete($banner_id)
    {
      Banner::find($banner_id)->delete();
      return back();
    }
}

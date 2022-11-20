<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use File;
use Image;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Setting::where('id', 1)->get();
        $sliders = Slider::orderBy('name', 'asc')->get();
        return view('backend.pages.slider.manage', compact('sliders', 'settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $settings = Setting::where('id', 1)->get();
        return view('backend.pages.slider.create', compact('settings'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $slider = new Slider();
        $slider->name           = $request->name;
        $slider->short_desc     = $request->short_desc;
        $slider->status         = $request->status;

        if($request->image){
            $image = $request->file('image');
            $img = rand() . '.' . $image->getClientOriginalExtension();
            $location = public_path('backend/img/sliders/' . $img);
            $imageResize = Image::make($image);
            $imageResize->fit(2376, 807)->save($location);
            $slider->image = $img;
        }

        $notification = array(
            'alert-type'    => 'success',
            'message'       => 'New Slider Added!',
        );

        $slider->save();
        return redirect()->route('slider.manage')->with($notification);
    }   

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $settings = Setting::where('id', 1)->get();
        $slider = Slider::find($id);
        if(!is_null($slider)){
            return view('backend.pages.slider.edit', compact('slider', 'settings'));
        }else{
            //404
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $slider = Slider::find($id);
        $slider->name           = $request->name;
        $slider->short_desc     = $request->short_desc;
        $slider->status         = $request->status;

        if($request->image){
            if(File::exists('backend/img/sliders/' . $slider->image)){
                File::delete('backend/img/sliders/' . $slider->image);
            }
            $image = $request->file('image');
            $img = rand() . '.' . $image->getClientOriginalExtension();
            $location = public_path('backend/img/sliders/' . $img);
            $imageResize = Image::make($image);
            $imageResize->fit(2376, 807)->save($location);
            $slider->image = $img;
        }

        $notification = array(
            'alert-type'    => 'success',
            'message'       => 'Slider Updated Successfully!',
        );

        $slider->save();
        return redirect()->route('slider.manage')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slider = Slider::find($id);
        if(!is_null($slider)){
            if(File::exists('backend/img/sliders/' . $slider->image)){
                File::delete('backend/img/sliders/' . $slider->image);
            }
            $notification = array(
                'alert-type'    => 'error',
                'message'       => 'Slider Removed Permanently!',
            );
            $slider->delete();
            return redirect()->route('slider.manage')->with($notification);
        }else{
            //404
        }
    }
}

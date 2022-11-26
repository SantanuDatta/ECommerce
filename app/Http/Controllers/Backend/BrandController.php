<?php

namespace App\Http\Controllers\Backend;

use File;
use Image;
use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::orderBy('name', 'asc')->get();
        return view('backend.pages.brand.manage', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.pages.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $brand = $request->validate([
        //     'name' => 'required|unique:brands|min:5|max:20|alpha',
        //     'description' => 'nullable',
        //     'image' => 'nullable|image|size:1024|mimes:jpeg,png,jpg|dimensions:max_width=300,max_height=300',
        //     'status' => 'required',
        // ]);

        $brand = new Brand();
        $brand->name        = $request->name;
        $brand->slug        = Str::slug($request->name);
        $brand->description = $request->description;
        $brand->status      = $request->status;
        if($request->image){
            $image = $request->file('image');
            $img = rand() . '.' . $image->getClientOriginalExtension();
            $location = public_path('backend/img/brands/' . $img);
            $imageResize = Image::make($image);
            $imageResize->fit(300, 300)->save($location);
            $brand->image = $img;
        }

        $notification = array(
            'alert-type'    => 'success',
            'message'       => 'New Brand Added!',
        );

        $brand->save();
        return redirect()->route('brand.manage')->with($notification);
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
        $brand = Brand::find($id);
        if(!is_null($brand)){
            return view('backend.pages.brand.edit', compact('brand'));
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

        // $brand = $request->validate([
        //     'name' => 'required|min:5|max:20|alpha|unique:brands,'.$id,
        //     'description' => 'nullable',
        //     'image' => 'nullable|image|size:1024|mimes:jpeg,png,jpg|dimensions:max_width=300,max_height=300',
        // ]);

        $brand = Brand::find($id);
        $brand->name        = $request->name;
        $brand->slug        = Str::slug($request->name);
        $brand->description = $request->description;
        $brand->status      = $request->status;
        if($request->image){
            if(File::exists('backend/img/brands/' . $brand->image)){
                File::delete('backend/img/brands/' . $brand->image);
            }
            $image = $request->file('image');
            $img = rand() . '.' . $image->getClientOriginalExtension();
            $location = public_path('backend/img/brands/' . $img);
            $imageResize = Image::make($image);
            $imageResize->fit(300, 300)->save($location);
            $brand->image = $img;
        }

        $notification = array(
            'alert-type'    => 'success',
            'message'       => 'Brand Updated Successfully!',
        );

        $brand->save();
        return redirect()->route('brand.manage')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = Brand::find($id);
        if(!is_null($brand)){
            $brand->status = 2;
            $notification = array(
                'alert-type'    => 'warning',
                'message'       => 'Brand Removed Temporarily!',
            );
            $brand->save();
            return redirect()->route('brand.manage')->with($notification);
        }else{
            //404
        }
    }

    public function softDelete(){
        $brands = Brand::where('status', 2)->orderBy('name', 'asc')->get();
        return view('backend.pages.brand.softdelete', compact('brands'));
    }

    public function fullDelete($id)
    {
        $brand = Brand::find($id);
        if(!is_null($brand)){
            if(File::exists('backend/img/brands/' . $brand->image)){
                File::delete('backend/img/brands/' . $brand->image);
            }
            $notification = array(
                'alert-type'    => 'error',
                'message'       => 'Brand Removed Permanently!',
            );
            $brand->delete();
            return redirect()->route('brand.softdelete')->with($notification);
        }else{
            //404
        }
    } 
}

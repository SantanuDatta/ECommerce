<?php

namespace App\Http\Controllers\Backend;

use File;
use Image;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('name', 'asc')->where('is_parent', 0)->get();
        return view('backend.pages.category.manage', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parentCat = Category::orderBy('name', 'asc')->where('is_parent', 0)->get();
        return view('backend.pages.category.create', compact('parentCat'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // $category = $request->validate([
        //     'name' => 'required|unique:categories|min:5|max:25|alpha',
        //     'is_parent' => 'nullable',
        //     'image' => 'nullable|image|mimes:png,jpg,jpeg|size:1024|dimensions:max_width=300,mnn_height=300',
        //     'description' => 'nullable',
        //     'status' => 'required'
        // ]);

        $category = new Category();
        $category->name         = $request->name;
        $category->slug         = Str::slug($request->name);
        $category->is_parent    = $request->is_parent;
        $category->description  = $request->description;
        $category->status       = $request->status;
        $category->is_featured  = $request->is_featured;
        if($request->image){
            $image = $request->file('image');
            $img = rand() . '.' . $image->getClientOriginalExtension();
            $location = public_path('backend/img/categories/' . $img);
            $imageResize = Image::make($image);
            $imageResize->fit(300, 300)->save($location);
            $category->image = $img;
        }

        $notification = array(
            'alert-type'    => 'success',
            'message'       => 'New Category Added!',
        );

        $category->save();
        return redirect()->route('category.manage')->with($notification);
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
        $category = Category::find($id);
        if(!is_null($category)){
            $parentCat = Category::orderBy('name', 'asc')->where('is_parent', 0)->get();
            return view('backend.pages.category.edit', compact('category', 'parentCat'));
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
        // $category = $request->validate([
        //     'name' => 'required|min:5|max:25|alpha|unique:categories,'.$id,
        //     'is_parent' => 'nullable',
        //     'image' => 'nullable|image|mimes:png,jpg,jpeg|size:1024|dimensions:max_width=300,mnn_height=300',
        //     'description' => 'nullable',
        // ]);

        $category = Category::find($id);
        $category->name         = $request->name;
        $category->slug         = Str::slug($request->name);
        $category->is_parent    = $request->is_parent;
        $category->description  = $request->description;
        $category->status       = $request->status;
        $category->is_featured  = $request->is_featured;
        if($request->image){
            if(File::exists('backend/img/categories/' . $category->image)){
                File::delete('backend/img/categories/' . $category->image);
            }
            $image = $request->file('image');
            $img = rand() . '.' . $image->getClientOriginalExtension();
            $location = public_path('backend/img/categories/' . $img);
            $imageResize = Image::make($image);
            $imageResize->fit(300, 300)->save($location);
            $category->image = $img;
        }

        $notification = array(
            'alert-type'    => 'success',
            'message'       => 'Category Updated Successfully!',
        );

        $category->save();
        return redirect()->route('category.manage')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if(!is_null($category)){
            
            if($category->is_parent == 0){
                foreach(Category::where('is_parent', $category->id)->get() as $sCat){
                    $sCat->is_parent = 7;
                    $sCat->save();
                }
            }

            $notification = array(
                'alert-type'    => 'warning',
                'message'       => 'Category Removed Temporarily!',
            );

            $category->status = 2;
            $category->save();
            return redirect()->route('category.manage')->with($notification);
        }else{
            //404
        }
    }

    public function softDelete(){
        $categories = Category::where('status', 2)->orderBy('name', 'asc')->get();
        return view('backend.pages.category.softdelete', compact('categories'));
    }

    public function fullDelete($id)
    {
        $category = Category::find($id);
        if(!is_null($category)){
            if(File::exists('backend/img/categories/' . $category->image)){
                File::delete('backend/img/categories/' . $category->image);
            }

            $notification = array(
                'alert-type'    => 'error',
                'message'       => 'Category Removed Permanently!',
            );
            $category->delete();
            return redirect()->route('category.manage')->with($notification);
        }else{
            //404
        }
    } 
}

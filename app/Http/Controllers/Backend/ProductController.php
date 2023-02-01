<?php

namespace App\Http\Controllers\Backend;

use File;
use Image;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->get();
        return view('backend.pages.product.manage', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = Brand::orderBy('name', 'asc')->where('status', 0 && 'name', null)->get();
        $parentCat = Category::orderBy('name', 'asc')->where('is_parent', 0 && 'status', 0 && 'name', null)->get();
        return view('backend.pages.product.create', compact('brands', 'parentCat'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product();
        $product->name          = $request->name;
        $product->slug          = Str::slug($request->name);
        $product->short_desc    = $request->short_desc;
        $product->long_desc     = $request->long_desc;
        $product->quantity      = $request->quantity;
        $product->regular_price = $request->regular_price;
        $product->offer_price   = $request->offer_price;
        $product->is_featured   = $request->is_featured;
        $product->product_type  = $request->product_type;
        $product->brand_id      = $request->brand_id;
        $product->category_id   = $request->category_id;
        $product->mfg_date      = $request->mfg_date;
        $product->exp_date      = $request->exp_date;
        $product->sku_code      = $request->sku_code;
        $product->product_tags  = $request->product_tags;
        $product->additional_info = $request->additional_info;
        $product->status        = $request->status;
        
        $product->save();

        if(count(array($request->image)) > 0){
            foreach($request->image as $image){
                $img = rand() . '.' . $image->getClientOriginalExtension();
                $location = public_path('backend/img/products/' . $img);
                $imageResize = Image::make($image);
                $imageResize->fit(650, 650)->save($location);
                $image = new ProductImage();
                $image->product_id = $product->id;
                $image->image = $img;
                $image->save();
            }
        }

        $notification = array(
            'alert-type'    => 'success',
            'message'       => 'New Product Added!',
        );

        return redirect()->route('product.manage')->with($notification);
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
        $product = Product::find($id);
        if (!is_null($product)) {
            $brands = Brand::orderBy('name', 'asc')->where('status', 0)->get();
            $parentCat = Category::orderBy('name', 'asc')->where('is_parent', 0)->where('status', 0)->get();
            return view('backend.pages.product.edit', compact('product', 'brands', 'parentCat'));
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
        $product = Product::find($id);
        $product->name          = $request->name;
        $product->slug          = Str::slug($request->name);
        $product->short_desc    = $request->short_desc;
        $product->long_desc     = $request->long_desc;
        $product->quantity      = $request->quantity;
        $product->regular_price = $request->regular_price;
        $product->offer_price   = $request->offer_price;
        $product->is_featured   = $request->is_featured;
        $product->product_type  = $request->product_type;
        $product->brand_id      = $request->brand_id;
        $product->category_id   = $request->category_id;
        $product->mfg_date      = $request->mfg_date;
        $product->exp_date      = $request->exp_date;
        $product->sku_code      = $request->sku_code;
        $product->product_tags  = $request->product_tags;
        $product->additional_info = $request->additional_info;
        $product->status        = $request->status;

        $product->save();
        
        $notification = array(
            'alert-type'    => 'success',
            'message'       => 'Product Updated Successfully!',
        );
        return redirect()->route('product.manage')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if(!is_null($product)){
            $product->status = 2;
            $notification = array(
                'alert-type'    => 'warning',
                'message'       => 'Product Removed Temporarily!',
            );
            $product->save();
            return redirect()->route('product.manage')->with($notification);
        }else{
            //404
        }
    }

    public function softdelete()
    {
        $products = Product::orderBy('id', 'desc')->where('status', 2)->get();
        return view('backend.pages.product.softdelete', compact('products'));
    }

    public function fulldelete($id)
    {
        $product = Product::find($id);
        if(!is_null($product)){
            $notification = array(
                'alert-type'    => 'error',
                'message'       => 'Product Removed Permanently!',
            );
            $product->carts()->delete();
            $product->orders()->delete();
            $product->delete();
            return redirect()->route('product.softdelete')->with($notification);
        }else{
            //404
        }
    }
}

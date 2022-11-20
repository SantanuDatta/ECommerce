<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Flash;
use App\Models\ProductImage;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use File;
use Image;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    $flashes = Flash::where('status', '1')->get();
    $categories = Category::orderBy('name', 'asc')->where('is_parent', 0)->get();
    return view('frontend.pages.cart', compact('flashes', 'categories'));
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::check()){
            $cart = Cart::where('user_id', Auth::user()->id)->where('product_id', $request->product_id)->where('order_id', Null)->first();
        }else{
            $cart = Cart::where('ip_address', request()->ip())->where('product_id', $request->product_id)->where('order_id', Null)->first();
        }
        if(!is_null($cart)){
            $cart->increment('product_quantity');
            return back();
        }else{
            $cart = new Cart();
            if(Auth::check()){
                $cart->user_id          = Auth::user()->id;
            }
            $cart->ip_address           = request()->ip();
            $cart->product_id           = $request->product_id;
            $cart->product_quantity     = $request->quantity;
            $cart->unit_price           = $request->unit_price;
            $cart->save();
            return back();
        }
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
        //
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
        $cart = Cart::find($id);
        if(!is_null($cart)){
            $cart->product_quantity = $request->quantity;
            $cart->unit_price       = $request->unit_price;
            $cart->save();
            return back();
        }else{
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cart = Cart::find($id);
        if(!is_null($cart)){
            $cart->delete();
        }else{
            return redirect()->route('cart.manage');
        }
        return redirect()->route('cart.manage');
    }
}

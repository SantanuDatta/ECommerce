<?php

namespace App\Http\Controllers\Frontend;

use File;
use Image;
use App\Models\Cart;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    return view('frontend.pages.cart');
    
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

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Auth;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::user()->id)->where('product_id', $request->product_id)->where('order_id', null)->first();
        } else {
            $cart = Cart::where('ip_address', request()->ip())->where('product_id', $request->product_id)->where('order_id', null)->first();
        }
        if (!is_null($cart)) {
            $cart->increment('product_quantity');
            return back();
        } else {
            $cart = new Cart();
            if (Auth::check()) {
                $cart->user_id = Auth::user()->id;
            }
            $cart->ip_address       = request()->ip();
            $cart->product_id       = $request->product_id;
            $cart->product_quantity = $request->quantity;
            $cart->save();
            return back();
        }
    }

    public function update(Request $request, $id)
    {
        $cart = Cart::find($id);
        if (!is_null($cart)) {
            $cart->product_quantity = $request->quantity;
            $cart->save();
            return back();
        } else {
            return back();
        }
    }

    public function destroy($id)
    {
        $cart = Cart::find($id);
        if (!is_null($cart)) {
            $cart->delete();
        } else {
            return redirect()->route('cart.manage');
        }
        return redirect()->route('cart.manage');
    }
}

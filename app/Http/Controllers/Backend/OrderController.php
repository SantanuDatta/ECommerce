<?php

namespace App\Http\Controllers\Backend;

use File;
use Image;
use App\Models\Cart;
use App\Models\User;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Country;
use App\Models\Product;
use App\Models\Category;
use App\Models\District;
use App\Models\Division;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::orderBy('id', 'desc')->get();
        return view('backend.pages.order.manage', compact('orders'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id);
        if(!is_null($id)){
            $carts = Cart::orderBy('id', 'asc')->where('order_id', $order->id)->get();
            return view('backend.pages.order.details', compact('order', 'carts'));
        }
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
        $order = Order::find($id);
        $order->status = $request->status;
        if ($order->status != 3) {
            foreach ($order->carts as $cart) {
                // Get the product model
                $product = Product::find($cart->product_id);
                
                // Get the quantity from the current cart item
                $quantity = $cart->product_quantity;
                
                if ($order->status == 4 || $order->status == 5) {
                    // Increment the product stock for failed or cancelled status
                    $product->quantity += $quantity;
                } else {
                    // Decrement the product stock for pending or processing status
                    $product->quantity -= $quantity;
                }
                $product->save();
            }
        }
        $notification = array(
            'alert-type'    => 'success',
            'message'       => 'Order Status Updated Successfully!',
        );

        $order->save();
        return redirect()->back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        if(!is_null($order)){
            $notification = array(
                'alert-type'    => 'error',
                'message'       => 'Order Removed Successfully!',
            );
            $order->carts()->delete();
            $order->delete();
            return redirect()->route('order.manage')->with($notification);
        }else{
            //404
        }
    }
}

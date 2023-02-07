<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maize\Markable\Models\Favorite;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->check()) {
            $prDetails = Product::whereHasFavorite(auth()->user())->orderBy('name', 'asc')->get();
        } else {
            $prDetails = [];
        }
        //$prDetails = Product::whereHasFavorite(auth()->user())->orderBy('name', 'asc')->get(); 
        // dd($prDetails);
        return view('frontend.pages.wishlist',compact('prDetails'));
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
        $wishCount = 0;
        if(Auth::check()){
            $user = Auth::user();
            $product = Product::find($id);
            if (Favorite::has($product, $user)) {
                Favorite::toggle($product, $user);
                $wishCount = DB::table('markable_favorites')->where('user_id', Auth::user()->id)->count();
                return response()->json(['status' => 'error', 'wish_count' => $wishCount], 200);
            }else{
                Favorite::add($product, $user);
                $wishCount = DB::table('markable_favorites')->where('user_id', Auth::user()->id)->count();
                return response()->json(['status' => 'success', 'wish_count' => $wishCount], 200);
            }
            
        }else{
            return response()->json(['status' => 'warning'], 200);
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
        //
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
        $user = Auth::user();
        Favorite::remove($product, $user);
        $notification = array(
            'alert-type'    => 'error',
            'message'       => 'Product Removed From Wishlist Successfully!',
        );
        return back()->with($notification);
    }
}

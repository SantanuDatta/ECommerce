<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\Country;
use App\Models\Division;
use App\Models\District;
use App\Models\Slider;
use App\Models\Flash;
use App\Models\Order;
use App\Models\Setting;
use App\Models\User;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use File;
use Image;

class FrontPagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        $sliders = Slider::where('status', '1')->get();
        $flashes = Flash::where('status', '1')->get();
        $categories = Category::orderBy('name', 'asc')->where('is_parent', 0)->where('status', 0)->get();
        $settings = Setting::where('id', 1)->get();
        return view('frontend.pages.homepage', compact('sliders', 'flashes', 'categories' , 'settings'));
    }
    public function notFound()
    {
        $flashes = Flash::where('status', '1')->get();
        $categories = Category::orderBy('name', 'asc')->where('is_parent', 0)->where('status', 0)->get();
        $settings = Setting::where('id', 1)->get();
        return view('frontend.pages.404', compact('flashes', 'categories', 'settings'));
    }
    
    /**
     * Display a listing of the resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function invoice($id)
    {
        $flashes = Flash::where('status', '1')->get();
        $categories = Category::orderBy('name', 'asc')->where('is_parent', 0)->where('status', 0)->get();
        $settings = Setting::where('id', 1)->get();
        $inv = Order::find($id)->where('id', $id)->first();
        return view('frontend.pages.userDashboard.invoice', compact('flashes', 'inv', 'categories', 'settings'));
    }


    public function userDashboard()
    {
        $countries  = Country::orderBy('priority', 'asc')->where('status', '1')->get();
        $divisions  = Division::orderBy('priority', 'asc')->where('status', '1')->get();
        $districts  = District::orderBy('name', 'asc')->where('status', '1')->get();
        $flashes    = Flash::where('status', '1')->get();
        $categories = Category::orderBy('name', 'asc')->where('is_parent', 0)->where('status', 0)->get();
        $settings = Setting::where('id', 1)->get();
        $cart       = Cart::select('order_id')->get();
        $orderHistory = Order::where('user_id', Auth::user()->id)->orderBy('inv_id', 'asc')->get();
        return view('frontend.pages.userDashboard.user-account', compact('countries', 'divisions', 'districts', 'flashes', 'orderHistory', 'cart', 'categories', 'settings'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userUpdate(Request $request, $id)
    {
        $user = User::find($id);
        $user->name             = $request->name;
        $user->lastName         = $request->lastName;
        $user->phone            = $request->phone;
        $user->addressLineOne   = $request->addressLineOne;
        $user->addressLineTwo   = $request->addressLineTwo;
        $user->country_id       = $request->country_id;
        $user->division_id      = $request->division_id;
        $user->district_id      = $request->district_id;
        $user->save();
        return redirect()->back();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //Search
    public function searchProduct(Request $request)
    {
        $search = $request->searchContent;
        $flashes = Flash::where('status', '1')->get();
        $categories = Category::orderBy('name', 'asc')->where('is_parent', 0)->where('status', 0)->get();
        $settings = Setting::where('id', 1)->get();
        $products = Product::orWhere('name', 'like', '%' . $search . '%')->
        orWhere('slug', 'like', '%' . $search . '%')->
        orWhere('product_tags', 'like', '%' . $search . '%')->
        orderBy('id', 'desc')->where('status', 1)->paginate(15);
        return view('frontend.pages.products.searchProducts', compact('products', 'flashes', 'search', 'categories', 'settings'));
    }
    //Shop
    public function shop()
    {
        $flashes = Flash::where('status', '1')->get();
        $categories = Category::orderBy('name', 'asc')->where('is_parent', 0)->where('status', 0)->get();
        $settings = Setting::where('id', 1)->get();
        $products = Product::orderBy('id', 'desc')->where('status', 1)->paginate(15);
        $lastProducts = Product::orderBy('id', 'desc')->where('status', 1)->take(3)->get();
        return view('frontend.pages.products.shop', compact('products', 'lastProducts', 'flashes', 'categories', 'settings'));
    }
    public function singleProduct($slug)
    {
        $flashes = Flash::where('status', '1')->get();
        $categories = Category::orderBy('name', 'asc')->where('is_parent', 0)->where('status', 0)->get();
        $settings = Setting::where('id', 1)->get();
        $prDetails = Product::where('slug', $slug)->first();
        return view('frontend.pages.products.singleProduct', compact('prDetails', 'flashes', 'categories', 'settings'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function customerLogin()
    {
        $flashes = Flash::where('status', '1')->get();
        $categories = Category::orderBy('name', 'asc')->where('is_parent', 0)->where('status', 0)->get();
        $settings = Setting::where('id', 1)->get();
        return view('frontend.pages.userAuth.login', compact('flashes', 'categories', 'settings'));
    }
    // public function resetPassword()
    // {
    //     $flashes = Flash::where('status', '1')->get();
    //     return view('frontend.pages.userAuth.reset-password', compact('flashes'));
    // }

    public function checkout()
    {
        $flashes = Flash::where('status', '1')->get();
        $countries = Country::orderBy('priority', 'asc')->where('status', '1')->get();
        $divisions = Division::orderBy('priority', 'asc')->where('status', '1')->get();
        $districts = District::orderBy('name', 'asc')->where('status', '1')->get();
        $categories = Category::orderBy('name', 'asc')->where('is_parent', 0)->where('status', 0)->get();
        $settings = Setting::where('id', 1)->get();
        return view('frontend.pages.checkout', compact('countries', 'divisions', 'districts', 'flashes', 'categories', 'settings'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function about()
    {
        $flashes = Flash::where('status', '1')->get();
        $categories = Category::orderBy('name', 'asc')->where('is_parent', 0)->where('status', 0)->get();
        $settings = Setting::where('id', 1)->get();
        return view('frontend.pages.staticPages.about', compact('flashes', 'categories', 'settings'));
    }
    public function contact()
    {
        $flashes = Flash::where('status', '1')->get();
        $categories = Category::orderBy('name', 'asc')->where('is_parent', 0)->where('status', 0)->get();
        $settings = Setting::where('id', 1)->get();
        return view('frontend.pages.staticPages.contact', compact('flashes', 'categories', 'settings'));
    }
    public function faq()
    {
        $flashes = Flash::where('status', '1')->get();
        $categories = Category::orderBy('name', 'asc')->where('is_parent', 0)->where('status', 0)->get();
        $settings = Setting::where('id', 1)->get();
        return view('frontend.pages.staticPages.faqs', compact('flashes', 'categories', 'settings'));
    }
    public function privacyPolicy()
    {
        $flashes = Flash::where('status', '1')->get();
        $categories = Category::orderBy('name', 'asc')->where('is_parent', 0)->where('status', 0)->get();
        $settings = Setting::where('id', 1)->get();
        return view('frontend.pages.staticPages.privacy-policy', compact('flashes', 'categories', 'settings'));
    }
    public function returnPolicy()
    {
        $flashes = Flash::where('status', '1')->get();
        $categories = Category::orderBy('name', 'asc')->where('is_parent', 0)->where('status', 0)->get();
        $settings = Setting::where('id', 1)->get();
        return view('frontend.pages.staticPages.return-policy', compact('flashes', 'categories', 'settings'));
    }
    public function termsCondition()
    {
        $flashes = Flash::where('status', '1')->get();
        $categories = Category::orderBy('name', 'asc')->where('is_parent', 0)->where('status', 0)->get();
        $settings = Setting::where('id', 1)->get();
        return view('frontend.pages.staticPages.terms-conditions', compact('flashes', 'categories', 'settings'));
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
        //
    }
}

<?php

namespace App\Http\Controllers\Frontend;

use File;
use Image;
use App\Models\Cart;
use App\Models\User;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Slider;
use App\Models\Country;
use App\Models\Product;
use App\Models\District;
use App\Models\Division;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
        return view('frontend.pages.homepage', compact('sliders'));
    }
    public function notFound()
    {
        return view('frontend.pages.404');
    }
    
    /**
     * Display a listing of the resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function invoice($id)
    {
        $inv = Order::find($id);
        if(!is_null($id)){
            return view('frontend.pages.userDashboard.invoice', compact('inv'));
        }
        
    }


    public function userDashboard()
    {
        $countries  = Country::orderBy('priority', 'asc')->where('status', '1')->get();
        $divisions  = Division::orderBy('priority', 'asc')->where('status', '1')->get();
        $districts  = District::orderBy('name', 'asc')->where('status', '1')->get();
        $cart       = Cart::select('order_id')->get();
        $orderHistory = Order::where('user_id', Auth::user()->id)->orderBy('inv_id', 'asc')->get();
        return view('frontend.pages.userDashboard.user-account', compact('countries', 'divisions', 'districts', 'orderHistory', 'cart'));
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
        $products = Product::orWhere('name', 'like', '%' . $search . '%')->
        orWhere('slug', 'like', '%' . $search . '%')->
        orWhere('product_tags', 'like', '%' . $search . '%')->
        orderBy('id', 'desc')->where('status', 1)->paginate(15);
        return view('frontend.pages.products.searchProducts', compact('products', 'search'));
    }
    //Shop
    public function shop()
    {
        $products = Product::orderBy('id', 'desc')->where('status', 1)->paginate(15);
        $lastProducts = Product::orderBy('id', 'desc')->where('status', 1)->take(3)->get();
        return view('frontend.pages.products.shop', compact('products', 'lastProducts'));
    }
    public function singleProduct($slug)
    {
        $prDetails = Product::where('slug', $slug)->first();
        return view('frontend.pages.products.singleProduct', compact('prDetails'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function customerLogin()
    {
        return view('frontend.pages.userAuth.login');
    }
    // public function resetPassword()
    // {
    //     $flashes = Flash::where('status', '1')->get();
    //     return view('frontend.pages.userAuth.reset-password', compact('flashes'));
    // }

    public function checkout()
    {
        $countries = Country::orderBy('priority', 'asc')->where('status', '1')->get();
        $divisions = Division::orderBy('priority', 'asc')->where('status', '1')->get();
        $districts = District::orderBy('name', 'asc')->where('status', '1')->get();
        return view('frontend.pages.checkout', compact('countries', 'divisions', 'districts'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function about()
    {
        return view('frontend.pages.staticPages.about');
    }
    public function contact()
    {
        return view('frontend.pages.staticPages.contact');
    }
    public function faq()
    {
        return view('frontend.pages.staticPages.faqs');
    }
    public function privacyPolicy()
    {
        return view('frontend.pages.staticPages.privacy-policy');
    }
    public function returnPolicy()
    {
        return view('frontend.pages.staticPages.return-policy');
    }
    public function termsCondition()
    {
        return view('frontend.pages.staticPages.terms-conditions');
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

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Country;
use App\Models\District;
use App\Models\Division;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mail;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

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
    public function invoice($inv_id)
    {
        $inv = Order::where('inv_id', $inv_id)->first();
        if (!is_null($inv)) {
            return view('frontend.pages.userDashboard.invoice', compact('inv'));
        }
    }

    public function userDashboard()
    {
        $countries       = Country::orderBy('priority', 'asc')->where('status', '1')->get();
        $divisions       = Division::orderBy('priority', 'asc')->where('status', '1')->get();
        $districts       = District::orderBy('name', 'asc')->where('status', '1')->get();
        $cart            = Cart::select('order_id')->get();
        $orderHistory    = Order::where('user_id', Auth::user()->id)->orderBy('inv_id', 'asc')->get();
        $savedCountryId  = Auth::user()->country_id;
        $savedDivisionId = Auth::user()->division_id;
        $savedDistrictId = Auth::user()->district_id;
        return view('frontend.pages.userDashboard.user-account', compact('countries', 'divisions', 'districts', 'orderHistory', 'cart', 'savedCountryId', 'savedDivisionId', 'savedDistrictId'));
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
        $user                 = User::find($id);
        $user->name           = $request->name;
        $user->lastName       = $request->lastName;
        $user->phone          = $request->phone;
        $user->addressLineOne = $request->addressLineOne;
        $user->addressLineTwo = $request->addressLineTwo;
        $user->country_id     = $request->country_id;
        $user->division_id    = $request->division_id;
        $user->district_id    = $request->district_id;

        $notification = [
            'alert-type' => 'success',
            'message'    => 'Information Have Been Updated!',
        ];

        $user->save();
        return redirect()->route('user.dashboard')->with($notification);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //Search
    public function searchProduct(Request $request)
    {
        // Set the initial minimum and maximum price range values
        $minPrice = 0;
        $maxPrice = Product::max('regular_price');

        $selectedMinPrice = request('min_price', $minPrice);
        $selectedMaxPrice = request('max_price', $maxPrice);

        // Check if the price range input is present in the request
        if (request()->has('price_range')) {
            $priceRange      = request()->input('price_range');
            $priceRangeArray = explode(',', $priceRange);

            // Set the minimum price to the first value in the price range array
            $minPrice = $priceRangeArray[0];
        }

        $filterProduct = Product::filterByPriceRange($minPrice, $maxPrice)
            ->orderBy('id', 'desc')
            ->paginate(15);

        $search       = $request->searchContent;
        $products     = Product::orWhere('name', 'like', '%' . $search . '%')->orWhere('slug', 'like', '%' . $search . '%')->orWhere('product_tags', 'like', '%' . $search . '%')->orderBy('id', 'desc')->where('status', 1)->paginate(15);
        $lastProducts = Product::orderBy('id', 'desc')->where('status', 1)->take(3)->get();
        return view('frontend.pages.products.searchProducts', compact('products', 'lastProducts', 'search', 'minPrice', 'maxPrice'));
    }
    //Shop
    public function shop(Request $request)
    {
        // Get the minimum and maximum price range values
        $minPrice = 0;
        $maxPrice = Product::max('regular_price');

        $selectedMinPrice = request('min_price', $minPrice);
        $selectedMaxPrice = request('max_price', $maxPrice);

        //Spatie query builder to filter the products by category and price range
        $products = QueryBuilder::for(Product::class)
            ->allowedFilters([
                'category_id',
                'regular_price',
                AllowedFilter::scope('priceRangeFrom', $selectedMinPrice),
                AllowedFilter::scope('priceRangeTo', $selectedMaxPrice)
            ])
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->withQueryString();

        $lastProducts = Product::orderBy('id', 'desc')
            ->where('status', 1)
            ->take(3)
            ->get();
        return view('frontend.pages.products.shop', compact('products', 'lastProducts', 'minPrice', 'maxPrice', 'selectedMinPrice', 'selectedMaxPrice'));
    }

    public function singleProduct($slug)
    {
        $prDetails = Product::where('slug', $slug)->first();
        $reviews   = ProductReview::where('product_id', $prDetails->id)->get();
        return view('frontend.pages.products.singleProduct', compact('prDetails', 'reviews'));
    }

    public function categoryProduct($slug)
    {
        // Set the initial minimum and maximum price range values
        $minPrice = 0;
        $maxPrice = Product::max('regular_price');

        // Check if the price range input is present in the request
        if (request()->has('price_range')) {
            $priceRange      = request()->input('price_range');
            $priceRangeArray = explode(',', $priceRange);

            // Set the minimum price to the first value in the price range array
            $minPrice = $priceRangeArray[0];
        }

        $products = Product::filterByPriceRange($minPrice, $maxPrice)
            ->orderBy('id', 'desc')
            ->paginate(15);

        $cDetails     = Category::where('slug', $slug)->where('status', 0)->paginate(15);
        $lastProducts = Product::orderBy('id', 'desc')->where('status', 1)->take(3)->get();
        return view('frontend.pages.products.categoryProduct', compact('cDetails', 'lastProducts', 'minPrice', 'maxPrice'));
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
        if (Auth::check()) {
            $savedCountryId  = Auth::user()->country_id;
            $savedDivisionId = Auth::user()->division_id;
            $savedDistrictId = Auth::user()->district_id;
        } else {
            $savedCountryId  = '';
            $savedDivisionId = '';
            $savedDistrictId = '';
        }
        return view('frontend.pages.checkout', compact('countries', 'divisions', 'districts', 'savedCountryId', 'savedDivisionId', 'savedDistrictId'));
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

    public function contactData(Request $request)
    {
        $settings = Setting::where('id', 1)->first();
        $mailData = [
            'name'    => $request->name,
            'email'   => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ];

        Mail::to('satanudatta94@gmail.com')->send(new ContactMail($mailData, $settings));

        $notification = [
            'alert-type' => 'success',
            'message'    => 'Your Mail Has Been Sent!',
        ];

        return redirect()->route('home')->with($notification);
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
}

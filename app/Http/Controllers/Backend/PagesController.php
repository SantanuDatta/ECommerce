<?php

namespace App\Http\Controllers\Backend;

use App\Charts\TopSale;
use App\Charts\ViewMonth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\SiteView;
use Carbon\Carbon;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with('carts.product')
            ->where('status', 3)
            ->limit(3)
            ->get();

        $data = [];

        // Loop through the orders and group the cart items by product name
        foreach ($orders as $order) {
            foreach ($order->carts as $cart) {
                $productName = $cart->product->name;
                $quantity = $cart->product_quantity;

                if (!array_key_exists($productName, $data)) {
                    $data[$productName] = array_fill(0, 12, 0); // Initialize the array with 0s for each month
                }
                $month = Carbon::parse($order->created_at)->format('n') - 1; // Get the month index (0-11)
                $data[$productName][$month] += $quantity; // Add the quantity to the corresponding month
            }
        }

        $barChart = new TopSale();
        $colors = [
            'rgba(23,162,184,0.8)',
            'rgba(111,66,193,0.8)',
            'rgba(255, 206, 86, 0.8)',
        ]; // define an array of colors

        $i = 0; // set a counter to keep track of the color index
        foreach ($data as $productName => $productData) {
            $color = $colors[$i]; // get the color from the array
            $barChart->dataset($productName, 'bar', $productData)->backgroundColor($color);
            $i++; // increment the counter
            if ($i >= count($colors)) {
                $i = 0; // reset the counter if all colors have been used
            }
        }

        $barChart->labels(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'])->height(350);

        
        // Site View Stat
        $startDate = now()->subDay(29)->startOfDay();
        $endDate = now()->endOfDay();

        // Get the data
        $viewData = SiteView::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Get the data for the last month
        $lastMonthStartDate = now()->subMonth()->startOfMonth();
        $lastMonthEndDate = now()->subMonth()->endOfMonth();
        $lastMonthViewData = SiteView::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereBetween('created_at', [$lastMonthStartDate, $lastMonthEndDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Create the chart
        $labels = [];
        $values = [];
        $currentDate = $startDate;
        while ($currentDate <= $endDate) {
            $formattedDate = $currentDate->format('Y-m-d');
            $labels[] = $formattedDate;
            $matchingData = $viewData->firstWhere('date', $formattedDate);
            if ($matchingData) {
                $values[] = $matchingData->count;
            } else {
                $values[] = 0;
            }
            $lastMonthMatchingData = $lastMonthViewData->firstWhere('date', $formattedDate);
            if ($lastMonthMatchingData) {
                $values2[] = $lastMonthMatchingData->count;
            } else {
                $values2[] = 0;
            }
            $currentDate = $currentDate->addDay();
        }

        // Format the labels in the desired format
        $formattedLabels = [];
        foreach ($labels as $label) {
            $formattedLabels[] = Carbon::parse($label)->setTimezone('UTC')->format('d M');
        }

        $areaChart = new ViewMonth();
        $areaChart->height(315);
        $areaChart->labels($formattedLabels);
        $areaChart->dataset('Viewed This Month', 'line', $values)
            ->color('rgba(23,162,184,1)')
            ->backgroundColor('rgba(23,162,184,0.5)');
        $areaChart->dataset('Viewed Last Month', 'line', $values2)
            ->color('rgba(111,66,193,1)')
            ->backgroundColor('rgba(111,66,193,0.7)');

        return view('backend.pages.dashboard', compact('barChart', 'areaChart'));
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

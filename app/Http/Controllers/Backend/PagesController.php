<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\SiteView;
use Carbon\Carbon;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with('carts.product')->where('status', 3)->limit(3)->get();
        $data = [];

        // Loop through the orders and group the cart items by product name
        foreach ($orders as $order) {
            foreach ($order->carts as $cart) {
                $productName = $cart->product->name;
                $quantity = $cart->product_quantity;

                if (!isset($data[$productName])) {
                    $data[$productName] = array_fill(0, 12, 0); // Initialize the array with 0s for each month
                }
                $month = Carbon::parse($order->created_at)->format('n') - 1; // Get the month index (0-11)
                $data[$productName][$month] += $quantity; // Add the quantity to the corresponding month
            }
        }

        $barChart = (new LarapexChart)->barChart();
        foreach ($data as $productName => $productData) {
            $barChart->addData($productName, $productData);
        }

        $barChart->setXAxis(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'])
            ->setFontFamily('"Fira Sans", "Helvetica Neue", Arial, sans - serif')
            ->setColors(['#17A2B8', '#6f42c1', '#1CAF9A'])
            ->setHeight('350')
            ->setFontColor('#ffffff');

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

        $areaChart = (new LarapexChart)->areaChart()
            ->addData('Viewed This Month', $values)
            ->addData('Viewed Last Month', $values2)
            ->setColors(['#17A2B8', '#6f42c1'])
            ->setHeight('315')
            ->setFontColor('#ffffff')
            ->setXAxis($formattedLabels);

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

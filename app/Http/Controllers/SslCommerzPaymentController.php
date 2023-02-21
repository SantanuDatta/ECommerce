<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Cart;
use App\Models\Flash;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Library\SslCommerz\SslCommerzNotification;
use App\Mail\OrderReceived;
use Mail;

class SslCommerzPaymentController extends Controller
{

    public function exampleEasyCheckout()
    {
        return view('exampleEasycheckout');
    }

    public function exampleHostedCheckout()
    {
        return view('exampleHosted');
    }

    public function index(Request $request)
    {
        # Here you have to receive all the order data to initate the payment.
        # Let's say, your oder transaction informations are saving in a table called "orders"
        # In "orders" table, order unique identity is "transaction_id". "status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['payment_method']    = $request->payment_method;
        $post_data['total_quantity']    = $request->totalQuantity;
        $post_data['total_amount']      = $request->totalAmount; # You cant not pay less than 10
        $post_data['currency']          = "BDT";
        $post_data['tran_id']           = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_id']            = Auth::user()->id;
        $post_data['cus_name']          = $request->name;
        $post_data['cus_lastName']      = $request->lastName;
        $post_data['cus_email']         = $request->email;
        $post_data['cus_add1']          = $request->addressLineOne;
        $post_data['cus_add2']          = $request->addressLineTwo;
        $post_data['cus_city']          = $request->division_id;
        $post_data['cus_state']         = $request->district_id;
        $post_data['cus_country']       = $request->country_id;
        $post_data['cus_postcode']      = '1000';
        $post_data['cus_phone']         = $request->phone;
        $post_data['cus_info']          = $request->add_info;
        $post_data['cus_fax']           = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        if ($post_data['payment_method'] == 1) {
            // COD
            $lastInvoice = Order::orderBy('id', 'desc')->first();
            if (empty($lastInvoice)) {
                $newInvoice = 1;
            } else {
                $newInvoice = $lastInvoice->inv_id + 1;
            }

            $createDate = Carbon::now();
            $createDateTime = $createDate->toDateTimeString();

            #Before  going to initiate the payment order status need to insert or update as Pending.
            $update_product = DB::table('orders')
                ->where('transaction_id', $post_data['tran_id'])
                ->updateOrInsert([
                    'inv_id'                => $newInvoice,
                    'user_id'               => $post_data['cus_id'],
                    'name'                  => $post_data['cus_name'],
                    'lastName'              => $post_data['cus_lastName'],
                    'email'                 => $post_data['cus_email'],
                    'phone'                 => $post_data['cus_phone'],
                    'address_1'             => $post_data['cus_add1'],
                    'address_2'             => $post_data['cus_add2'],
                    'country_id'            => $post_data['cus_country'],
                    'division_id'           => $post_data['cus_city'],
                    'district_id'           => $post_data['cus_state'],
                    'zipcode'               => $post_data['cus_postcode'],
                    'add_info'              => $post_data['cus_info'],
                    'status'                => 1,
                    'payment_method'        => $post_data['payment_method'],
                    'total_quantity'        => $post_data['total_quantity'],
                    'amount'                => $post_data['total_amount'],
                    'transaction_id'        => $post_data['tran_id'],
                    'currency'              => $post_data['currency'],
                    'created_at'            => $createDateTime,
                ]);

            $orderID = Order::where('transaction_id', $post_data['tran_id'])->first();

            foreach (Cart::totalCarts() as $cart) {
                if (!is_null($cart->product->offer_price)) {
                    $totalSave = ($cart->product->regular_price * ($cart->product->offer_price / 100));
                    $cart->unit_price = $totalSave;
                    $cart->user_id  = $post_data['cus_id'];
                    $cart->order_id = $orderID->id;
                    $currentQuantity = DB::table('products')->where('id', $cart->product_id)->value('quantity');
                    if ($currentQuantity - $cart->product_quantity < 0) {
                        $notification = array(
                            'alert-type'    => 'error',
                            'message'       => 'This product is out of stock!',
                        );
                        return redirect()->back()->with($notification);
                    }
                    $updatedQuantity = $currentQuantity - $cart->product_quantity;
                    DB::table('products')->where('id', $cart->product_id)->update(['quantity' => $updatedQuantity]);
                    $cart->save();
                } else {
                    $cart->unit_price = $cart->product->regular_price;
                    $cart->user_id  = $post_data['cus_id'];
                    $cart->order_id = $orderID->id;
                    $currentQuantity = DB::table('products')->where('id', $cart->product_id)->value('quantity');
                    if ($currentQuantity - $cart->product_quantity < 0) {
                        $notification = array(
                            'alert-type'    => 'error',
                            'message'       => 'This product is out of stock!',
                        );
                        return redirect()->back()->with($notification);
                    }
                    $updatedQuantity = $currentQuantity - $cart->product_quantity;
                    DB::table('products')->where('id', $cart->product_id)->update(['quantity' => $updatedQuantity]);
                    $cart->save();
                }
            }
            $orderHistory = Order::where('transaction_id', $post_data['tran_id'])->first();
            if ($orderHistory) {
                Mail::to($post_data['cus_email'])->send(new OrderReceived($orderHistory));
            }
            return view('frontend.pages.success', compact('orderHistory'));
        } elseif ($post_data['payment_method'] == 2) {
            //SSL Commerce
            $lastInvoice = Order::orderBy('id', 'desc')->first();
            if (empty($lastInvoice)) {
                $newInvoice = 1;
            } else {
                $newInvoice = $lastInvoice->inv_id + 1;
            }

            $createDate = Carbon::now();
            $createDateTime = $createDate->toDateTimeString();

            #Before  going to initiate the payment order status need to insert or update as Pending.
            $update_product = DB::table('orders')
                ->where('transaction_id', $post_data['tran_id'])
                ->updateOrInsert([
                    'inv_id'                => $newInvoice,
                    'user_id'               => $post_data['cus_id'],
                    'name'                  => $post_data['cus_name'],
                    'lastName'              => $post_data['cus_lastName'],
                    'email'                 => $post_data['cus_email'],
                    'phone'                 => $post_data['cus_phone'],
                    'address_1'             => $post_data['cus_add1'],
                    'address_2'             => $post_data['cus_add2'],
                    'country_id'            => $post_data['cus_country'],
                    'division_id'           => $post_data['cus_city'],
                    'district_id'           => $post_data['cus_state'],
                    'zipcode'               => $post_data['cus_postcode'],
                    'add_info'              => $post_data['cus_info'],
                    'status'                => 1,
                    'payment_method'        => $post_data['payment_method'],
                    'total_quantity'        => $post_data['total_quantity'],
                    'amount'                => $post_data['total_amount'],
                    'transaction_id'        => $post_data['tran_id'],
                    'currency'              => $post_data['currency'],
                    'created_at'            => $createDateTime,
                ]);

            $orderID = Order::where('transaction_id', $post_data['tran_id'])->first();

            foreach (Cart::totalCarts() as $cart) {
                if (!is_null($cart->product->offer_price)) {
                    $totalSave = ($cart->product->regular_price * ($cart->product->offer_price / 100));
                    $cart->unit_price = $totalSave;
                    $cart->user_id  = $post_data['cus_id'];
                    $cart->order_id = $orderID->id;
                    $currentQuantity = DB::table('products')->where('id', $cart->product_id)->value('quantity');
                    if ($currentQuantity - $cart->product_quantity < 0) {
                        $notification = array(
                            'alert-type'    => 'error',
                            'message'       => 'This product is out of stock!',
                        );
                        return redirect()->back()->with($notification);
                    }
                    $updatedQuantity = $currentQuantity - $cart->product_quantity;
                    DB::table('products')->where('id', $cart->product_id)->update(['quantity' => $updatedQuantity]);
                    $cart->save();
                } else {
                    $cart->unit_price = $cart->product->regular_price;
                    $cart->user_id  = $post_data['cus_id'];
                    $cart->order_id = $orderID->id;
                    $currentQuantity = DB::table('products')->where('id', $cart->product_id)->value('quantity');
                    if ($currentQuantity - $cart->product_quantity < 0) {
                        $notification = array(
                            'alert-type'    => 'error',
                            'message'       => 'This product is out of stock!',
                        );
                        return redirect()->back()->with($notification);
                    }
                    $updatedQuantity = $currentQuantity - $cart->product_quantity;
                    DB::table('products')->where('id', $cart->product_id)->update(['quantity' => $updatedQuantity]);
                    $cart->save();
                }
            }

            $sslc = new SslCommerzNotification();
            # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
            $payment_options = $sslc->makePayment($post_data, 'hosted');
            if (!is_array($payment_options)) {
                print_r($payment_options);
                $payment_options = array();
            }
        }
    }

    public function payViaAjax(Request $request)
    {

        # Here you have to receive all the order data to initate the payment.
        # Lets your oder trnsaction informations are saving in a table called "orders"
        # In orders table order uniq identity is "transaction_id","status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['total_amount'] = '10'; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = 'Customer Name';
        $post_data['cus_email'] = 'customer@mail.com';
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '8801XXXXXXXXX';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";


        #Before  going to initiate the payment order status need to update as Pending.
        $update_product = DB::table('orders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'name' => $post_data['cus_name'],
                'email' => $post_data['cus_email'],
                'phone' => $post_data['cus_phone'],
                'amount' => $post_data['total_amount'],
                'status' => 'Pending',
                'address' => $post_data['cus_add1'],
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency']
            ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
    }

    public function success(Request $request)
    {
        //echo "Transaction is Successful";

        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');
        $email    = $request->input('email');

        $sslc = new SslCommerzNotification();

        #Check order status in order tabel against the transaction id or order id.
        $order_detials = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_detials->status == 1) {
            $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);

            if ($validation == TRUE) {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel. Here you need to update order status
                in order table as Processing or Complete.
                Here you can also sent sms or email for successfull transaction to customer
                */
                $update_product = DB::table('orders')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => 2]);

                //echo "<br >Transaction is successfully Completed";
                $orderHistory = Order::where('transaction_id', $tran_id)->first();
                if ($orderHistory) {
                    Mail::to($email)->send(new OrderReceived($orderHistory));
                }
                return view('frontend.pages.success', compact('orderHistory'));
            } else {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel and Transation validation failed.
                Here you need to update order status as Failed in order table.
                */
                $update_product = DB::table('orders')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => 5]);
                echo "validation Fail";
            }
        } else if ($order_detials->status == 2 || $order_detials->status == 3) {
            /*
            That means through IPN Order status already updated. Now you can just show the customer that transaction is completed. No need to update database.
             */
            //echo "Transaction is successfully Completed";
            $orderHistory = Order::where('transaction_id', $tran_id)->first();
            return view('frontend.pages.success', compact('orderHistory'));
        } else {
            #That means something wrong happened. You can redirect customer to your product page.
            echo "Invalid Transaction";
        }
    }

    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_detials = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_detials->status == 1) {
            $update_product = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 4]);
            echo "Transaction is Falied";
        } else if ($order_detials->status == 2 || $order_detials->status == 3) {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }
    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_detials = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_detials->status == 1) {
            $update_product = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 5]);
            echo "Transaction is Cancel";
        } else if ($order_detials->status == 2 || $order_detials->status == 3) {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }
    }

    public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {

            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.
            $order_details = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->select('transaction_id', 'status', 'currency', 'amount')->first();

            if ($order_details->status == 1) {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($request->all(), $tran_id, $order_details->amount, $order_details->currency);
                if ($validation == TRUE) {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successful transaction to customer
                    */
                    $update_product = DB::table('orders')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 2]);

                    echo "Transaction is successfully Completed";
                } else {
                    /*
                    That means IPN worked, but Transation validation failed.
                    Here you need to update order status as Failed in order table.
                    */
                    $update_product = DB::table('orders')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 5]);

                    echo "validation Fail";
                }
            } else if ($order_details->status == 2 || $order_details->status == 3) {

                #That means Order status already updated. No need to udate database.

                echo "Transaction is already successfully Completed";
            } else {
                #That means something wrong happened. You can redirect customer to your product page.

                echo "Invalid Transaction";
            }
        } else {
            echo "Invalid Data";
        }
    }
}

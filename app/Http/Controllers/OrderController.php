<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use PaymentAssist\ApiClient;

class OrderController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    function __construct()
    {
        $this->middleware('auth');
//        sets the credentials using the API key and the secret
        $credentials = array('api_key'=>env('PA_API_KEY'), 'secret'=>env('PA_SECRET'));
//        use the credentials to instantiate a new instance of the API Client
        $this->pa = new ApiClient($credentials);
//        changes the API URL to the demo URL
        ApiClient::$apiUrl = 'https://api.demo.payassi.st';
    }

    /**
     *
     * Display a listing of the orders.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orders = Order::orderBy('created_at', 'desc')->paginate(5);

        $token = $request->input('token');
        $status = $request->input('status');
        $sig = $request->input('signature');
//        generates the API signature
        $signature = $this->pa->generateSignature(['token' => $token, 'status' => $status]);
//        if GET token is in the URL
        if(isset($token) && $status == 'success'){
//            validates the signatures
            if($sig == $signature) {
                //This sets the status to 1 if valid token is received
                if (!empty($token)) {
                    foreach ($orders as $order) {
                        if ($order->token == $token) {
                            $order->status = 1;
                            $order->invoiced = 0;
                            $order->save();
                        }
                    }
                }
            } else{
                if (!empty($token)) {
                    foreach ($orders as $order) {
                        if ($order->token == $token) {
                            $order->status = 2; //failed
                            $order->invoiced = 0;
                            $order->save();
                        }
                    }
                }//return "ERROR!";
            }
        } else{
            if (!empty($token)) {
                foreach ($orders as $order) {
                    if ($order->token == $token) {
                        $order->status = 2; //failed
                        $order->invoiced = 0;
                        $order->save();
                    }
                }
            }
        }

        return view('orders.index', compact('orders'));
    }

    /**
     *
     * Displays a list of customer specific orders.
     * @param Order $order
     * @return Order
     */
    public function show(Order $order)
    {
        $rows = json_decode($order->order_lines, TRUE);
        return view('orders.show', compact('order', 'rows'));
    }
}

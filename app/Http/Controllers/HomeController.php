<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use PaymentAssist\ApiClient;

class HomeController extends Controller
{

    private $pa;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    function __construct()
    {
//        Sets the credentials using the API key and the secret
        $credentials = array('api_key'=>env('PA_API_KEY'), 'secret'=>env('PA_SECRET'));
//        Use the credentials to instantiate a new instance of the API Client
        $this->pa = new ApiClient($credentials);
//        Changes the API URL to the demo URL
        ApiClient::$apiUrl = 'https://api.demo.payassi.st';
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Validate the returned URL and displays the customer completed page
     * Updates the customer status to true if Validation is successful
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function completed(Request $request){

        $orders = Order::all();
//        Get the 'token', 'status' and 'signature' from the URL
        $token = $request->input('token');
        $status = $request->input('status');
        $sig = $request->input('signature');
//        Generate the API signature by passing the 'token' and the 'status' from the URL
        $signature = $this->pa->generateSignature(['token' => $token, 'status' => $status]);
//        if signatures and tokens match then change status to true
        if($sig == $signature){
            if(!empty($orders)){

                foreach ($orders as $order){
                    if($order->token == $token){
                        $order->status = 1;
                        $order->save();
                    }
                }
            }
            return view('completed');
        } else{
            return "ERROR!";
        }

    }
}

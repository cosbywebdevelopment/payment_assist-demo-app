<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Order;
use App\Product;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PaymentAssist\ApiClient;

class BillingController extends Controller
{

    /**
     * @var ApiClient
     */
    private $pa;

    /**
     * @var string
     */
    public $plan_button = '';
    /**
     * @var string
     */
    public $checkout_button = 'disabled';
    /**
     * @var string
     */
    public $invoice_button = 'disabled';

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
     * Payment assist /preapproval API https://api-docs.payment-assist.co.uk/methods/preapproval
     * POST parameters 'f_name', 's_name', 'addr1' and 'postcode'.
     * Returns status and redirects to billing page with message.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function preapproval(Request $request)
    {
        $params = [
            'f_name' => $request->input('f_name'),
            's_name' => $request->input('s_name'),
            'addr1' => $request->input('addr1'),
            'postcode' => $request->input('postcode'),
        ];

        $result = $this->pa->request('/preapproval', 'POST', $params);

        if($result->status == 'ok'){
            $message = 'preapproved';
        } else{
            $message = 'failed';
        }
        return redirect()->back()->with('preapproved', $message)->with('preapproved_button', 'disabled');
    }

    /**
     * Payment assist /plan API https://api-docs.payment-assist.co.uk/methods/plan
     * POST parameters 'amount', 'plan_id'.
     * Saves payment plan array data to the session for display purposes.
     * Returns status and redirects to billing page and displays customer payment plan.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function plan()
    {
        $amount = Cart::total();
//        changes the amount to pence
        $amount = (int)str_replace('.', '', $amount);
        $params = [
            'amount' => $amount,
            'plan_id' => 1
        ];

        $result = $this->pa->request('/plan', 'POST', $params);

        if($result->status == 'error'){
            return redirect()->back()->with('plan_error', 'Please add an item to the basket!');
        } else{
            \session(['plan' => $result->data->plan,
                'amount' => $result->data->amount,
                'interest' => $result->data->interest,
                'repayable' => $result->data->repayable,
                'schedule' => $result->data->schedule,
                'disabled' => 'disabled']);
        }

        return redirect()->back()->with('preapproved_button', 'disabled')->with('plan_button', 'disabled');
    }

    /**
     * Payment assist /begin API https://api-docs.payment-assist.co.uk/methods/begin
     * POST parameters.
     * Returns status and redirects to 'success_url' or 'failure_url'.
     * @param Request $request
     * @param Customer $customer
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function begin(Request $request, Customer $customer)
    {
        $amount = Cart::total();
        $amount = (int)str_replace('.', '', $amount);

        $params = [
            'failure_url' => 'https://www.bbc.co.uk/',
            'success_url' => 'https://laravel-demo-app.payassi.st/orders',
            'order_id' => rand(10,10000),
            'amount' => $amount,
            'email' => $request->input('email'),
            'plan_id' => 1,
            'f_name' => $request->input('f_name'),
            's_name' => $request->input('s_name'),
            'addr1' => $request->input('addr1'),
            'addr2' => $request->input('addr2'),
            'town' => $request->input('city'),
            'county' => $request->input('county'),
            'postcode' => $request->input('postcode'),
            'telephone' => $request->input('telephone')
        ];
//        if customer isn't present, send extra params
        if($request->input('send_sms')){
            $params['success_url'] = 'https://laravel-demo-app.payassi.st/completed';
            $params['send_sms'] = true;
            $params['send_email'] = true;
        }

        $result = $this->pa->request('/begin', 'POST', $params);

        if($result->status == 'ok'){

//            save token to orders table
            $customer->orders()->create(['order_lines' => Cart::content(),
                'total' => Cart::total(),
                'token' => $result->data->token]);
//            remove cart data
            Cart::destroy();

        } else{
            return redirect()->back()->with('order_id', 'Error ' . $result->status);
        }

        if ($request->input('send_sms')){
            return redirect(route('orders'))->with('sent_to_customer', 'Email / SMS been sent to Customer!');
        }

        return redirect($result->data->url);
    }

    /**
     *
     * Payment assist /status API https://api-docs.payment-assist.co.uk/methods/status
     * POST parameters 'token'.
     * Saves payment plan array data to the session for display purposes.
     * @return mixed
     */
    public function status(){

        $orders = Order::where('token', '!=', null)->where('status', null)->get();
        //loop through all orders and get status via the API
        foreach ($orders as $customer){
            $params = [
                'token' => $customer->token
            ];
            $result = $this->pa->request('/status', 'POST', $params);
//            if status is ok and complete then save customer status to true in the database
            if($result->status == 'ok' && $result->data->status == 'completed'){
                $customer->status = 1;
                $customer->save();
            }
            elseif ($result->data->status == 'expired'){
                $customer->status = 3;
                $customer->save();
            }
        }
//        return completed applications
        $complete = Order::where('status', 1)->select('id')->get();
        $expired = Order::where('status', 3)->select('id')->get();

        return ['complete' => $complete, 'expired' => $expired];

    }

    /**
     * Payment assist /invoice API https://api-docs.payment-assist.co.uk/methods/invoice
     * Creates an invoice, base64_encodes it.
     * POST parameters 'token', 'filetype', 'filedata'.
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function invoice(Order $order){
//        customer details
        $invoice = $order->customer->firstname . ' ' . $order->customer->surname . "\n";
        $invoice .= $order->customer->address1 . ' ' . $order->customer->address2 . "\n";
        $invoice .= $order->customer->city . ' ' . $order->customer->postcode . "\n";
        $invoice .= $order->customer->mobile . "\n";
//        order lines
        $data = json_decode($order->order_lines, TRUE);
        foreach ($data as $item) {
            $invoice .= 'Product: ' . $item['name'] . "\n";
            $invoice .= 'Quantity: ' . $item['qty'] . "\n";
            $invoice .= 'Price: ' . $item['price'] . "\n";
        }
//        order total
        $invoice .= 'Total: ' . $order->total . "\n";
//        saves file to storage
        Storage::disk('local')->put('file.txt', $invoice);
//        encodes file
        $file = base64_encode(Storage::get('file.txt'));
        $params = [
            'token' => $order->token,
            'filetype' => 'txt',
            'filedata' => $file
        ];

        $result = $this->pa->request('/invoice', 'POST', $params);

        if($result->status == 'ok'){
            $order->invoiced = 1;
            $order->save();
            return redirect()->back()->with('invoice', 'Your invoice has been successfully uploaded to Payment Assist');
        }
        return redirect()->back()->with('invoice', 'Your invoice has failed!');
    }

    /**
     * Display the customer billing.
     *
     * @param Request $request
     * @param \App\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Customer $customer)
    {
        $plan_button = $this->plan_button;
        $checkout_button = $this->checkout_button;
        $invoice_button = $this->invoice_button;
        $products = Product::all();
//        if flash data is 'peapproved_button' then change plan_button to empty
        if($request->session()->get('preapproved_button')){
            $plan_button = $this->plan_button = '';
        }
//        if flash data is 'plan_button' then change plan_button to disabled
//        and checkout_button to empty
        if($request->session()->get('plan_button')){
            $plan_button = $this->plan_button = 'disabled';
            $checkout_button = $this->checkout_button = '';
        }
        return view('billing.step1', compact('customer', 'products', 'plan_button', 'checkout_button', 'invoice_button'));
    }

}

<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Order;
use App\Product;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     * Sends the count of 'customers', 'products' and 'orders' to display
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $customers = Customer::count();
        $products = Product::count();
        $orders = Order::count();
        return view('dashboard.home', compact('customers', 'products', 'orders'));
    }
}

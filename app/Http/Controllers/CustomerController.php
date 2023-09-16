<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Order;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class CustomerController extends Controller
{
//    array of uk Counties
    public $counties = array(
  'England' => array(
    'Avon',
    'Bedfordshire',
    'Berkshire',
    'Buckinghamshire',
    'Cambridgeshire',
    'Cheshire',
    'Cleveland',
    'Cornwall',
    'Cumbria',
    'Derbyshire',
    'Devon',
    'Dorset',
    'Durham',
    'East Sussex',
    'Essex',
    'Gloucestershire',
    'Hampshire',
    'Herefordshire',
    'Hertfordshire',
    'Isle of Wight',
    'Kent',
    'Lancashire',
    'Leicestershire',
    'Lincolnshire',
    'London',
    'Merseyside',
    'Middlesex',
    'Norfolk',
    'Northamptonshire',
    'Northumberland',
    'North Humberside',
    'North Yorkshire',
    'Nottinghamshire',
    'Oxfordshire',
    'Rutland',
    'Shropshire',
    'Somerset',
    'South Humberside',
    'South Yorkshire',
    'Staffordshire',
    'Suffolk',
    'Surrey',
    'Tyne and Wear',
    'Warwickshire',
    'West Midlands',
    'West Sussex',
    'West Yorkshire',
    'Wiltshire',
    'Worcestershire'
  ),
  'Wales' => array(
    'Clwyd',
    'Dyfed',
    'Gwent',
    'Gwynedd',
    'Mid Glamorgan',
    'Powys',
    'South Glamorgan',
    'West Glamorgan'
  ),
  'Scotland' => array(
    'Aberdeenshire',
    'Angus',
    'Argyll',
    'Ayrshire',
    'Banffshire',
    'Berwickshire',
    'Bute',
    'Caithness',
    'Clackmannanshire',
    'Dumfriesshire',
    'Dunbartonshire',
    'East Lothian',
    'Fife',
    'Inverness-shire',
    'Kincardineshire',
    'Kinross-shire',
    'Kirkcudbrightshire',
    'Lanarkshire',
    'Midlothian',
    'Moray',
    'Nairnshire',
    'Orkney',
    'Peeblesshire',
    'Perthshire',
    'Renfrewshire',
    'Ross-shire',
    'Roxburghshire',
    'Selkirkshire',
    'Shetland',
    'Stirlingshire',
    'Sutherland',
    'West Lothian',
    'Wigtownshire'
  ),
  'Northern Ireland' => array(
    'Antrim',
    'Armagh',
    'Down',
    'Fermanagh',
    'Londonderry',
    'Tyrone'
  )
);

    /**
     * Create a new controller instance.
     * Added authentication to this controller
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     * Removes 'plan', 'amount', 'interest', 'repayable', 'schedule', 'pa_token', 'disabled'
     * from the session
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->session()->forget(['plan', 'amount', 'interest', 'repayable', 'schedule', 'pa_token', 'disabled']);
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new customer.
     * Sending the counties to the form to display.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $counties = $this->counties;
        return view('customers.create', compact('counties'));
    }

    /**
     * Store a newly created customer in database
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Customer::firstOrCreate($request->except('_token'));
        return redirect(route('customers.index'))->with('status', 'Customer Created!');
    }


    /**
     * Show the form for editing customers.
     * Shows list of orders associated with customer
     *
     * @param Customer $customer
     * @return void
     */
    public function edit(Customer $customer)
    {
        $orders = Order::where('customer_id', $customer->id)->paginate(5);
        $counties = $this->counties;
        return view('customers.edit', compact('customer', 'counties', 'orders'));
    }

    /**
     * Update the customer in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @param Customer $customer
     * @return void
     */
    public function update(Customer $customer)
    {
        $customer->update(request()->all());
        return redirect(route('customers.index'))->with('status', 'Customer Updated!');
    }

    /**
     * Remove the customer from the database.
     *
     * @param Customer $customer
     * @return void
     * @throws \Exception
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect(route('customers.index'))->with('status', 'Customer Deleted!');

    }

}

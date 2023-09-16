<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use mysql_xdevapi\Exception;

class TyresController extends Controller
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
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $products = Product::where('type', 'tyre')->get();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        try {
            Product::firstOrCreate($request->except('_token'));
        } catch (Exception $exception){
            return view('tyres.index')->with('failed');
        }

        return redirect(route('tyres.index'))->with('status', 'Tyre Added!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $tyre
     * @return Response
     */
    public function edit(Product $tyre)
    {
        return view('products.edit', compact('tyre'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Product $tyre
     * @return Response
     */
    public function update(Product $tyre)
    {
        $tyre->update(request()->all());
        return redirect(route('tyres.index'))->with('status', 'Tyre Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $tyre
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Product $tyre)
    {
        $tyre->delete();
        return redirect(route('tyres.index'))->with('status', 'Tyre Deleted!');
    }
}

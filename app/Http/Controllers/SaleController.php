<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sale;
use App\Service;
use App\Product;
use App\Client;
use View;
use Auth;
use Excel;
use Illuminate\Support\Facades\DB;
use App\Exports\SalesExport;


class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales=Sale::all();
        $services=DB::table('services')->orderBy('service_name','asc')->get();
        $products=DB::table('products')->orderBy('product_name','asc')->get();
        $clients=DB::table('clients')->orderBy('client_name','asc')->get();
        return View::make('sales.index', ['sales'=>$sales, 'services'=>$services, 'products'=>$products, 'clients'=>$clients]);
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fetchLastSaleId(Request $request)
    {
        $last_sale=DB::table('sales')->latest('sale_id')->first();
        
        return response()->json([
            "last_sale_id" => $last_sale->sale_id
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->ajax()){
            $sale=new Sale;
            $sale->sale_worker_id=Auth::id();
            $sale->sale_client_id=$request->sale_client_id;
            $sale->sale_payment_form_id=$request->sale_payment_form_id;
            $sale->sale_invoiced=$request->sale_invoiced;
            $sale->sale_total_amount=$request->sale_total_amount;
            $sale->save();

            return response()->json([
                "message" => "Venta creada correctamente.",
                "sale_id" => $sale->sale_id,
            ],200);
        }
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

    public function export() 
    {
        return Excel::download(new SalesExport, 'sales.xlsx');
    }
}

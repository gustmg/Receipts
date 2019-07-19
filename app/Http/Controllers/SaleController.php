<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sale;
use App\Service;
use App\Product;
use App\Client;
use View;
use Auth;

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
        $services=Service::all();
        $products=Product::all();
        $clients=Client::all();
        return View::make('sales.index', ['sales'=>$sales, 'services'=>$services, 'products'=>$products, 'clients'=>$clients]);
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
            $sale=new Receipt;
            $sale->sale_worker_id=Auth::id();
            $sale->sale_client_id=$request->sale_client_id;
            $sale->sale_payment_form_id=$request->sale_payment_form_id;
            $sale->sale_total_amount=$request->sale_total_amount;
            $sale->save();

            $connector = new WindowsPrintConnector("EC-PM-80250");
            $printer = new Printer($connector);
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> text("TECTRO\n");
            $printer -> text("Centro de servicios informáticos\n");
            $printer -> text("Calle Encino 1-A, Col. Viveros Santa Cruz\n");
            $printer -> text("Puebla, Pue.\n");
            $printer -> cut();
            $printer -> close();

            return response()->json([
                "message" => "Venta creada correctamente.",
                
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
}

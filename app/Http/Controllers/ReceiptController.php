<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Receipt;
use App\Service;
use App\Client;
use View;

class ReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $receipts=Receipt::all();
        $services=Service::all();
        $clients=Client::all();
        return View::make('receipts.index', ['receipts'=>$receipts, 'services'=>$services, 'clients'=>$clients]);
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
            $receipt=new Receipt;
            $receipt->receipt_worker_id=Auth::id();
            $receipt->receipt_client_id=$request->client_id;
            $receipt->save();

            return response()->json([
                "message" => "Recepción creada correctamente.",
                "receipt_id" => $receipt->receipt_id,
                "receipt_date" => $receipt->receipt_date,
                "receipt_worker_id" => $receipt->receipt_worker_id,
                "receipt_client_id" => $receipt->receipt_client_id
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

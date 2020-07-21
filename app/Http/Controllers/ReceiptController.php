<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Receipt;
use App\Service;
use App\Client;
use View;
use Auth;
use Illuminate\Support\Facades\DB;

class ReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View::make('receipts.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fetchReceipts()
    {
        $receipts=Receipt::latest()->get();
        
        return response()->json([
            "receipts" => $receipts
        ], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fetchLastReceiptId(Request $request)
    {
        $last_receipt=DB::table('receipts')->latest('receipt_id')->first();
        
        return response()->json([
            "last_receipt_id" => $last_receipt->receipt_id
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
            $receipt=new Receipt;
            $receipt->receipt_worker_id=Auth::id();
            $receipt->receipt_client_id=$request->receipt_client_id;
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

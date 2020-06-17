<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InventoryExitProduct;
use App\InventoryExit;
use App\Product;

class InventoryExitProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $inventory_exits_products = InventoryExitProduct::all();
            return response()->json([
                "inventory_exits_products" => $inventory_exits_products
            ], 200);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            $data=array();            
            $inventory_exit_id=InventoryExit::all()->last()->inventory_exit_id;
            $product = new Product();

            foreach($request->products_exit_detail as $product_detail){               
                $products_detail_decoded = json_decode(json_encode($product_detail));

                $data[] = [
                    'inventory_exit_id' => $inventory_exit_id,
                    'product_id' => $products_detail_decoded->product_id,
                    'product_exit_amount' => $products_detail_decoded->product_exit_amount,
                    'product_exit_justification' => $products_detail_decoded->product_exit_justification
                ];

                $product=Product::find($products_detail_decoded->product_id);
                $product->product_stock = $product->product_stock - $products_detail_decoded->product_exit_amount;
                $product->save();
            }

            InventoryExitProduct::insert($data);

            return response()->json([
                "message" => "Detalles de salida de inventario agregados correctamente.",
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

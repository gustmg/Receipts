<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InventoryEntryProduct;
use App\InventoryEntry;
use App\Product;
use \NumberFormatter;

class InventoryEntryProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $inventory_entries_products = InventoryEntryProduct::all();
            return response()->json([
                "inventory_entries_products" => $inventory_entries_products
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
            $currency = 'USD';
            $formatter =new NumberFormatter( 'en_US', NumberFormatter::CURRENCY );
            $inventory_entry_id=InventoryEntry::all()->last()->inventory_entry_id;
            $product = new Product();

            foreach($request->products_entry_detail as $product_detail){               
                $products_detail_decoded = json_decode(json_encode($product_detail));
                $float_unit_cost = $formatter->parseCurrency($products_detail_decoded->product_unit_cost, $currency);
                $data[] = [
                    'inventory_entry_id' => $inventory_entry_id,
                    'product_id' => $products_detail_decoded->product_id,
                    'product_entry_amount' => $products_detail_decoded->product_amount,
                    'product_unit_cost' => $products_detail_decoded->product_unit_cost,
                ];

                $product=Product::find($products_detail_decoded->product_id);
                $product->product_stock = $product->product_stock + $products_detail_decoded->product_amount;
                if($product->product_cost == 0){
                    $product->product_cost = $products_detail_decoded->product_unit_cost; 
                }
                else{
                    $product->product_cost = ($product->product_cost + $products_detail_decoded->product_unit_cost) / 2; 
                }
                $product->save();
            }

            InventoryEntryProduct::insert($data);

            return response()->json([
                "message" => "Detalles de entrada de inventario agregados correctamente.",
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

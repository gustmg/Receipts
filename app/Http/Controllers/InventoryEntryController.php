<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use App\InventoryEntry;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use \NumberFormatter;

class InventoryEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $inventory_entries = InventoryEntry::where('inventory_entry_warehouse_id', 1)->orderBy('inventory_entry_id', 'DESC')->get();
            return response()->json([
                "inventory_entries" => $inventory_entries
            ], 200);
        }

        return View::make('inventory_entries.index');
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
            $float_total_cost=str_replace(',','', $request->inventory_entry_total_cost);

            $inventory_entry=new InventoryEntry;
            $inventory_entry->inventory_entry_created_at=Carbon::now();
            $inventory_entry->inventory_entry_total_cost=$float_total_cost;
            $inventory_entry->inventory_entry_worker_id=Auth::id();
            $inventory_entry->inventory_entry_warehouse_id=1;
            
            // var_dump($float_total_cost);
            $inventory_entry->save();

            return response()->json([
                "message" => "Producto creado correctamente.",
                "inventory_entry" => $inventory_entry
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
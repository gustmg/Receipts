<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use App\InventoryExit;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use \NumberFormatter;

class InventoryExitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $inventory_exits = InventoryExit::where('inventory_exit_warehouse_id', 1)->orderBy('inventory_exit_id', 'DESC')->get();
            return response()->json([
                "inventory_exits" => $inventory_exits
            ], 200);
        }

        return View::make('inventory_exits.index');
    }

    public function fetchTodayInventoryExits()
    {
        $inventory_exits=InventoryExit::whereDate('inventory_exit_created_at',Carbon::today())->get();
        
        return response()->json([
            "inventory_exits" => $inventory_exits
        ], 200);
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
            $inventory_exit=new InventoryExit;
            $inventory_exit->inventory_exit_created_at=Carbon::now();
            $inventory_exit->inventory_exit_worker_id=Auth::id();
            $inventory_exit->inventory_exit_warehouse_id=1;
            $inventory_exit->save();

            return response()->json([
                "message" => "Salida de inventario creado correctamente.",
                "inventory_exit" => $inventory_exit
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use View;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $services=DB::table('services')->orderBy('service_name','asc')->get();

        return View::make('services.index',['services'=>$services]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fetchServices(Request $request)
    {
        $services=DB::table('services')->orderBy('service_name','asc')->get();
        
        return response()->json([
            "services" => $services
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
            $validatedData = $request->validate([
                'service_name' => 'required|max:255',
                'service_description' => 'required|max:255',
            ]);

            $service=new Service;
            $service->service_name=$request->service_name;
            $service->service_code=$request->service_code;
            $service->service_description=$request->service_description;
            $service->service_cost=0;
            $service->service_base_price_percentage=0;
            $service->service_retail_price_percentage=0;
            $service->service_wholesale_price_percentage=0;
            $service->service_stock=0;
            $service->save();

            return response()->json([
                "message" => "Servicio creado correctamente.",
                "service" => $service
            ],200);
        }
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
        if($request->ajax()){
            $validatedData = $request->validate([
                'service_name' => 'required|max:255',
            ]);

            $service=Service::find($id);
            $service->service_name=$request->service_name;
            $service->service_code=$request->service_code;
            $service->service_description=$request->service_description;
            
            if(isset($request->service_cost)){
                $service->service_cost=$request->service_cost;
            }
            else{
                $service->service_cost=$service->service_cost;
            }
            
            if(isset($request->service_base_price_percentage)){
                $service->service_base_price_percentage=$request->service_base_price_percentage;
            }
            else{
                $service->service_base_price_percentage=0;
            }

            if(isset($request->service_retail_price_percentage)){
                $service->service_retail_price_percentage=$request->service_retail_price_percentage;
            }
            else{
                $service->service_retail_price_percentage=0;
            }

            if(isset($request->service_wholesale_price_percentage)){
                $service->service_wholesale_price_percentage=$request->service_wholesale_price_percentage;
            }
            else{
                $service->service_wholesale_price_percentage=0;
            }
            $service->save();

            return response()->json([
                "message" => "Serviceo actualizado correctamente.",
                "service" => $service
            ],200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service=Service::find($id);
        $service->delete();

        return response()->json([
            "message" => "Servicio eliminado correctamente."
        ],200);
    }
}

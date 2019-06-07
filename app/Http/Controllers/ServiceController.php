<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use View;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services=Service::all();
        return View::make('services.index',['services'=>$services]);
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
            $service->service_description=$request->service_description;
            $service->save();

            return response()->json([
                "message" => "Servicio creado correctamente.",
                "service_id" => $service->service_id
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
                'service_description' => 'required|max:255',
            ]);

            $service=Service::find($id);
            $service->service_name=$request->service_name;
            $service->service_description=$request->service_description;
            $service->save();

            return response()->json([
                "message" => "Servicio actualizado correctamente."
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

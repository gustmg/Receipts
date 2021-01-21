<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Device;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function fetch()
    {
        $devices=Device::all();
        foreach($devices as $key=>$device){
            $device->service_status()->attach(1, ['device_service_commentary' => '']);
        }
    }

    public function fetchDevices() {
        $devices = Device::all();

        return response()->json([
            "devices" => $devices
        ],200);
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
            $device=new Device;
            $device->device_name=$request->device_name;
            $device->device_serial_number=$request->device_serial_number;
            $device->device_trouble_description=$request->device_trouble_description;
            $device->device_commentary=$request->device_commentary;
            $device->device_receipt_id=$request->device_receipt_id;
            $device->save();

            $device->service_status()->attach(1, ['device_service_commentary' => $request->device_trouble_description]);

            return response()->json([
                "message" => "Equipo registrado correctamente.",
                "device_id" => $device->device_id
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
        $device=Device::find($id);
        $device->service_status()->attach($request->service_status_id, ['device_service_commentary' => $request->service_status_commentary]);

        return response()->json([
            "message" => "Dispositivo actualizado correctamente.",
        ],200);
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

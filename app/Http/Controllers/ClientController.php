<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use View;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients=Client::all(); 
        return View::make('clients.index',['clients'=>$clients]);
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
                'client_name' => 'required|max:255',
            ]);

            $client=new Client;
            $client->client_name=$request->client_name;
            $client->client_phone=$request->client_phone;
            $client->client_email=$request->client_email;
            $client->save();

            return response()->json([
                "message" => "Cliente creado correctamente.",
                "client_id" => $client->client_id
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
                'client_name' => 'required|max:255',
            ]);

            $client=Client::find($id);
            $client->client_name=$request->client_name;
            $client->client_phone=$request->client_phone;
            $client->client_email=$request->client_email;
            $client->save();

            return response()->json([
                "message" => "Cliente actualizado correctamente."
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
        $client=Client::find($id);
        $client->delete();

        return response()->json([
            "message" => "Cliente eliminado correctamente."
        ],200);
    }
}

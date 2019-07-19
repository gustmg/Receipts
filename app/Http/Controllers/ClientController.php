<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use View;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;


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
        $connector = new WindowsPrintConnector("EC-PM-80250");
        $printer = new Printer($connector);
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $img = EscposImage::load("css/tec.png");
        $printer -> graphics($img);
        $printer -> setTextSize(2,2);
        $printer -> text("TECTRO\n");
        $printer -> feed(1);
        $printer -> setTextSize(1,1);
        $printer -> text("CENTRO DE SOLUCIONES TECNOLOGICAS\n");
        $printer -> feed(1);
        $printer -> text("Calle Encino 1-A, Col. Viveros Santa Cruz\nPuebla, Pue.\n");
        $printer -> feed(1);
        $printer -> text("NOTA DE VENTA #0001\n");
        $printer -> feed(1);
        $printer -> setJustification(Printer::JUSTIFY_LEFT);
        $printer -> text("Fecha: Julio 19, 2019 \n");
        $printer -> text("Cliente: Gustavo Mitre Gallardo\n");
        $printer -> text("No. de cliente: 0001\n");
        $printer -> feed(1);
        $printer -> text("________________________________________________\n");
        $printer -> text("CANT   DESCRIPCION         PU           IMPORTE\n");
        $printer -> text("_______________________________________________\n");
        $printer -> text("  1    SSD120GBAD      $18,250.00    $18,250.00\n");
        $printer -> text("SSD Adata 120GB SATA 3 500MB/s \n");
        $printer -> text("  10    SSD120GBAD      $250.00    $250.00\n");
        $printer -> text("SSD Adata 120GB SATA 3 500MB/s \n");
        $printer -> text("_______________________________________________\n");
        $printer -> setJustification(Printer::JUSTIFY_RIGHT);
        $printer -> text("Subtotal: $18,250.00 \n");
        $printer -> text("IVA: $0.00 \n");
        $printer -> text("Total: $18,250.00 \n");
        $printer -> text("_______________________________________________\n");
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> text("CORREO:\ntectrotecnologico@gmail.com\nventas@tectro.com.mx\n");
        $printer -> feed(1);
        $printer -> text("Tel: 222 7 85 30 12    Whatsapp: 222 9 08 78 11\n");
        $printer -> feed(1);
        $printer -> text("¡GRACIAS POR SU PREFERENCIA!\n");
        $printer -> text("WWW.TECTRO.COM.MX\n");
        $printer -> feed(1);
        $printer -> cut();
        $printer -> close();
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

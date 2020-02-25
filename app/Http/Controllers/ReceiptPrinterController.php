<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Receipt;
use App\Device;
use App\Accessory;

use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;

class ReceiptPrinterController extends Controller
{
    function addSpacesRight($string, $valid_string_length) {
        if (strlen($string) < $valid_string_length) {
            $spaces = $valid_string_length - strlen($string);
            for ($index1 = 1; $index1 <= $spaces; $index1++) {
                $string = $string . ' ';
            }
        }
        return $string;
    }

    function addSpacesLeft($string, $valid_string_length) {
        if (strlen($string) < $valid_string_length) {
            $spaces = $valid_string_length - strlen($string);
            for ($index1 = 1; $index1 <= $spaces; $index1++) {
                $string = ' '.$string;
            }
        }
        return $string;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            $receipt=Receipt::find($request->receipt_id);
            $subtotal_amount=0;
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
            if($request->reprint){
                $printer -> text("TICKET REIMPRESO\n");
            }
            $printer -> text("RECEPCION DE EQUIPO #".$receipt->receipt_id."\n");
            $printer -> feed(1);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text("Fecha:".$receipt->created_at."\n");
            $printer -> text("Cliente: ".$receipt->client->client_name."\n");
            $printer -> text("Teléfono: ".$receipt->client->client_phone."\n");
            $printer -> text("________________________________________________\n");
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> text("LISTA DE EQUIPOS\n");
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            foreach ($receipt->devices as $key => $device) {
                $printer -> text("________________________________________________\n");
                $printer -> text("EQUIPO: ".$device->device_name."\n");
                $printer -> text("NO. SERIE: ".$device->device_serial_number."\n");
                $printer -> text("FALLA REPORTADA O SERVICIO A REALIZAR: \n");
                $printer -> text("- ".$device->device_trouble_description."\n");
                $printer -> text("ACCESORIOS: \n");
                if(count($device->accessories) > 0){
                    foreach ($device->accessories as $key => $accessory) {
                        if($accessory->accessory_serial_number){
                            $printer -> text("- ".$accessory->accessory_name." (".$accessory->accessory_serial_number.")\n");
                        }
                        else{
                            $printer -> text("- ".$accessory->accessory_name." (S/N)\n");
                        }
                    }
                }
                else{
                    $printer -> text("- Ninguno\n");
                }
            }
            $printer -> text("________________________________________________\n");
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> text("TERMINOS Y CONDICIONES:\n");
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            if($request->reprint){
                $printer -> text("* El cliente acepta que recibe su equipo a satisfacción.\n\n\n\n\n\n");
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> text("____________________________________\n");
                $printer -> text("NOMBRE, FECHA Y FIRMA DEL CLIENTE\n");
                $printer -> setJustification(Printer::JUSTIFY_LEFT);
            }
            else{
                $printer -> text("* En equipos mojados, software y daños en electrónica no hay garantía debido a que el equipo se puede apagar o no responder correctamente\n");
                $printer -> text("* Después de 20 días la empresa no se hace responsable por equipos olvidados ni se aceptan reclamaciones de ningún tipo.\n");
                $printer -> text("* El cliente acepta los términos y condiciones especificadas en esta orden de recepción de equipo.\n");
            }
            $printer -> text("________________________________________________\n");
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> text("CORREO:\ntectrotecnologico@gmail.com\nventas@tectro.com.mx\n");
            $printer -> feed(1);
            $printer -> text("Tel: 222 7 85 30 12    Whatsapp: 222 9 08 78 11\n");
            $printer -> feed(1);
            $printer -> text("WWW.TECTRO.COM.MX\n");
            $printer -> feed(1);
            $printer -> cut();
            $printer -> close();
            
            return response()->json([
                "message" => "Impresión realizada correctamente.",
                "receipt" => $receipt,
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Sale;
use App\SaleProduct;
use App\ServiceProduct;
use App\Service;
use App\Product;

use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;

class PrinterController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->ajax()){
            $sale=Sale::find($request->sale_id);
            $total_amount=0;
            $connector = new WindowsPrintConnector("EC-PM-80250");
            $printer = new Printer($connector);
<<<<<<< HEAD
            for ($i=0; $i < 2; $i++) { 
                $total_amount=0;
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
                $printer -> text("NOTA DE VENTA #".$sale->sale_id."\n");
                $printer -> feed(1);
                $printer -> setJustification(Printer::JUSTIFY_LEFT);
                $printer -> text("Fecha:".$sale->created_at."\n");
                $printer -> text("Cliente: ".$sale->client->client_name."\n");
                $printer -> text("Forma de pago: ".$sale->payment_form->payment_form_name."\n");
                $printer -> text("________________________________________________\n");
                $printer -> text("CANT    DESCRIPCION           PU         IMPORTE");
                $printer -> text("________________________________________________\n");
                foreach ($sale->products as $key => $product) {
                    $product_import=$product->pivot->product_unit_price*$product->pivot->product_quantity;
                    $total_amount=$total_amount+$product_import;
                    $product_import=number_format((float)$product_import, 2, '.', ',');
                    $printer -> text(PrinterController::addSpacesRight($product->pivot->product_quantity,8)
                                    .PrinterController::addSpacesRight($product->product_code,14)
                                    .PrinterController::addSpacesLeft("$".number_format($product->pivot->product_unit_price, 2, '.', ','),14)
                                    .PrinterController::addSpacesLeft("$".$product_import, 12));
                    $printer -> text($product->product_description."\n");
                    $printer -> feed(1);
                }
                foreach ($sale->services as $key => $service) {
                    $service_import=$service->pivot->service_unit_price*$service->pivot->service_quantity;
                    $total_amount=$total_amount+$service_import;
                    $service_import=number_format((float)$service_import, 2, '.', ',');
                    $printer -> text(PrinterController::addSpacesRight($service->pivot->service_quantity,8)
                    .PrinterController::addSpacesRight($service->service_code,14)
                    .PrinterController::addSpacesLeft("$".number_format($service->pivot->service_unit_price, 2, '.',','),14)
                    .PrinterController::addSpacesLeft("$".$service_import, 12));
                    $printer -> text($service->service_description."\n");
                    $printer -> feed(1);
                }
                $printer -> text("________________________________________________\n");
                $printer -> setJustification(Printer::JUSTIFY_RIGHT);
                $iva=$total_amount*0.16;
                $total_amount=number_format((float)$total_amount, 2, '.', ',');
                if($request->tax){
                    $printer -> text("Subtotal: $".$total_amount."\n");
                    $iva=number_format((float)$iva, 2, '.', ',');
                    $printer -> text("IVA: $".$iva."\n");
                    $printer -> text("Total: $".($total_amount+$iva)."\n");    
                }
                else{
                    $printer -> text("Total: $".$total_amount."\n");
                }
                $printer -> text("________________________________________________\n");
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> text("CORREO:\ntectrotecnologico@gmail.com\nventas@tectro.com.mx\n");
                $printer -> feed(1);
                $printer -> text("Tel: 222 7 85 30 12    Whatsapp: 222 9 08 78 11\n");
                $printer -> feed(1);
                $printer -> text("¡GRACIAS POR SU PREFERENCIA!\n");
                $printer -> text("WWW.TECTRO.COM.MX\n");
                $printer -> feed(1);
                $printer -> cut();
=======
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
            $printer -> text("NOTA DE VENTA #".$sale->sale_id."\n");
            $printer -> feed(1);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text("Fecha:".$sale->created_at."\n");
            $printer -> text("Cliente: ".$sale->client->client_name."\n");
            $printer -> text("No. de cliente: ".$sale->client->client_id."\n");
            $printer -> text("________________________________________________\n");
            $printer -> text("CANT    DESCRIPCION           PU         IMPORTE \n");
            $printer -> text("________________________________________________\n");
            foreach ($sale->products as $key => $product) {
                $product_import=$product->pivot->product_unit_price*$product->pivot->product_quantity;
                $printer -> text(PrinterController::addSpacesRight($product->pivot->product_quantity,8)
                                .PrinterController::addSpacesRight($product->product_code,14)
                                .PrinterController::addSpacesLeft("$".$product->pivot->product_unit_price,14)
                                .PrinterController::addSpacesLeft("$".$product_import, 12));
                $printer -> text($product->product_description."\n");
                $printer -> text("_______________________________________________\n");
                $total_amount=$total_amount+$product_import;
>>>>>>> parent of a4f0389... Update 1.1
            }
            foreach ($sale->services as $key => $service) {
                $service_import=$service->pivot->service_unit_price*$service->pivot->service_quantity;
                $printer -> text(PrinterController::addSpacesRight($service->pivot->service_quantity,8)
                                .PrinterController::addSpacesRight($service->service_code,14)
                                .PrinterController::addSpacesLeft("$".$service->pivot->service_unit_price,14)
                                .PrinterController::addSpacesLeft("$".$service_import, 12));
                $printer -> text($service->service_description."\n");
                $printer -> text("_______________________________________________\n");
                $total_amount=$total_amount+$service_import;
            }
            $printer -> setJustification(Printer::JUSTIFY_RIGHT);
            if($request->tax){
                $printer -> text("Subtotal: $".$total_amount." \n");
                $printer -> text("IVA: $".($total_amount*0.16)." \n");
                $printer -> text("Total: $".($total_amount+($total_amount*0.16))."\n");    
            }
            else{
                $printer -> text("Total: $".$total_amount." \n");
            }
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
            //IMPRIME EJEMPLO
            // var_dump("NOTA DE VENTA #".$sale->sale_id."\n");
            // var_dump("Fecha:".$sale->created_at."\n");
            // var_dump("Cliente: ".$sale->client->client_name."\n");
            // var_dump("No. de cliente: ".$sale->client->client_id."\n");
            // foreach ($sale->products as $key => $product) {
            //     $product_import=$product->pivot->product_unit_price*$product->pivot->product_quantity;
            //     var_dump('CANTIDAD:'.$product->pivot->product_quantity
            //             .' CODIGO:'.$product->product_code
            //             .' PU:'.$product->pivot->product_unit_price
            //             .' IMPORTE:'.$product_import);
            //     $total_amount=$total_amount+$product_import;
            // }
            // if($request->tax){
            //     var_dump("Subtotal: $".$total_amount." \n");
            //     var_dump("IVA: $".($total_amount*0.16)." \n");
            //     var_dump("Total: $".($total_amount+($total_amount*0.16))."\n");  
            // }
            // else{
            //     var_dump("Total: $".$total_amount." \n");
            // }
            return response()->json([
                "message" => "Cliente creado correctamente.",
                "sale" => $sale,
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

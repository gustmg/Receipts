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
            $subtotal_amount=0;
            $connector = new WindowsPrintConnector("Tectro");
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
            $printer -> text("ESTE TICKET NO ES UN COMPROBANTE FISCAL\n");
            $printer -> feed(1);
            $printer -> text("NOTA DE VENTA #".$sale->sale_id."\n");
            $printer -> feed(1);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text("Fecha:".$sale->created_at."\n");
            $printer -> text("Cliente: ".$sale->client->client_name."\n");
            $printer -> text("Forma de pago: ".$sale->payment_form->payment_form_name."\n");
            $printer -> text("________________________________________________\n");
            $printer -> text("CANT    DESCRIPCION           PU         IMPORTE\n");
            $printer -> text("________________________________________________\n");
            foreach ($sale->products as $key => $product) {
                $product_import=$product->pivot->product_unit_price*$product->pivot->product_quantity;
                $product_import_formated=number_format($product_import,2,'.',',');
                $printer -> text(PrinterController::addSpacesRight($product->pivot->product_quantity,8)
                                .PrinterController::addSpacesRight($product->product_code,14)
                                .PrinterController::addSpacesLeft("$".$product->pivot->product_unit_price,14)
                                .PrinterController::addSpacesLeft("$".$product_import_formated, 12));
                $printer -> text($product->product_description."\n");
                $printer -> text("________________________________________________\n");
                $subtotal_amount=$subtotal_amount+$product_import;
            }
            foreach ($sale->services as $key => $service) {
                $service_import=$service->pivot->service_unit_price*$service->pivot->service_quantity;
                $service_import_formated=number_format($service_import,2,'.',',');
                $printer -> text(PrinterController::addSpacesRight($service->pivot->service_quantity,8)
                                .PrinterController::addSpacesRight($service->service_code,14)
                                .PrinterController::addSpacesLeft("$".$service->pivot->service_unit_price,14)
                                .PrinterController::addSpacesLeft("$".$service_import_formated, 12));
                $printer -> text($service->service_description."\n");
                $printer -> text("________________________________________________\n");
                $subtotal_amount=$subtotal_amount+$service_import;
            }
            $printer -> setJustification(Printer::JUSTIFY_RIGHT);
            $subtotal_amount_formated=number_format($subtotal_amount,2,'.',',');
            if($sale->sale_payment_form_id==2){
                if($request->tax){
                    if($subtotal_amount + ($subtotal_amount*0.16) >= 1000){
                        $tax_formated=number_format(($subtotal_amount*0.16),2,'.',',');
                        $credit_card_charge_formated=number_format($request->credit_card_charge,2,'.',',');
                        $total_amount_formated=number_format($subtotal_amount+($subtotal_amount*0.16)+$request->credit_card_charge,2,'.',',');
                        $printer -> text("Subtotal: $".$subtotal_amount_formated."\n");
                        $printer -> text("IVA: $".$tax_formated."\n");
                        $printer -> text("Comisión Tarjeta: $".$credit_card_charge_formated."\n");
                        $printer -> text("Total: $".$total_amount_formated."\n");
                    }
                    else{
                        $tax_formated=number_format(($subtotal_amount*0.16),2,'.',',');
                        $total_amount_formated=number_format($subtotal_amount+($subtotal_amount*0.16),2,'.',',');
                        $printer -> text("Subtotal: $".$subtotal_amount_formated."\n");
                        $printer -> text("IVA: $".$tax_formated."\n");
                        $printer -> text("Total: $".$total_amount_formated."\n");
                    }
                }
                else{
                    if($subtotal_amount >= 1000){
                        $credit_card_charge_formated=number_format($request->credit_card_charge,2,'.',',');
                        $total_amount_formated=number_format($subtotal_amount+$request->credit_card_charge,2,'.',',');
                        $printer -> text("Subtotal: $".$subtotal_amount_formated."\n");
                        $printer -> text("Comisión Tarjeta: $".$credit_card_charge_formated."\n");
                        $printer -> text("Total: $".$total_amount_formated."\n");
                    }
                    else{
                        $printer -> text("Total: $".$subtotal_amount_formated."\n");
                    }
                }
            }
            else{
                if($request->tax){
                    $tax_formated=number_format(($subtotal_amount*0.16),2,'.',',');
                    $total_amount_formated=number_format($subtotal_amount+($subtotal_amount*0.16),2,'.',',');
                    $printer -> text("Subtotal: $".$subtotal_amount_formated."\n");
                    $printer -> text("IVA: $".$tax_formated."\n");
                    $printer -> text("Total: $".$total_amount_formated."\n");
                }
                else{
                    $printer -> text("Total: $".$subtotal_amount_formated."\n");
                }
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
            $printer -> close();
            
            return response()->json([
                "message" => "Impresión realizada correctamente.",
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
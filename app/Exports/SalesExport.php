<?php

namespace App\Exports;

use App\Sale;
use App\SaleProduct;
use App\SaleService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;

class SalesExport implements WithMultipleSheets
{

    public function sheets(): array
    {
        $sheets=[];

        for($x=1; $x<=3; $x++) {
            switch ($x) {
                case 1:
                    $sheets[]=new SalesGeneralSheet();
                    break;
                case 2:
                    $sheets[]=new SaleProductsSheet();
                    break;
                case 3:
                    $sheets[]=new SaleServicesSheet();
                    break;
            }
        }

        return $sheets;
    }
}

class SalesGeneralSheet implements FromCollection, WithHeadings, WithTitle
{
    public function title(): string
    {
        return 'Ventas';
    }

    public function headings(): array
    {
        return ['Folio de venta', 'Id trabajador', 'Id cliente', 'Forma de pago', 'Venta facturada', 'Total', 'Fecha'];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Sale::all();
    }
}

class SaleProductsSheet implements FromCollection, WithHeadings, WithTitle
{
    public function title(): string
    {
        return 'Venta productos';
    }

    public function headings(): array
    {
        return ['Folio venta', 'Id producto', 'Cantidad', 'Precio unitario'];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return SaleProduct::all();
    }
}

class SaleServicesSheet implements FromCollection, WithHeadings, WithTitle
{
    public function title(): string
    {
        return 'Venta servicios';
    }

    public function headings(): array
    {
        return ['Folio venta', 'Id servicio', 'Cantidad', 'Precio unitario'];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return SaleService::all();
    }
}

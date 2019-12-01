<?php

namespace App\Exports;

use App\Orders;
use App\Products;
use App\Payments;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Orders::all();
    }
}

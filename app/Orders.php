<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Payments;
use App\Products;
class Orders extends Model
{
    protected $fillable = [
        'PaymentsId','ProductsId', 'Quantity'
    ];
    protected $primaryKey = 'OrdersId';
    public function payments(){
        return $this->hasOne('App\Products');
    }
    public function products(){
        return $this->hasOne('App\payments');
    }
}

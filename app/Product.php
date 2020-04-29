<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'quantity',
        'price',
        'unit_price',
        'mayor_price',
        'purchase_price',
    ];
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function sales()
    {
        return $this->hasMany('App\SaleItem');
    }
    public function purchases()
    {
        return $this->hasMany('App\PurchaseItem');
    }
}

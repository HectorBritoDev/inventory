<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'code',
        'name',
        'quantity',
        'price',
        'unit_price',
        'mayor_price',
        'purchase_price',
        'apply_mayoritary_price_since'
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

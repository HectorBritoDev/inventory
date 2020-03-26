<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['category_id', 'name', 'quantity', 'price', 'unit_price', 'mayor_price', 'purchase_price'];
}

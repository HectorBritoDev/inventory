<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    protected $fillable = ['purchase_id', 'price', 'quantity', 'name'];

    public function purchase()
    {
        return $this->belongsTo('App\Purchase');
    }

    // public function product()
    // {
    //     return $this->belongsTo('App\Product');
    // }
}

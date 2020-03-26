<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    protected $fillable = ['name', 'code', 'price', 'quantity'];
    public function purchase()
    {
        return $this->belongsTo('App\Purchase');
    }
}

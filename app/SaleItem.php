<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    protected $fillable = ['name', 'code', 'price', 'quantity'];

    public function sale()
    {
        return $this->belongsTo('App\Sale');
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = ['message', 'total_price'];

    public function items()
    {
        return $this->hasMany('App\SaleItem');
    }
}

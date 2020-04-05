<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = ['message', 'total_price'];

    public function items()
    {
        return $this->hasMany('App\PurchaseItem');
    }

    // public function products()
    // {
    //     return $this->hasManyThrough(
    //         'App\Product', //Target model
    //         'App\PurchaseItem', //Through model
    //         'product_id', // wich field should i look on Through model?
    //         'id', // wich field should i look on Target model?
    //         'id', // local id on Though model
    //         'id' //local key on Target model

    //     );
    // }
}

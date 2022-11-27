<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'order_id';

    public function product()
    {
        return $this->belongsTo('App\Model\Product', 'product_id');
    }
}

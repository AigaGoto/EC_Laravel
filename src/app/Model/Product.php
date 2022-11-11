<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'product_id';

    protected $fillable = [
        'product_name', 
        'product_image_file', 
        'product_description', 
        'product_price', 
    ];

    public function rates()
    {
        return $this->hasMany('App\Model\Rate', 'product_id');
    }

    public function reviews()
    {
        return $this->hasMany('App\Model\Review', 'product_id');
    }
}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'review_content',
        'user_id',
        'product_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\Model\User', 'review_id');
        // return $this->hasOne('App\Model\User', 'user_id');
    }
}

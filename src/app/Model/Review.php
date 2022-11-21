<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Tag;

class Review extends Model
{
    protected $primaryKey = 'review_id';

    protected $fillable = [
        'review_content',
        'user_id',
        'product_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\Model\User', 'user_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Model\Product', 'product_id');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Model\Tag', 'review2tags', 'review_id', 'tag_id');
    }
}

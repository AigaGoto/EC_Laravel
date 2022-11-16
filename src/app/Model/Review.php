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
        return $this->belongsTo('App\Model\User', 'review_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'review2tags');
    }
}

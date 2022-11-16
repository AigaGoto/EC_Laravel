<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Review;

class Tag extends Model
{
    protected $primaryKey = 'tag_id';

    protected $fillable = [
        'tag_name',
    ];

    public $timestamps = false;

    public function reviews()
    {
        return $this->belongsToMany(Review::class, 'review2tags', 'tag_id', 'review_id');
    }
}

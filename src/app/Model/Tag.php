<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $primaryKey = 'tag_id';

    protected $fillable = [
        'tag_name',
    ];

    public $timestamps = false;

    public function reviews()
    {
        return $this->belongsToMany('App\Model\Review', 'review2tags', 'tag_id', 'review_id');
    }
}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $fillable = [
        'rate_type',
        'user_id',
        'product_id',
    ];

    /**
     * Get the user that owns the Rate
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Model\User');
    }
}

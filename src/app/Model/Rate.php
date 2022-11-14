<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $primaryKey = 'rate_id';

    protected $fillable = [
        'rate_type',
        'user_id',
        'product_id',
    ];

    const TYPE = [
        1 => '高評価',
        2 => '低評価',
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

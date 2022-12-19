<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    protected $primaryKey = 'system_name';

    protected $fillable = [
        'system_name', 
        'system_value', 
    ];

    const CREATED_AT = null;
    const UPDATED_AT = null;
}

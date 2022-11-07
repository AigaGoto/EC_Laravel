<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Rate;
use Faker\Generator as Faker;

$factory->define(Rate::class, function (Faker $faker) {
    return [
        
        'rate_type' => $faker->numberBetween($min=1, $max=2),
        'created_at' => $faker->date('Y-m-d H:i:s', 'now'),
        'updated_at' => $faker->date('Y-m-d H:i:s', 'now'),
        'user_id' => factory(App\Model\User::class),
        'product_id' => factory(App\Model\Product::class),

    ];
});

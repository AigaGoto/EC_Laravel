<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        "user_id" => 33,
        "product_id" => factory(App\Model\Product::class),
        'created_at' => $faker->date('Y-m-d H:i:s', 'now'),
        'updated_at' => $faker->date('Y-m-d H:i:s', 'now'),
    ];
});

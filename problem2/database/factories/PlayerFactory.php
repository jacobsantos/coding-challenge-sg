<?php

use Faker\Generator as Faker;

$factory->define(App\Player::class, function (Faker $faker) {
    return [
        'player_id' => $faker->unique(true)->numberBetween(1000),
		'name' => $faker->name,
		'credits' => $faker->randomFloat(2, -1000, 1000),
		'lifetime_spins' => $faker->numberBetween(0, 25),
		'salt_value' => hash_hmac('sha256', random_bytes(32), random_bytes(16)),
    ];
});

<?php

use Faker\Generator as Faker;

$factory->define(App\Player::class, function (Faker $faker) {
    return [
        'player_id' => $faker->unique()->randomDigitNotNull,
		'name' => $faker->unique()->name,
		'credits' => $faker->randomFloat(2),
		'lifetime_spins' => $faker->numberBetween(0, 25),
		'salt_value' => password_hash(random_bytes(32), PASSWORD_ARGON2I),
    ];
});

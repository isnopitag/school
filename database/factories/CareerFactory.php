<?php

use Faker\Generator as Faker;

$factory->define(\App\Career::class, function (Faker $faker) {
    return [
        'career' => $faker->company,
        'profile_image' =>$faker->imageUrl(500,500),
        'cover_image' =>$faker->imageUrl(1000,500)
    ];
});

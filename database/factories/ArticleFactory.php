<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Article;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    return [
        // define fake data
        'title' => $faker->text(50),
        'body' => $faker->text(200)
    ];
});

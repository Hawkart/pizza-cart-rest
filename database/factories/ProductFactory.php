<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'category_id'   =>  function () {
            return Category::inRandomOrder()->first()->id;
        },
        'title' => $faker->word,
        'image' => $faker->imageUrl(640, 480, 'food'),
        'description' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'in_stock' => $faker->numberBetween($min = 100, $max = 900),
        'price' => $faker->numberBetween($min = 100, $max = 900),
        'currency' => config("currency.default"),
    ];
});

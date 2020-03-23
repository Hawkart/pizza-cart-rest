<?php

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::truncate();

        $categories = [
            'Pizza', 'Pasta'
        ];

        $pizzas = [
            [
                'title' => 'Hawaiian',
                'description' => 'Our take on the classic Hawaiian Pizza: ham, pineapple and bacon bits',
                'price' => 315,
                "image" => ''
            ],
            [
                'title' => 'New York Classic',
                'description' => 'All time favorite topping: Pepperoni!',
                'price' => 315,
                "image" => ''
            ],
            [
                'title' => '#4 Cheese',
                'description' => 'Cheese heaven! Mozzarella, cheddar, romano and feta.',
                'price' => 420,
                "image" => ''
            ],
            [
                'title' => 'Roasted Garlic & Shrimp',
                'description' => 'Gourmet style pizza with shrimp, onions, roasted garlic in wine-butter sauce .',
                'price' => 420,
                "image" => ''
            ],
            [
                'title' => 'New York`s Finest',
                'description' => 'Our best seller! Combination of meats and fresh vegetables.',
                'price' => 735,
                "image" => ''
            ]
        ];

        $pasta = [
            [
                'title' => 'Chicken Alfredo Pasta',
                'description' => 'Creamy pasta with chicken strips, olives and basil chiffonade.',
                'price' => 380,
                "image" => ''
            ],
            [
                'title' => 'Charlie Chan Pasta',
                'description' => 'Chicken strips, shiitake mushrooms and roasted peanuts in a spicy oriental sauce. Uniquely our own!',
                'price' => 400,
                "image" => ''
            ]
        ];

        foreach($categories as $category)
        {
            factory(Category::class)->create();
        }
    }
}

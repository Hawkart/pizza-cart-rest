<?php

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    protected $categories = [
        'Pizza' => [
            [
                'title' => 'Hawaiian',
                'description' => 'Our take on the classic Hawaiian Pizza: ham, pineapple and bacon bits',
                'price' => 315,
                "image" =>'hawaiian.jpg'
            ],
            [
                'title' => 'New York Classic',
                'description' => 'All time favorite topping: Pepperoni!',
                'price' => 315,
                "image" => 'NYClassic.jpg'
            ],
            [
                'title' => '#4 Cheese',
                'description' => 'Cheese heaven! Mozzarella, cheddar, romano and feta.',
                'price' => 420,
                "image" => '4cheese.jpg'
            ],
            [
                'title' => 'Roasted Garlic & Shrimp',
                'description' => 'Gourmet style pizza with shrimp, onions, roasted garlic in wine-butter sauce .',
                'price' => 420,
                "image" => '1578533750_thumb.jpg'
            ],
            [
                'title' => 'New York`s Finest',
                'description' => 'Our best seller! Combination of meats and fresh vegetables.',
                'price' => 735,
                "image" => 'NYF.jpg'
            ],

            [
                'title' => 'Hawaiian (Big)',
                'description' => 'Our take on the classic Hawaiian Pizza: ham, pineapple and bacon bits',
                'price' => 805,
                "image" =>'hawaiian.jpg'
            ],
            [
                'title' => 'New York Classic (Big)',
                'description' => 'All time favorite topping: Pepperoni!',
                'price' => 815,
                "image" => 'NYClassic.jpg'
            ],
            [
                'title' => '#4 Cheese (Big)',
                'description' => 'Cheese heaven! Mozzarella, cheddar, romano and feta.',
                'price' => 920,
                "image" => '4cheese.jpg'
            ],
            [
                'title' => 'Roasted Garlic & Shrimp (Big)',
                'description' => 'Gourmet style pizza with shrimp, onions, roasted garlic in wine-butter sauce .',
                'price' => 1150,
                "image" => '1578533750_thumb.jpg'
            ],
            [
                'title' => 'New York`s Finest (Big)',
                'description' => 'Our best seller! Combination of meats and fresh vegetables.',
                'price' => 1435,
                "image" => 'NYF.jpg'
            ]
        ],
        'Pasta' => [
            [
                'title' => 'Chicken Alfredo Pasta',
                'description' => 'Creamy pasta with chicken strips, olives and basil chiffonade.',
                'price' => 380,
                "image" => 'fullchickenalfredo.jpg'
            ],
            [
                'title' => 'Charlie Chan Pasta',
                'description' => 'Chicken strips, shiitake mushrooms and roasted peanuts in a spicy oriental sauce. Uniquely our own!',
                'price' => 400,
                "image" => 'fullcharliechan.jpg'
            ]
        ]
    ];

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        \Artisan::call('currency:manage add usd,eur', []);
        \Artisan::call('currency:update -o', []);

        foreach($this->categories as $categoryTitle => $products)
        {
            $category = factory(Category::class)->create([
                'title' => $categoryTitle
            ]);

            foreach($products as $product)
            {
                $product['category_id'] = $category->id;
                factory(Product::class)->create($product);
            }
        }
    }
}
<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=>$this->faker->name,
            'brand_id '=>Brand::take(1)->id,
            'category_id '=>Category::whereNot('parent_id',0)->take(1)->id,
            'slug '=>$this->faker->uniqid()->name,
            'primary_image'=>$this->faker->imageUrl,
            'description'=>$this->faker->text,
            'delivery_amount'=>Arr::random(['20000',15000,25000]),
        ];
    }
}

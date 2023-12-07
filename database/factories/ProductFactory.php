<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model=Product::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $count=rand(1,3);
        Category::factory()->hasChildren($count)->create();
        return [
            'name'=>$this->faker->name,
            'brand_id'=>Brand::factory(),
            'category_id'=>Category::where('parent_id','!=',0)->inRandomOrder()->first()->id,
            'slug'=>$this->faker->unique()->name,
            'primary_image'=>$this->faker->imageUrl,
            'description'=>$this->faker->text,
            'is_active'=>1,
            'delivery_amount'=>Arr::random(['20000',15000,25000]),
            'delivery_amount_per_product'=>Arr::random(['20000',15000,25000]),
        ];
    }
}

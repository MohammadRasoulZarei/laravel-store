<?php

namespace Database\Factories;

use App\Models\Banner;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Banner>
 */
class BannerFactory extends Factory
{
    protected $model = Banner::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'image'=>$this->faker->imageUrl,
            'title'=>$this->faker->title,
            'text'=>$this->faker->text,
            'priority'=>$this->faker->numberBetween(1,9),
            'type'=>new Sequence('bottom','topw')
        ];
    }
}

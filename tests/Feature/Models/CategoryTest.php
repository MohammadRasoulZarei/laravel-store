<?php

namespace Tests\Feature\Models;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function wtestCreateCategoryAsParent(): void
    {
        $count=rand(1,3);
        $category=Category::factory()->hasChildren($count)->create();

       $this->assertDatabaseHas('categories',['id'=>$category->id]);



    }
    public function testCreateAttributesForProduct(): void
    {
        $product = Product::factory()->create();
        Attribute::factory()->count(2)->hasAttached($product,['value'=>fake()->name()],'products')->create();
        Attribute::factory()->count(2)->hasAttached($product,[
            'price'=>200000,
            'quantity'=>10,
            'value'=>fake()->unique()->name(),
            'sku'=>fake()->unique()->title(),
        ],'createVariations')->create();

        $this->assertModelExists($product);


    }
    public function wtestCreateCategoryWithAtttributes(): void
    {
        $this->withoutExceptionHandling();

       // Category::factory()->has($childrern=Category::factory()->hasAttributes(4),'children')->create();
        Category::factory()->hasChildren()->create();
        $category=Category::where('parent_id','!=',0)->first();
        Attribute::factory()->count(3)->hasAttached($category,['is_filter'=>1])->create();
        Attribute::factory()->hasAttached($category,['is_variation'=>1])->create();

       $this->assertTrue(true);


    }


}

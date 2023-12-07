<?php

namespace Tests\Feature\Controllers\Admin;

use App\Models\Tag;
use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use App\Models\Brand;
use App\Models\Product;

use App\Models\Category;

use App\Models\Attribute;
use App\Models\ProductAttribute;
use App\Models\ProductVariation;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    public function test_index(): void
    {
        //  $this->withoutExceptionHandling();
        $user = User::factory()->has(Role::factory()->admin())->create();
        $response = $this->actingAs($user)
            ->get(route('admin.products.index'));

        $response->assertOk();
    }
    public function test_create(): void
    {
        //  $this->withoutExceptionHandling();
        $user = User::factory()->has(Role::factory()->admin())->create();
        $response = $this->actingAs($user)
            ->get(route('admin.products.create'));

        $response->assertOk();
    }
    public function test_show(): void
    {
        $this->withoutExceptionHandling();
        $product = Product::factory()->create();
        Brand::factory()->count(5)->create();

        $user = User::factory()->has(Role::factory()->admin())->create();
        $response = $this->actingAs($user)
            ->get(route('admin.products.show', ['product' => $product->id]));

        $response->assertOk();
    }
    public function test_Store(): void
    {
        $this->withoutExceptionHandling();
        $image = UploadedFile::fake()->image('image.png');
        $images = UploadedFile::fake()->image('image2.jpg');

        $product = Product::factory()->make()->toArray();

        $brands = Brand::factory()->count(5)->create();
        $brand = $brands->first()->id;

        $tags = Tag::factory()->count(5)->create()->pluck('id')->toArray();

        Category::factory()->hasChildren()->create();
        $category = Category::where('parent_id', '!=', 0)->first();
        $filters = Attribute::factory()->count(3)->hasAttached($category, ['is_filter' => 1])->create();
        $variation = Attribute::factory()->hasAttached($category, ['is_variation' => 1])->create();
        $category_id = $category->id;

        $attrs = [];
        foreach ($filters as $value) {
            $attrs[$value->id] = fake()->name;
        }



        // variation_values[value][]

        $vars = [
            'value' => ['good'],
            'price' => ['200000'],
            'quantity' => [10],
            'sku' => ['pro12'],
        ];
        $data = array_merge($product, [
            'primary_image' => $image,
            'brand_id' => $brand,
            'tag_ids' => $tags,
            'images' => [$images],
            'category_id' => $category_id,
            'attribute_ids' => $attrs,
            'variation_values' => $vars,
            'is_active' => 1
        ]);

        $user = User::factory()->has(Role::factory()->admin())->create();
        $response = $this->actingAs($user)
            ->post(route('admin.products.store'), $data);

        $response->assertRedirectToRoute('admin.products.index');
        // $response->assertOk();
    }
    public function test_edit()
    {
        $product = Product::factory()->create();
        $user = User::factory()->has(Role::factory()->admin())->create();
        $response = $this->actingAs($user)
        ->get(route('admin.products.edit', $product->id));
        $response->assertOk();
    }

    public function test_update(): void
    {
        $this->withoutExceptionHandling();

        $product = Product::factory()->create();
       $filters= Attribute::factory()->count(2)->hasAttached($product,['value'=>fake()->name()],'products')->create();
        $vars=Attribute::factory()->count(2)->hasAttached($product,[
            'price'=>200000,
            'quantity'=>10,
            'value'=>fake()->unique()->name(),
            'sku'=>fake()->unique()->title(),
        ],'createVariations')->create();
        $attrArry=$filters->pluck('id')->toArray();
        $filters=ProductAttribute::whereIn('attribute_id',$attrArry)->get();

        $attrArry=$vars->pluck('id')->toArray();
        $vars=ProductVariation::whereIn('attribute_id',$attrArry)->get();

        $brands = Brand::factory()->count(5)->create();
        $brand = $brands->first()->id;

        $tags = Tag::factory()->count(5)->create()->pluck('id')->toArray();


        $attrs = [];
        foreach ($filters as $value) {
            $attrs[$value->id] = fake()->name;
        }

        $varsArray = [];
        foreach ($vars as $value) {
            $varsArray[$value->id] = [
                'price' => '200000',
                'quantity' => 10,
                'sku' => 'pro12',
            ];
        }



        // variation_values[value][]


        $data = array_merge($product->toArray(), [

            'brand_id' => $brand,
            'tag_ids' => $tags,


            'attribute_values' => $attrs,
            'variation_values' => $varsArray,
            'is_active' => 1
        ]);
        $user = User::factory()->has(Role::factory()->admin())->create();
        $response = $this->actingAs($user)
            ->put(route('admin.products.update',$product->id), $data);

        $response->assertRedirectToRoute('admin.products.index');
        // $response->assertOk();
    }
}

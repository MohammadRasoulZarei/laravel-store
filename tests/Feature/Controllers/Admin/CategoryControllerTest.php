<?php

namespace Tests\Feature\Controllers\Admin;


use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testIndex(): void
    {
        $user = User::factory()->has(Role::factory()->admin())->create();
        $response = $this->actingAs($user)
        ->get(route('admin.categories.index'));

        $response->assertStatus(200);
    }
    public function testCreate(): void
    {
        $user = User::factory()->has(Role::factory()->admin())->create();
        $response = $this->actingAs($user)
            ->get(route('admin.categories.create'));

        $response->assertStatus(200);
    }

    public function testStore(): void
    {
        //   $this->withoutExceptionHandling();

        $data = Category::factory()->make()->toArray();
        $attributes = Attribute::factory()->count(rand(4, 7))->create();
        $attrIds = $attributes->pluck('id');
        $count = $attrIds->count();
        $attrArray = $attrIds->chunk($count - 1)->toArray();
        //  dd($attrObject->toArray());

        $data = array_merge(
            $data,
            [
                'attribute_ids' => $attrIds->toArray(),
                'attribute_is_filter_ids' => $attrArray[0],
                'variation_id' => $attrArray[1][$count - 1]
            ]
        );


        $user = User::factory()->has(Role::factory()->admin())->create();
        $response = $this->actingAs($user)
            ->post(route('admin.categories.store'), $data);

        $response->assertRedirect(route('admin.categories.store'));
    }
    public function testShow()
    {
        $category = Category::factory()->create();
        $user = User::factory()->has(Role::factory()->admin())->create();
        $response = $this->actingAs($user)
        ->get(route('admin.categories.show', ['category' => $category->id]));

        $response->assertStatus(200);
    }
    public function testEdit()
    {
        //  $this->withoutExceptionHandling();

        // $category = Category::factory()->create();
        // Attribute::factory()->count(3)->hasAttached($category, ['is_filter' => 1])->create();
        // Attribute::factory()->hasAttached($category, ['is_variation' => 1])->create();

        Category::factory()->hasChildren()->create();
        $category=Category::where('parent_id','!=',0)->first();
        Attribute::factory()->count(3)->hasAttached($category,['is_filter'=>1])->create();
        Attribute::factory()->hasAttached($category,['is_variation'=>1])->create();




        $user = User::factory()->has(Role::factory()->admin())->create();
        $response = $this->actingAs($user)
        ->get(route('admin.categories.edit', ['category' => $category->id]));

        $response->assertStatus(200);
    }
    public function testUpdate(): void
    {
          $this->withoutExceptionHandling();


        $data = Category::factory()->make()->toArray();
        $attributes = Attribute::factory()->count(rand(4, 7))->create();
        $attrIds = $attributes->pluck('id');
        $count = $attrIds->count();
        $attrArray = $attrIds->chunk($count - 1)->toArray();
        //  dd($attrObject->toArray());

        $data = array_merge(
            $data,
            [
                'attribute_ids' => $attrIds->toArray(),
                'attribute_is_filter_ids' => $attrArray[0],
                'variation_id' => $attrArray[1][$count - 1]
            ]
        );

        $category = Category::factory()->create();
        $user = User::factory()->has(Role::factory()->admin())->create();
        $response = $this->actingAs($user)
            ->put(route('admin.categories.update', $category->id), $data);

        $response->assertRedirect(route('admin.categories.index'));


    }
}

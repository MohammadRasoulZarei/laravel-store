<?php

namespace Tests\Feature\Models;

use Tests\TestCase;
use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testCreateCategoryAsParent(): void
    {
        $count=rand(1,3);
        $category=Category::factory()->hasChildren($count)->create();

       $this->assertDatabaseHas('categories',['id'=>$category->id]);


    }


}

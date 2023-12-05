<?php

namespace Tests\Feature\Controllers\Admin;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testIndex(): void
    {
    //  $this->withoutExceptionHandling();

        $response = $this->actingAs(User::factory()->create())
        ->get(route('admin.products.index'));

        $response->assertOk();
    }
    public function testCreate(): void
    {
    //  $this->withoutExceptionHandling();

        $response = $this->actingAs(User::factory()->create())
        ->get(route('admin.products.create'));

        $response->assertOk();
    }
    public function testShow(): void
    {
    //  $this->withoutExceptionHandling();
        $product=Product::all();
        dd($product);
        $response = $this->actingAs(User::factory()->create())
        ->get(route('admin.products.show',['Product'=>$product->id]));

        $response->assertOk();
    }

}

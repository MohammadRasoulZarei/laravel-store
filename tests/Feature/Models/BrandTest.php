<?php

namespace Tests\Feature\Models;

use Tests\TestCase;
use App\Models\Brand;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BrandTest extends TestCase
{
    /**
     * A basic feature test example.
     */


    public function testInsertData(): void
    {
        $brand = Brand::factory()->count(3)->create();
        $this->assertModelExists($brand->first());
    }
}

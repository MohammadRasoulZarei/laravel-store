<?php

namespace Tests\Feature\Models;

use App\Models\Banner;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BannerTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    public function testInsertData(): void
    {
        $banner=Banner::factory()->create();
        $this->assertModelExists($banner);
    }
}

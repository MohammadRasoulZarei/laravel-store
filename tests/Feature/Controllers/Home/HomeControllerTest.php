<?php

namespace Tests\Feature\Controllers\Home;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testIndex(): void
    {
        $response = $this->get('/');
       // $response = $this->get(route('home.index'));

        $response->assertStatus(200);
    //  $response->assertOk();
        $response->assertViewIs('home.index');
        $response->assertViewHasAll(['sliders','banners']);
    }
}

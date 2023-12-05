<?php

namespace Tests\Feature\Views\homw;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class layoutTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testAuthUserlayout(): void
    {
        $user=User::factory()->create();
        $this->actingAs($user);
        $view = $this->view('home.layouts.home');
        $view->assertSee('پروفایل</a></li>',false);


    }
    public function testguestUserlayout(): void
    {

        $view = $this->view('home.layouts.home');
        $view->assertDontSee('پروفایل</a></li>',false);
    }
}

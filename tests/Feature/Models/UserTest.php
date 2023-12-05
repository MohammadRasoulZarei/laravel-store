<?php

namespace Tests\Feature\Models;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function testInsertData(): void
    {
       $user= User::factory()->create();
        $this->assertModelExists($user);
    }
}
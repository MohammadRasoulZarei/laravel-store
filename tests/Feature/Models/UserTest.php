<?php

namespace Tests\Feature\Models;

use Tests\TestCase;
use App\Models\Role;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{

    /**
     * A basic feature test example.
     */
    // public function testInsertData(): void
    // {
    //    $user= User::factory()->create();
    //     $this->assertModelExists($user);
    // }
    // public function testCreateAdminUser(): void
    // {
    //    $user= User::factory()->has(Role::factory()->state(['name'=>'admin','display_name'=>'admin']))->create();
    //     $this->assertModelExists($user);
    // }
    public function wtestrolegeneration(): void
    {
        User::factory()->has(Role::factory()->state(['name'=>'admin','display_name'=>'admin']))->create();
       Role::factory()->count(3)->create();
    }
}

<?php

namespace Database\Factories;

use Illuminate\Support\Arr;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class RoleFactory extends Factory
{
    protected $model=Role::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $role=Arr::random(['admin','user','writer']);
        return [
            'name'=>$role,
            'display_name'=>$role,

        ];
    }
    public function admin()
    {
        return $this->state(function($attr){
            return [
                'name'=>'admin',
                'display_name'=>'admin',

            ];
        });

    }

}

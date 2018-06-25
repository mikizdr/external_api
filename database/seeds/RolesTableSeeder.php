<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::truncate();

        $roles = ['member', 'trainer', 'owner'];

        foreach ($roles as $key => $role) {
            Role::create([
                'name' => $role
            ]);
        }
    }
}

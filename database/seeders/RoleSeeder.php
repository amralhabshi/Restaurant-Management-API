<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
        'owner',
        'manager',
        'cashier',
    ];

    foreach ($roles as $role) {
        Role::firstOrCreate([
            'name' => $role
        ]);
        }

        $owner = Role::where('name', 'owner')->firstOrFail();
        $manager = Role::where('name', 'manager')->firstOrFail();
        $cashier = Role::where('name', 'cashier')->firstOrFail();

        $owner->permissions()->sync(
        Permission::all()->pluck('id')
        );

       $manager->permissions()->sync(
        Permission::whereIn('name', [
            'create_branch',
            'edit_branch',
            'view_branch',
        ])->pluck('id')
        );

        $cashier->permissions()->sync(
        Permission::whereIn('name', [
            'view_branch',
        ])->pluck('id')
        );
    }
}

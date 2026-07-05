<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
        'create_branch',
        'edit_branch',
        'delete_branch',
        'view_branch',
    ];

    foreach ($permissions as $permission) {
        Permission::firstOrCreate([
            'name' => $permission
        ]);
        }
    }
}
<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [

            'create-order',
            'update-order',
            'delete-order',
            'view-order',

            'create-reservation',
            'update-reservation',
            'cancel-reservation',

            'view-invoice',

            'create-payment',

            'refund-order',

            'manage-users',

            'manage-roles',

            'view-reports',
        ];

        foreach ($permissions as $permission) {

            Permission::create([
                'name' => $permission,
            ]);
        }
    }
}
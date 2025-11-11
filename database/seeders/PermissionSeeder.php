<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'view roles', 'create roles', 'edit roles',
            'view updates', 'create updates', 'edit updates', 'view activity logs',
            'view admins', 'create admins', 'view purchases',
            'view dashboard', 'view users', 'view messages', 'create messages', 'send messages',
            'view logs', 'manage uploads', 'manage contacts', 'manage settings'
        ];

        foreach ($permissions as $perm) {
            Permission::updateOrCreate(['name' => $perm]);
        }
    }
}

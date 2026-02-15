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
            'view contacts', 'manage contacts',
            'view blogs', 'create blogs', 'edit blogs', 'view activity logs',
            'view admins', 'create admins', 'view subscriptions',
            'view dashboard', 'view users', 'view messages', 'create messages', 'send messages',
            'view logs', 'create subscriptions', 'manage subscriptions', 'manage settings', 'view subscription-links'
        ];

        foreach ($permissions as $perm) {
            Permission::updateOrCreate(['name' => $perm]);
        }
    }
}

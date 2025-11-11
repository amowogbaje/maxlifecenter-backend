<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Database\Seeders\PermissionSeeder;
use App\Models\Role;
use App\Models\Permission;

class SyncPermissions extends Command
{
    protected $signature = 'permissions:sync';
    protected $description = 'Sync permissions from PermissionSeeder without duplicates';

    public function handle()
    {
        $this->info('🔄 Syncing permissions...');

        // Step 1: Run your existing seeder
        $this->call(PermissionSeeder::class);

        // Step 2: Get the admin role
        $role = Role::find(1);

        if (! $role) {
            $this->error('❌ Role with ID 1 not found.');
            return;
        }

        // Step 3: Attach any permissions not already linked
        $newPermissions = Permission::whereDoesntHave('roles', function ($q) use ($role) {
            $q->where('role_id', $role->id);
        })->pluck('id');

        if ($newPermissions->isEmpty()) {
            $this->info('ℹ️ No new permissions to attach.');
            return;
        }

        $role->permissions()->attach($newPermissions);

        $this->info('✅ Synced and attached new permissions to Role ID 1.');
    }
}

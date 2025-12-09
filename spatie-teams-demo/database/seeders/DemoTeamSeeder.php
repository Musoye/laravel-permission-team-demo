<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Support\Facades\Hash;

class DemoTeamSeeder extends Seeder
{
    public function run()
    {
        // Clear cached permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create a team
        $team = Team::create(['name' => 'Alpha Team']);

        // Set the team context for roles/permissions
        app(PermissionRegistrar::class)->setPermissionsTeamId($team->id);

        // Create permissions & roles
        $createForm = Permission::firstOrCreate([
            'name' => 'create-form',
            'guard_name' => 'web'
        ]);

        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);

        $editorRole = Role::firstOrCreate([
            'name' => 'editor',
            'guard_name' => 'web'
        ]);

        // Create a demo user
        $user = User::firstOrCreate(
            ['email' => 'demo@local.test'],
            [
                'name' => 'Demo User',
                'password' => Hash::make('password'),
            ]
        );

        // Add user to team_user pivot
        $team->users()->syncWithoutDetaching([$user->id]);

        // Assign role & permission (team context is already set)
        $user->assignRole($editorRole->name);
        $user->givePermissionTo('create-form');
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Support\Facades\Hash;

class CreatorRoleSeeder extends Seeder
{
    public function run()
    {
        // Clear cached permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create a team (or get existing)
        $team = Team::firstOrCreate(['name' => 'Alpha Team']);

        // Set team context for team-scoped roles/permissions
        app(PermissionRegistrar::class)->setPermissionsTeamId($team->id);

        // Create the 'create-form' permission
        $createForm = Permission::firstOrCreate([
            'name' => 'create-form',
            'guard_name' => 'web',
        ]);

        // Create the 'creator' role and attach the permission
        $creatorRole = Role::firstOrCreate([
            'name' => 'creator',
            'guard_name' => 'web',
        ]);
        $creatorRole->givePermissionTo($createForm);

        // Create a demo user
        $user = User::firstOrCreate(
            ['email' => 'creator@local.test'],
            [
                'name' => 'Creator User',
                'password' => Hash::make('password'),
            ]
        );

        // Add user to the team
        $team->users()->syncWithoutDetaching([$user->id]);

        // Assign the 'creator' role to the user
        $user->assignRole($creatorRole->name);

        echo "User '{$user->name}' now has role 'creator' with 'create-form' permission in team '{$team->name}'.\n";
    }
}

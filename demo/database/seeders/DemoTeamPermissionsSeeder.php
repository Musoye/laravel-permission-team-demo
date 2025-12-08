<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Team;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DemoTeamPermissionsSeeder extends Seeder
{
    public function run()
    {
        $alice = User::create([
            'name' => 'Alice',
            'email' => 'alice@example.com',
            'password' => Hash::make('password')
        ]);

        $bob = User::create([
            'name' => 'Bob',
            'email' => 'bob@example.com',
            'password' => Hash::make('password')
        ]);

        $team1 = Team::create(['name' => 'Marketing']);
        $team2 = Team::create(['name' => 'Engineering']);

        Permission::create(['name' => 'create-form']);
        Permission::create(['name' => 'edit-form']);

        $editor = Role::create(['name' => 'editor']);
        $viewer = Role::create(['name' => 'viewer']);

        setPermissionsTeamId($team1->id);
        $editor->givePermissionTo('create-form', $team1->id);

        setPermissionsTeamId($team2->id);
        $editor->givePermissionTo('create-form', $team2->id);

        $alice->assignRole('editor', $team1->id);
        $bob->assignRole('viewer', $team1->id);

        $alice->assignRole('viewer', $team2->id);
        $bob->assignRole('editor', $team2->id);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\PermissionRegistrar;

class TeamController extends Controller
{
    public function dashboard(Request $request, Team $team)
    {
        // set permission team context
        app(PermissionRegistrar::class)->setPermissionsTeamId($team->id);

        $permissions = auth()->user()
            ? auth()->user()->getAllPermissions()->pluck('name')
            : collect();

        return Inertia::render('Team/Dashboard', [
            'team' => $team,
            'permissions' => $permissions,
            'forms' => $team->forms()->with('creator')->get()->toArray(),
        ]);
    }
}

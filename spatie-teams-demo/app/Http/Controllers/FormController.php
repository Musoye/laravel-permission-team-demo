<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Team;
use Illuminate\Http\Request;
use Spatie\Permission\PermissionRegistrar;

class FormController extends Controller
{
    public function create(Team $team)
    {
        // show create page - but in this small demo we will use the TeamDashboard for UI
        return redirect()->route('team.dashboard', $team);
    }

    public function store(Request $request, Team $team)
    {
        // set team context for permission checks
        app(PermissionRegistrar::class)->setPermissionsTeamId($team->id);

        $user = $request->user();

        if (! $user->can('create-form')) {
            abort(403, 'Forbidden — you do not have permission to create a form in this team.');
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'payload' => 'nullable|string',
        ]);

        $form = Form::create([
            'team_id' => $team->id,
            'created_by' => $user->id,
            'title' => $data['title'],
            'payload' => $data['payload'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Form created.');
    }
}

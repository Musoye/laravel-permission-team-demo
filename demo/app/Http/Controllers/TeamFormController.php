<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamFormController extends Controller
{
    public function index(Team $team)
    {
        setPermissionsTeamId($team->id);

        return inertia('TeamForms', [
            'team' => $team,
            'forms' => Form::where('team_id', $team->id)->with('author')->get(),
            'permissions' => auth()->user()->getPermissionsViaRoles()->pluck('name'),
        ]);
    }

    public function store(Request $request, Team $team)
    {
        setPermissionsTeamId($team->id);

        if (!auth()->user()->can('create-form')) {
            abort(403, 'Not allowed.');
        }

        $data = $request->validate([
            'title' => 'required',
            'content' => 'nullable',
        ]);

        Form::create([
            'team_id' => $team->id,
            'user_id' => auth()->id(),
            'title' => $data['title'],
            'content' => $data['content']
        ]);

        return back();
    }
}

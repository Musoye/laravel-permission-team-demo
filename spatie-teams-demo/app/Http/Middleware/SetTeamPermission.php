<?php

namespace App\Http\Middleware;

use Closure;
use Spatie\Permission\PermissionRegistrar;

class SetTeamPermission
{
    public function handle($request, Closure $next)
    {
        $user = $request->user();

        if ($user && $user->currentTeam) {
            app(PermissionRegistrar::class)->setPermissionsTeamId(
                $user->currentTeam->id
            );
        }

        return $next($request);
    }
}

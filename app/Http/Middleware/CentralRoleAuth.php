<?php

namespace App\Http\Middleware;

use App\Models\Role;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CentralRoleAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Abort if user is note authenticated
        abort_if(! auth()->check(), 403);

        /** @var User $user */
        $user = auth()->user();

        // Abort if the user doesn't have the role Super Admin
        abort_if(! $user->hasRole(Role::SUPER_ADMIN), 403);

        return $next($request);
    }
}

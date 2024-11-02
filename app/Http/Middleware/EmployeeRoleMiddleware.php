<?php

namespace App\Http\Middleware;

use App\Models\Employee;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EmployeeRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $role, $permission = null)
    {
        $employee = Employee::findOrFail(Auth::guard('employee')->user()->id);

        if (!$employee || !$employee->hasRole($role)) {
            abort(404);
        }

        if ($permission !== null && !$employee->can($permission)) {
            abort(404);
        }

        return $next($request);
    }
}

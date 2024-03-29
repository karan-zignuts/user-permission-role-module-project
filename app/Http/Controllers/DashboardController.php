<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;


class DashboardController extends Controller
{
    public function index()
    {
        $totalActiveModules = Module::where('is_active', true)->count();
        $totalActivePermissions = Permission::where('is_active', true)->count();
        $totalActiveRoles = Role::where('is_active', true)->count();
        $totalActiveUsers = User::where('is_active', true)->count();

        // Debug statements
        // dd($totalActiveModules, $totalActivePermissions, $totalActiveRoles, $totalActiveUsers);

        return view('dashboard')->with([
            'totalActiveModules' => $totalActiveModules,
            'totalActivePermissions' => $totalActivePermissions,
            'totalActiveRoles' => $totalActiveRoles,
            'totalActiveUsers' => $totalActiveUsers,
        ]);
    }
}

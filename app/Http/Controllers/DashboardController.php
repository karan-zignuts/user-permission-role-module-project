<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
class DashboardController extends Controller
{
    // Display the dashboard with summary data
    public function index()
    {
        // Define variables
        $totalActiveModules = Module::where('is_active', true)->count();
        $totalActivePermissions = Permission::where('is_active', true)->count();
        $totalActiveRoles = Role::where('is_active', true)->count();
        $totalActiveUsers = User::where('is_active', true)->count();

        // Pass variables to the view
        return view('dashboard', [
            'totalActiveModules' => $totalActiveModules,
            'totalActivePermissions' => $totalActivePermissions,
            'totalActiveRoles' => $totalActiveRoles,
            'totalActiveUsers' => $totalActiveUsers,
        ]);
    }
}

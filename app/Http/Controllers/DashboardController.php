<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;


class DashboardController extends Controller
{
  // In your DashboardController

  public function index()
  {
      $totalActiveModules = Module::where('active', true)->count();
      $totalActivePermissions = Permission::where('active', true)->count();
      $totalActiveRoles = Role::where('active', true)->count();
      $totalActiveUsers = User::where('active', true)->count();
  }
}

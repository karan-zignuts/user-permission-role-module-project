<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class MenuServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   */
  public function register(): void
  {
    //
  }
  /**
   * Bootstrap services.
   *
   *
   *
   * 7+-
   */
  public function boot(): void
  {
    //this is used for both admin and user menu it's take json data from verticalMenu.json
    $verticalMenuJson = file_get_contents(base_path('resources/menu/verticalMenu.json'));
    $verticalMenuData = json_decode($verticalMenuJson);

    \View::share('menuData', $verticalMenuData);
  }
}

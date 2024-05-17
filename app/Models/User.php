<?php

// namespace App\Models;

// // use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;

// class User extends Authenticatable
// {
//   use HasApiTokens, HasFactory, Notifiable;

//   /**
//    * The attributes that are mass assignable.
//    *
//    * @var array<int, string>
//    */

//   protected $fillable = [
//     'first_name',
//     'last_name',
//     'email',
//     'phone_number',
//     'address',
//     'password',
//     'role_id',
//     'is_active',
//     'invitation_token',
//     'created_by',
//     'updated_by',
//   ];
//   /**
//    * The attributes that should be hidden for serialization.
//    *
//    * @var array<int, string>
//    */
//   protected $hidden = ['password', 'remember_token'];

//   /**
//    * The attributes that should be cast.
//    *
//    * @var array<string, string>
//    */
//   protected $casts = [
//     'email_verified_at' => 'datetime',
//   ];

//   public function roles()
//   {
//     return $this->belongsToMany(Role::class, 'user_roles');
//   }

//   public function permissions()
//   {
//     return $this->hasManyThrough(Permission::class, Role::class);
//   }
//   public function hasPermissionToCreateActivities()
//   {
//       // Check if the user has a specific role that grants permission to create activities
//       return $this->role === 'admin' || $this->role === 'manager';
//   }
// }

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['first_name', 'last_name', 'email', 'phone_number', 'address', 'password', 'role_id', 'is_active', 'invitation_token', 'created_by', 'updated_by'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function permissions()
    {
        return $this->hasManyThrough(Permission::class, Role::class);
    }

    public function hasUserAccess($moduleCode, $action)
    {
        foreach ($this->roles as $role) {
            if ($role->hasRole($moduleCode, $action)) {
                // dd($moduleCode);
                return true;
            }
        }
        return false;
    }


    public function hasPermissionTo($permissionName)
    {
      // Example logic to check if the user has the given permission
      foreach ($this->roles as $role) {
        foreach ($role->permissions as $permission) {
          if ($permission->name === $permissionName) {
            dd($permission->name);
                    return true;
                }
            }
        }
        return false;
    }
    // public function hasPermissionToo(string $permissionName): bool
    // {
    //     // Check if the user has any roles
    //     if ($this->roles->isEmpty()) {
    //         return false;
    //     }

    //     // Check each role for the given permission
    //     foreach ($this->roles as $role) {
    //         // Check if the role has any permissions
    //         if ($role->permissions->isEmpty()) {
    //             continue;
    //         }

    //         // Check if the role has the given permission
    //         $permissions = $role->permissions->pluck('name');
    //         if ($permissions->contains($permissionName)) {
    //             return true;
    //         }
    //     }

    //     return false;
    // }
}

<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use App\Traits\HasRoleAndPermission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Testing\Fluent\Concerns\Has;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function checkPermissionTo($permission)
    {
        // dd($this->permissions->contains('name', $permission));
        if ($this->permissions && $this->permissions->contains('name', $permission)) {
            return true;
        }
        return false;
    }

//     public function checkPermissionTo($permission)
// {
//     $user = Auth::user();
    
//     // Ensure that $user->role->permissions is a collection, not a string
//     $permissions = $user->role->permissions;

//     // Check if it's a collection (an Eloquent Collection)
//     if ($permissions instanceof \Illuminate\Database\Eloquent\Collection) {
//         // Clean the permission names by removing square brackets and quotes
//         $cleanedPermissions = $permissions->map(function($perm) {
//             return str_replace(['[', ']', '"'], '', $perm->name);
//         });

//         // Now check if the user has the permission
//         if ($cleanedPermissions->contains($permission)) {
//             return response()->json(['message' => 'User has permission!']);
//         } else {
//             return response()->json(['message' => 'User does not have permission.']);
//         }
//     } else {
//         // If permissions isn't a collection, handle the error
//         return response()->json(['message' => 'Invalid permission data.']);
//     }
// }

    
}

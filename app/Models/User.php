<?php
namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasRoles;

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

    /**
     * Get the roles associated with the user.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Get the permissions from all the user's roles.
     *
     * @return \Illuminate\Support\Collection
     */public function permissions()
{
    // Check if the user has the super-admin role
    if ($this->roles->contains('slug', 'super-admin')) {
        // Fetch all permissions from the permissions table
        return DB::table('permissions')->pluck('name');
    }

    // Get all roles associated with the user
    $roles = $this->roles;

    // Use flatMap to merge all the permissions stored as JSON in each role
    return $roles->flatMap(function ($role) {
        $permissions = json_decode($role->permissions, true);
        return $permissions;
    })->unique(); // Remove duplicate permissions
}
    /**
     * Check if the user has any of the given permissions.
     *
     * @param  array  $permissions
     * @return bool
     */
    public function hasAnyPermissions(array $permissions)
    {
        
        $userPermissions = $this->permissions();

        // dd($userPermissions);

        return collect($permissions)->some(function ($permission) use ($userPermissions) {
            return $userPermissions->contains($permission);
        });
    }

    /**
     * Check if the user has a specific permission.
     *
     * @param  string  $slug
     * @return bool
     */
    public function checkPermissionTo($slug)
    {
        $userPermissions = $this->permissions();

        // dd($userPermissions);
        return $userPermissions->contains($slug);
    }
}
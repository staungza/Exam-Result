<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\RolePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Permission;
use App\Policies\PermissionPolicy;
use Spatie\Permission\Models\Role;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
      
        
        // $role = Role::query()->where('name', '{"en": "Admin", "mm": "အတ်မင်"}')->first();
       

        // $permission = Permission::where('name', '{"en": "student-view", "mm": "စာရင်း", "type": "view"}')->first();
        // $role->givePermissionTo($permission);
    
     
        // $user = User::find(1);
        // $user->givePermissionTo('student-view');

        Gate::policy(Role::class, RolePolicy::class);
        Gate::policy(Permission::class, PermissionPolicy::class);
    }
}

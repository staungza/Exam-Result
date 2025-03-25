<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;


class SyncRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roles:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $superAdminRole = DB::table('roles')->where('slug', 'super-admin')->first();
        if (!$superAdminRole) {
            DB::table('roles')->insert([
                'name' => 'Super Admin',
                'guard_name' => 'web',
                'slug' => 'super-admin',
                'permissions' => json_encode([]), // Will be updated below
                'level' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $superAdminRole = DB::table('roles')->where('slug', 'super-admin')->first();
        }

        // Fetch all roles
        $roles = DB::table('roles')->get();

        foreach ($roles as $role) {
            // Fetch all permissions for the role's guard
            $permissions = DB::table('permissions')
                ->where('guard_name', $role->guard_name)
                ->pluck('name')
                ->toArray();

            // Update the role with the permissions
            DB::table('roles')
                ->where('id', $role->id)
                ->update(['permissions' => json_encode($permissions)]);
        }

        $this->info('Roles have been synced with permissions.');
    
    }
}
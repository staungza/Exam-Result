<?php

namespace App\Console\Commands;
use App\Models\Role;
use App\Models\Permission1;
use Illuminate\Support\Str;
use Illuminate\Console\Command;


class Permission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:permission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */

     public function __construct()
    {
        parent::__construct();
    }
    public function handle()
    {
        $this->refreshPermission();
        $this->updateAdminRolePermission();
    }

    public function refreshPermission(){
        
       Permission1::truncate();
        $count =0;
        $permissions = config('permissions');
       
        foreach($permissions as $group => $permissionGroup){
            foreach($permissionGroup as $permission ){
            Permission1::create([
                    'name' => $permission,
                    'slug' => Str::slug($permission['en']),
                    'group' => $group
                ]);
            }
            $count = $count + 1;
        }
        $this->info('---- Total Install : ' . $count . ' ----');
    }

    protected function updateAdminRolePermission()
    {
        $permissions = Permission1::pluck('slug');

        Role::where('slug', '=', 'super-admin')->update([
            'permissions' => $permissions
        ]);
        
        $this->info('---- Updated Super Admin Permission ----');
        
    }
}

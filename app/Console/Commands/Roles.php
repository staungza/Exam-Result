<?php

namespace App\Console\Commands;

use App\Models\Role;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Roles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:roles';

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
         $this->info('********** Start - Config Clear **********');

         Artisan::call("config:clear");

         $this->info('********** End - Config Clear **********');
         
         $roles = config('roles');

         $this->info('********** Start - Role Table Fresh **********');

         Role::truncate();

         $this->info('********** End - Role Table Fresh **********');

         $this->info('********** Start - Add Roles & Permissions **********');

         $count = 0;

         
         
         foreach ($roles as $role){
            $count++;

            $permissions = $role['permissions'];

            Role::create([
                "id" => $role['id'],
                'name' => $role['name'],
                'slug' => $role['slug'],
                'permissions' => $permissions,
                'level' => $role['level'],
            ]);

            $this->info('********** "Roles" ' . $count . ' are inserted & "Permissions" are synchronized. **********');

            $this->info('********** End - Add Roles & Permissions **********');
         }

    }
}

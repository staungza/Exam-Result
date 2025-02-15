<?php
// app/Traits/CheckPermission.php

namespace App\Traits;

use Illuminate\Support\Facades\Gate;

trait CheckPermission
{
    // This method checks if the current authenticated user has the permission
    public function hasPermission($permission)
    {
        return null;
    }

  

}


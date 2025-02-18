<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'permissions',
        'level',
        'slug',
    ];

    protected $casts = [
        'name' => 'json',
        'permissions' => 'json',
    ];
    public function users(){

        return $this->belongsToMany(User::class);
        
    }

    public function checkPermissionTo($slug)
    {
        dd($this->permissions);
        return in_array($slug, $this->permissions);
    }
}

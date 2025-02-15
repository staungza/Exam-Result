<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission1 extends Model
{
    use HasFactory;

    protected $table = 'permissions';
    protected $fillable = ['name', 'slug', 'group'];

    protected $casts = [
        'name' => 'json',
    ];

    public static function getForRoleAttachment($slugs)
    {
        return static::whereIn('slug', $slugs)->get()->map(function ($item) {
            return $item->slug;
        })->toArray();
    }
}

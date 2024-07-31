<?php

namespace App\Models;

use App\Models\Region;
use App\Models\Quarter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Township extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'region_id'
    ];

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }
    public function quarter(): HasMany
    {
        return $this->hasMany(Quarter::class);
    }

    public function students():HasMany
    {
        return $this->hasMany(Student::class);
    }

}

<?php

namespace App\Models;

use App\Models\Region;
use App\Models\Quarter;
use App\Models\Township;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory;
    
    public function township(): HasMany
    {
        return $this->hasMany(Township::class);
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }



    public function quarter(): HasMany
    {
        return $this->hasMany(Quarter::class);
    }




}

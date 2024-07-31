<?php

namespace App\Models;

use App\Models\Student;
use App\Models\Township;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quarter extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'township_id',
        'postal_code'
    ];
    public function township(): BelongsTo
    {
        return $this->belongsTo(Township::class);
    }

    public function students():HasMany
    {
        return $this->hasMany(Student::class);
    }
   
   

}

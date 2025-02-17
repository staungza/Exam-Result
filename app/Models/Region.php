<?php

namespace App\Models;

use App\Models\Result;
use App\Models\Student;
use App\Models\Township;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Region extends Model
{
    use HasFactory;
    //protected $fillable = ['name'];
   


    public function township(): HasMany
    {
        return $this->hasMany(Township::class);
    }

    public function students():HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function result(): BelongsTo
    {
         return $this->belongsTo(Result::class);
    }
   

   
}

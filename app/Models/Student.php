<?php

namespace App\Models;


use App\Models\Region;
use App\Models\Result;
use App\Models\Quarter;
use App\Models\Township;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
     use HasFactory;
     protected $fillable = [
          'roll_no',
          'student_name',
          'father_name',
          'major',
          'region_id',
          'township_id',
          'quarter_id',
          'date_of_birth'

     ];

     protected $guardded = [];
     public function region(): BelongsTo
     {
          return $this->belongsTo(Region::class);
     }

     public function township(): BelongsTo
     {
          return $this->belongsTo(Township::class);
     }

     public function quarter(): BelongsTo
     {
          return $this->belongsTo(Quarter::class);
     }
     public function results()
     {
          return $this->hasMany(Result::class, 'roll_no', 'roll_no');
     }



}

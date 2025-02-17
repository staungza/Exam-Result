<?php

namespace App\Models;

use App\Models\Region;
use App\Models\Quarter;
use App\Models\Student;
use App\Models\Township;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Result extends Model
{
    use HasFactory;
    protected $fillable=[
        'roll_no',
        'student_name',
        'myanmar',
        'english',
        'mathematics',
        'chemistry',
        'physics',
        'biological',
        'region_id',
        'township_id',
        'passorfail'
    ];

     public function students()
     {
     return $this->belongsTo(Student::class, 'roll_no', 'roll_no');
     }

    public function region(): hasMany
    {
         return $this->hasMany(Region::class);
    }

    public function township(): BelongsTo
    {
         return $this->belongsTo(Township::class);
    }

    public function quarter(): BelongsTo
    {
         return $this->belongsTo(Quarter::class);
    }
}

<?php

namespace App\Models;

use App\Models\Reading;
use App\Models\Section;
use App\Models\Condition;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Probe extends Model
{
    use HasFactory;

    protected $fillable = ['uuid', 'section_id', 'condition_id', 'max_threshold', 'min_threshold', 'serial', 'description'];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    public function readings()
    {
        return $this->hasMany(Reading::class);
    }
}

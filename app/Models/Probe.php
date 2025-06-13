<?php

namespace App\Models;

use App\Models\Reading;
use App\Models\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Probe extends Model
{
    use HasFactory;

    protected $fillable = ['uuid', 'section_id', 'max_threshold', 'min_threshold', 'description'];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function readings()
    {
        return $this->hasMany(Reading::class);
    }
}

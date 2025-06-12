<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

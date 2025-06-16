<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcessingLine extends Model
{
    protected $fillable = ['uuid', 'section_id', 'description'];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}

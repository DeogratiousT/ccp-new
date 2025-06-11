<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reading extends Model
{
    use HasFactory;

    protected $fillable = ['probe_id', 'value', 'time_stamp'];

    public function probe()
    {
        return $this->belongsTo(Probe::class);
    }
}

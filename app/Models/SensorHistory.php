<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'sensor_summary_id',
        'pattern_id',
        'sensor_id',
        'line_id',
        'time',
        'duration',
        'status'
    ];

    public function pattern()
    {
        return $this->belongsTo(Pattern::class);
    }

    public function sensor()
    {
        return $this->belongsTo(Sensor::class);
    }

    public function line()
    {
        return $this->belongsTo(Line::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorSummary extends Model
{
    protected $fillable = [
        'work_hour_id',
        'pattern_id',
        'sensor_id',
        'line_id',
        'summary',
        'average',
        'maximal',
        'minimal',
    ];

    public function line(){
        return $this->belongsTo(Line::class);
    }

    // Relation to WorkHours - Many to One
    public function workHour(){
        return $this->belongsTo(WorkHour::class);
    }

    // Relation to Patterns - Many to One
    public function pattern(){
        return $this->belongsTo(Pattern::class);
    }

    // Relation to Sensors - Many to One
    public function sensor(){
        return $this->belongsTo(Sensor::class);
    }
}

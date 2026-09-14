<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pattern extends Model
{
    protected $fillable = [
        'name',
        'cycle_time',
        'max_time',
        'min_time',
        'line_id',
    ];

    public function line()
    {
        return $this->belongsTo(\App\Models\Line::class);
    }

    // Relation to Sensors - Many to Many
    public function sensors(){
        return $this->belongsToMany(Sensor::class, 'pattern_sensor')->withPivot('pos')->withTimestamps();
    }

    // Relation to Sensor Summaries - has Many
    public function sensorSummaries(){
        return $this->hasMany(SensorSummary::class);
    }
}

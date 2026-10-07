<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    protected $fillable = ['name', 'line_id'];

    public function line(){
        return $this->belongsTo(Line::class);
    }

    // Relation to Patterns - Many to Many
    public function patterns(){
        return $this->belongsToMany(Pattern::class, 'pattern_sensor')->withTimestamps();
    }

    // Relation to Histories - One to Many
    public function histories(){
        return $this->hasMany(SensorHistory::class, 'sensor_id');
    }

    // Relation to Sensor Summaries - One to Many
    public function sensorSummaries(){
        return $this->hasMany(SensorSummary::class);
    }
}

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
        'except_time',
        'line_id',
    ];

    public function line()
    {
        return $this->belongsTo(\App\Models\Line::class);
    }

    // Relation to Sensors - Many to Many
    public function sensors(){
        return $this->belongsToMany(Sensor::class, 'pattern_sensor')->withPivot('pos', 'cycle')->withTimestamps();
    }

    /**
     * Label POS tiap sensor pada pattern ini: [sensor_id => 'POS n'].
     */
    public function posLabels(): array
    {
        return $this->sensors
            ->mapWithKeys(fn ($sensor) => [$sensor->id => 'POS ' . $sensor->pivot->pos])
            ->all();
    }

    // Relation to Sensor Summaries - has Many
    public function sensorSummaries(){
        return $this->hasMany(SensorSummary::class);
    }
}

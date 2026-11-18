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

    /**
     * Sembunyikan data sampah: pembacaan dengan duration < except_time milik
     * pattern-nya (trigger tidak sengaja). Baris yang durasinya belum dihitung
     * (null) tetap disertakan.
     */
    public function scopeAboveExceptTime($query)
    {
        $table = $this->getTable();

        return $query->where(function ($q) use ($table) {
            $q->whereNull("{$table}.duration")
              ->orWhereRaw(
                  "{$table}.duration >= COALESCE((SELECT patterns.except_time FROM patterns WHERE patterns.id = {$table}.pattern_id), 0)"
              );
        });
    }

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

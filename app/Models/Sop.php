<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sop extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sop_no',
        'revision',
        'link',
        'line_id',
    ];

    public function riskAssessment()
    {
        return $this->hasOne(RiskAssessment::class, 'sop_id');
    }

    // Ambil 1 RA yang sedang terhubung (karena cuma 1 aktif per SOP)
    public function activeRiskAssessment()
    {
        return $this->hasOne(RiskAssessment::class, 'sop_id');
    }

    public function line()
    {
        return $this->belongsTo(Line::class);
    }

    public function machines()
    {
        return $this->belongsToMany(Machine::class, 'machine_sop', 'sop_id', 'machine_id')->withTimestamps();
    }

    public function dasgs()
    {
        return $this->belongsToMany(Dasg::class, 'dasg_sop', 'sop_id', 'dasg_id')->withTimestamps();
    }
}

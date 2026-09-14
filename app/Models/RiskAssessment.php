<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'ra_no',
        'ra_level',
        'ra_security_rank',
        'revision',
        'link',
        'line_id',
    ];

    public function sop()
    {
        return $this->hasOne(Sop::class, 'ra_id');
    }

    public function line()
    {
        return $this->belongsTo(Line::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    use HasFactory;

    protected $fillable = ['bu_id', 'name', 'pokayoke_path', 'kanban_path'];

    public function businessUnit()
    {
        return $this->belongsTo(BusinessUnit::class, 'bu_id');
    }

    public function sops()
    {
        return $this->hasMany(Sop::class);
    }

    public function riskAssessments()
    {
        return $this->hasMany(RiskAssessment::class);
    }

    public function dasgs()
    {
        return $this->hasMany(Dasg::class);
    }

    public function ncds()
    {
        return $this->hasMany(Ncd::class);
    }

    public function linePerformances()
    {
        return $this->hasMany(LinePerformance::class);
    }

    public function productSummaries()
    {
        return $this->hasMany(ProductSummary::class);
    }

    public function productIns()
    {
        return $this->hasMany(ProductIn::class);
    }

    public function productOuts()
    {
        return $this->hasMany(ProductOut::class);
    }

    public function patterns()
    {
        return $this->hasMany(Pattern::class);
    }

    public function machines()
    {
        return $this->hasMany(Machine::class);
    }
}

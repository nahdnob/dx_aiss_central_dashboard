<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = ['plant_id', 'section_no', 'name'];

    public function plant()
    {
        return $this->belongsTo(Plant::class);
    }

    public function businessUnits()
    {
        return $this->hasMany(BusinessUnit::class);
    }
}

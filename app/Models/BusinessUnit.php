<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessUnit extends Model
{
    use HasFactory;

    protected $fillable = ['section_id', 'bu_no', 'name'];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function lines()
    {
        return $this->hasMany(Line::class, 'bu_id');
    }
}
